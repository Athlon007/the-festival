<?php
require_once("../services/UserService.php");
require_once("../services/CustomerService.php");

class APIController
{
    public function handleGetRequest($uri)
    {
        header('Content-Type: application/json');
        try {
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                switch ($uri) {
                    case "/api/nav":
                        // Make sure that only localhost can use this API.
                        if (!$this->isLocalApiRequest()) {
                            $this->sendErrorMessage("Access denied.");
                            return;
                        }
                        require_once(__DIR__ . "/../services/NavigationBarItemService.php");
                        $navService = new NavigationBarItemService();
                        $output = $navService->getAll();
                        echo json_encode($output);
                        break;
                    default:
                        $this->sendErrorMessage("Invalid API Request");
                        break;
                }
            }
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    public function handlePostRequest($uri)
    {
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
                    default:
                        $this->sendErrorMessage("Invalid API Request");
                        break;
                }
            }
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
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
            $user = $userService->verifyUser($email, $password);

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

            if (!isset($data->email) || !isset($data->firstName) || !isset($data->lastName) || !isset($data->password) || !isset($data->dateOfBirth) || !isset($data->address)) {
                throw new Exception("Registration data incomplete.");
            }

            //Sanitise data
            $data->email = htmlspecialchars($data->email);
            $data->firstName = htmlspecialchars($data->firstName);
            $data->lastName = htmlspecialchars($data->lastName);
            $data->password = htmlspecialchars($data->password);

            //Register new customer
            $customerService->registerCustomer($data);

            $this->sendSuccessMessage("Registration successful.");
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    private function sendErrorMessage($message)
    {
        header('Content-Type: application/json');
        echo json_encode(["error_message" => $message]);
    }

    private function sendSuccessMessage($message)
    {
        header('Content-Type: application/json');
        echo json_encode(["success_message" => $message]);
    }

    /**
     * Checks if the current request is from localhost.
     */
    private function isLocalApiRequest()
    {
        return true; // Debug

        require_once __DIR__ . "/../Config.php";
        return $_SERVER["REMOTE_ADDR"] == $allowed_api_address;
    }

    private function handleAdminPostRequest($uri, $data)
    {
        // TODO: Make sure that only logged-in user can use this API.
        // if (!$this->isLoggedIn()) {
        //     $this->sendErrorMessage("Access denied.");
        //     return;
        // }

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
                require_once(__DIR__ . "/../services/ImageService.php");
                $imageService = new ImageService();
                $images = $imageService->getAll();
                echo json_encode($images);
                break;
            default:
                $this->sendErrorMessage("Invalid API Request");
                break;
        }
    }
}
