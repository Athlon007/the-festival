<?php
require_once("../services/UserService.php");

class APIController
{
    public function handleGetRequest($uri)
    {
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
            $userService = new UserService();

            if (!isset($data->email) || !isset($data->firstName) || !isset($data->lastName) || !isset($data->password)) {
                throw new Exception("All fields are required.");
            }

            //Sanitise data
            $data->email = htmlspecialchars($data->email);
            $data->firstName = htmlspecialchars($data->firstName);
            $data->lastName = htmlspecialchars($data->lastName);
            $data->password = htmlspecialchars($data->password);

            //Create new user
            $userService->registerNewCustomer($data);

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
        require_once __DIR__ . "/../Config.php";
        return $_SERVER["REMOTE_ADDR"] == $allowed_api_address;
    }
}
