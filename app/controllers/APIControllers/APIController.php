<?php

class APIController
{
    public function initialize($request)
    {
        // disable error reporting
        error_reporting(0);

        if ($request == null) {
            $this->sendErrorMessage("Request cannot be empty.", 400);
            return;
        }

        try {
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $this->handleGetRequest($request);
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                $this->handlePostRequest($request);
            } elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
                $this->handlePutRequest($request);
            } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
                $this->handleDeleteRequest($request);
            }
        } catch (Exception $e) {
            $this->sendErrorMessage($e->getMessage());
        }
    }

    protected function handleGetRequest($uri)
    {
        // Can be implemented by child class
    }

    protected function handlePostRequest($uri)
    {
        // Can be implemented by child class
    }

    protected function handlePutRequest($uri)
    {
        // Can be implemented by child class
    }

    protected function handleDeleteRequest($uri)
    {
        // Can be implemented by child class
    }

    final protected function sendErrorMessage($message, $code = 500)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode(["error_message" => $message]);
    }

    final protected function sendSuccessMessage($message)
    {
        header('Content-Type: application/json');
        echo json_encode(["success_message" => $message]);
    }

    /**
     * Checks if the current request is from localhost.
     */
    final protected function isLocalApiRequest()
    {
        // TODO: Implement local API checking
        return true;

        //require_once(__DIR__ . "/../Config.php");
        //return $_SERVER["REMOTE_ADDR"] == $allowed_api_address;
    }

    final protected function isLoggedIn()
    {
        require_once(__DIR__ . '/../../models/User.php');
        try {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION["user"])) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            Logger::write($e);
            return false;
        }
    }

    final protected function isLoggedInAsAdmin()
    {
        require_once(__DIR__ . '/../../models/User.php');
        try {
            if ($this->isLoggedIn()) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                return unserialize($_SESSION["user"])->getUserType() == "1";
            }

            return false;
        } catch (Exception $e) {
            Logger::write($e);
            return false;
        }
    }
}
