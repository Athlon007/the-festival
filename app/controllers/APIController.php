<?php
require_once("../services/UserService.php");

class APIController
{
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

    // Vedat: I have added this function to update the user's password (JS)
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
                $user->setHash($hash_password);
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
}