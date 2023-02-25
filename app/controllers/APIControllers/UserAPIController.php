<?php
require_once(__DIR__ . "/APIController.php");
require_once("../services/UserService.php");
require_once("../services/CustomerService.php");

class UserAPIController extends APIController
{

    public function handlePostRequest($uri)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                parent::handlePostRequest($uri);
                $data = json_decode(file_get_contents("php://input"));

                if (str_starts_with($uri, "/api/admin")) {
                    $this->handleAdminPostRequest($uri, $data);
                    return;
                }

                switch ($uri) {
                    case "/api/user/login":
                        $this->login($data);
                        break;
                    case "/api/user/logout":
                        $this->logout();
                        break;
                    case "/api/user/register":
                        $this->registerCustomer($data);
                        break;
                    case "/api/user/resetPassword":
                        $this->resetPassword($data);
                        break;
                    case "/api/user/updatePassword":
                        $this->updateUserPassword($data);
                        break;
                        case "/api/user/deleteUser":
                        $this->deleteUser($data);
                        break;
                    default:
                        $this->sendErrorMessage("Invalid API Request");
                        break;
                }
            }
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    public function handleGetRequest($uri)
    {
    }

    public function handlePutRequest($uri)
    {
    }

    public function handleDeleteRequest($uri)
    {
    }

    private function login($data)
    {
        try {
            $userService = new UserService();

            if (!isset($data->email) || !isset($data->password)) {
                throw new Exception("Email and password are required.");
            }

            //Sanitise data
            $email = htmlspecialchars($data->email);
            $password = htmlspecialchars($data->password);

            //Fetch user (method throws error if user not found)
            $user = $userService->verifyUser($data);

            //Store user in session
            session_start();
            $_SESSION["user"] = $user;

            parent::sendSuccessMessage("Login successful.");
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function logout()
    {
        try {
            session_start();
            session_destroy();
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function registerCustomer($data)
    {
        try {
            $customerService = new CustomerService();

            //Check if all data is present
            if (
                !isset($data->firstName) || !isset($data->lastName) || !isset($data->email) || !isset($data->password)
                || !isset($data->dateOfBirth) || !isset($data->phoneNumber) || !isset($data->address) || !isset($data->captchaResponse)
            ) {
                throw new Exception("Registration data incomplete.");
            }

            //Verify captcha
            $secret = "6LfMgZwkAAAAAFs2hfXUpKQ1wNwHaic9rnZozCbH";
            $response = $data->captchaResponse;
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response);
            $responseData = json_decode($verifyResponse, true);

            if (!$responseData["success"]) {
                throw new Exception("Captcha verification failed.");
            }

            //Register new customer
            $customerService->registerCustomer($data);

            parent::sendSuccessMessage("Registration successful.");
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function resetPassword($data)
    {
        try {
            $userService = new UserService();

            if ($data == null || !isset($data->email)) {
                throw new Exception("No data received.");
            }

            $data->email = htmlspecialchars($data->email);
            $reset_token = bin2hex(random_bytes(16));

            // here insert the email, reset token, and timestamp into the database (timestamp will be 24 hours from now)
            $userService->storeResetToken($data->email, $reset_token);
            $userService->sendResetTokenToUser($data->email, $reset_token);
            parent::sendSuccessMessage("Email sent, please check your inbox.");

            // Log the response being sent back to the client
            error_log(json_encode(['success' => true]));
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function updateUserPassword($data)
    {
        try {
            $userService = new UserService();

            if (
                $data == null || !isset($data->email) || !isset($data->newPassword) ||
                !isset($data->token) || !isset($data->confirmPassword)
            ) {
                throw new Exception("No data received.");
            }
            $userService->verifyResetToken(htmlspecialchars($data->email), htmlspecialchars($data->token));
            $newPassword = htmlspecialchars($data->newPassword);
            $confirmPassword = htmlspecialchars($data->confirmPassword);

            if ($newPassword != $confirmPassword) {
                throw new Exception("New password and confirm password do not match.");
            } else {
                $userService->updateUserPassword($data);
                parent::sendSuccessMessage("Password updated.");
            }
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function deleteUser($data){
        try {
            $userService = new UserService();

            if ($data == null || !isset($data->id)) {
                throw new Exception("No data received.");
            }
            $data->id = htmlspecialchars($data->id);

            $userService->deleteUser($data);
            parent::sendSuccessMessage("User deleted.");
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }
    private function fetchAddress($data)
    {
        //WIP, currently done through JS
    }

    private function handleAdminPostRequest($uri, $data)
    {
        // TODO: Make sure that only logged-in user can use this API.
        // if (!$this->isLoggedIn()) {
        //     $this->sendErrorMessage("Access denied.");
        //     return;
        // }

        require_once(__DIR__ . "/../services/ImageService.php");
        $imageService = new ImageService();

        if (str_starts_with($uri, "/api/admin/images/") && preg_match('/\d+$/', $uri)) {
            // get the id from the uri
            $id = substr($uri, strrpos($uri, '/') + 1);
            $image = $imageService->getImageById($id);
            echo json_encode($image);
            return;
        }

        switch ($uri) {
            case "/api/admin/text-pages":
                require_once(__DIR__ . "/../services/PageService.php");
                $pageService = new PageService();
                $pages = $pageService->getAllTextPages();
                echo json_encode($pages);
                break;
            case "/api/admin/text-pages/update":
                require_once(__DIR__ . "/../services/PageService.php");
                $pageService = new PageService();

                if (!isset($data->id) || !isset($data->title) || !isset($data->content) || !isset($data->images)) {
                    throw new Exception("Invalid data received.");
                }

                $pageService->updateTextPage($data->id, $data->title, $data->content, $data->images);

                parent::sendSuccessMessage("Page updated successfully.");
                break;
            case "/api/admin/images":
                if (isset($data->action)) {
                    if ($data->action == "delete") {
                        if (!isset($data->id)) {
                            throw new Exception("Invalid data received.");
                        }
                        $imageService->removeImage($data->id);
                        parent::sendSuccessMessage("Image deleted successfully.");
                    } elseif ($data->action == "update") {
                        if (!isset($data->id) || !isset($data->alt)) {
                            throw new Exception("Invalid data received.");
                        }
                        $imageService->updateImage($data->id, $data->alt);
                        parent::sendSuccessMessage("Image updated successfully.");
                    } else {
                        parent::sendErrorMessage("Invalid API Request");
                    }
                } else {
                    $images = $imageService->getAll();
                    echo json_encode($images);
                }
                break;
            default:
                parent::sendErrorMessage("Invalid API Request");
                break;
        }
    }
}