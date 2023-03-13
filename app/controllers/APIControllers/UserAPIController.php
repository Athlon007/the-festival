<?php
require_once(__DIR__ . "/APIController.php");
require_once("../services/UserService.php");
require_once("../services/CustomerService.php");
require_once("../models/Exceptions/MissingVariableException.php");

class UserAPIController extends APIController
{

    public function handlePostRequest($uri)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                parent::handlePostRequest($uri);
                $data = json_decode(file_get_contents("php://input"));

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
                    case "/api/user/updateUser":
                        $this->updateUser($data);
                        break;
                    case "/api/user/update-customer":
                        $this->updateCustomer($data);
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

            if (!isset($data->email)) {
                throw new MissingVariableException("Email is required");
            }
            if (!isset($data->password)) {
                throw new MissingVariableException("Password is required");
            }

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
            parent::sendSuccessMessage("Logout successful.");
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function registerCustomer($data)
    {
        try {
            $customerService = new CustomerService();

            //Check if all data is present
            if (!isset($data->firstName) || !isset($data->lastName) || !isset($data->email) || !isset($data->password)
            || !isset($data->dateOfBirth) || !isset($data->phoneNumber) || !isset($data->address) || !isset($data->captchaResponse)){
                
                throw new MissingVariableException("Registration data incomplete.");
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

            if (
                $data == null || !isset($data->email) || empty($data->email)
            ) {
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
                !isset($data->token) || !isset($data->confirmPassword) || empty($data->newPassword) ||
                empty($data->confirmPassword)
            ) {
                throw new Exception("No data received.");
            }
            $userService->updateUserPassword($data);
            parent::sendSuccessMessage("Password updated.");
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function deleteUser($data)
    {
        try {
            $userService = new UserService();

            if ($data == null || !isset($data->id)) {
                throw new MissingVariableException("No data received.");
            }
            $data->id = htmlspecialchars($data->id);

            $userService->deleteUser($data);
            parent::sendSuccessMessage("User deleted.");
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function updateUser($data)
    {
        try {
            $userService = new UserService();

            // TODO: More things will be added here
            if (
                $data == null || !isset($data->id) || !isset($data->firstName)
                || !isset($data->lastName) || !isset($data->email)
            ) {
                throw new Exception("No data received.");
            }
            $userService->updateUser($data);
            parent::sendSuccessMessage("User updated.");
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

    private function updateCustomer($data){
        try {
            $customerService = new CustomerService();

            if (!isset($data->firstName) || !isset($data->lastName) || !isset($data->email) || !isset($data->dateOfBirth)
                || !isset($data->phoneNumber) || !isset($data->address)){
                throw new MissingVariableException("Not all data received.");
            }
            session_start();
            $customer = $_SESSION['user'];
            $customerService->updateCustomer($customer, $data);

            parent::sendSuccessMessage("Your account was successfully updated.");
        } catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }

}