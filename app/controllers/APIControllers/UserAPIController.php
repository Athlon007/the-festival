<?php
require_once("../services/UserService.php");
require_once("../services/CustomerService.php");

class UserAPIController extends APIController{
    
    function handleGetRequest($uri){

    }

    function handlePostRequest($uri){
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $data = json_decode(file_get_contents("php://input"));

                if ($data == null) {
                    throw new Exception("No data received.");
                }

                if (str_starts_with($uri, "/api/admin")) {
                    $this->handleAdminPostRequest($uri, $data);
                    return;
                }

                switch ($uri) {
                    case "/api/login":
                        $this->login($data);
                        break;
                    case "/api/logout":
                        $this->logout();
                        break;
                    case "/api/register":
                        $this->registerCustomer($data);
                        break;
                    case "/api/resetPassword":
                        $this->resetPassword($data);
                        break;
                    case "/api/updatePassword":
                        $this->updateUserPassword($data);
                        break;
                    default:
                        $this->sendErrorMessage("Invalid API Request");
                        break;
                }
            }
        } 
        catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    function handlePutRequest($uri){

    }

    function handleDeleteRequest($uri){

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

            $this->sendSuccessMessage("Login successful.");
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    private function logout()
    {
        try {
            session_start();
            session_destroy();
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
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

            $this->sendSuccessMessage("Registration successful.");
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    // Vedat: I have added this function to send the reset token to the user (JS)
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
            $this->sendSuccessMessage("Email sent, please check your inbox.");

            // Log the response being sent back to the client
            error_log(json_encode(['success' => true]));
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    // Vedat: I have added this function to update the user's password (JS) TODO: most of this should be moved to service
    private function updateUserPassword($data)
    {
        try {
            $userService = new UserService();
            $user = new User();
            if (isset($_POST['submitPassword'])) {
                $data->email = htmlspecialchars($_POST['email']);
                $data->password = htmlspecialchars($_POST['password']);
                $data->passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);
                $data->reset_token = htmlspecialchars($_POST['reset_token']);

                // here check if the reset token is valid
                $userService->checkResetToken($data->email, $data->reset_token);
                if (empty($userService->checkResetToken($data->email, $data->reset_token))) {
                    throw new Exception("Invalid reset token.");
                }
                $user->setEmail($data->email);
                // hash the password
                $hash_password = password_hash($data->password, PASSWORD_DEFAULT);
                $user->getHashPassword($hash_password);
                // here update the password in the database
                $userService->updateUserPassword($user);
            } else {
                echo "Please enter your new password.";
            }
            $this->sendSuccessMessage("Password reset successful.");
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    // Vedat: I have added this function to get all users (JS)
    private function getAllUsers()
    {
        try {
            $userService = new UserService();
            $users = $userService->getAllUsers();
            return $users;
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    private function fetchAddress($data){
        //WIP, currently done through JS
    }

    private function handleAdminPostRequest($uri, $data){
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

                $this->sendSuccessMessage("Page updated successfully.");
                break;
            case "/api/admin/images":
                if (isset($data->action)) {
                    if ($data->action == "delete") {
                        if (!isset($data->id)) {
                            throw new Exception("Invalid data received.");
                        }
                        $imageService->removeImage($data->id);
                        $this->sendSuccessMessage("Image deleted successfully.");
                    } elseif ($data->action == "update") {
                        if (!isset($data->id) || !isset($data->alt)) {
                            throw new Exception("Invalid data received.");
                        }
                        $imageService->updateImage($data->id, $data->alt);
                        $this->sendSuccessMessage("Image updated successfully.");
                    } else {
                        $this->sendErrorMessage("Invalid API Request");
                    }
                } else {
                    $images = $imageService->getAll();
                    echo json_encode($images);
                }
                break;
            default:
                $this->sendErrorMessage("Invalid API Request");
                break;
        }
    }
}