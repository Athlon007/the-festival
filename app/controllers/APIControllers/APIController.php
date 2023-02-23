<?php
require_once("../services/UserService.php");
require_once("../services/CustomerService.php");

class APIController
{
    protected function handleGetRequest($uri)
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
                        header('Content-Type: application/json');
                        echo json_encode($output);
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

    protected function handlePostRequest($uri)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $data = json_decode(file_get_contents("php://input"));

                if ($data == null) {
                    throw new Exception("No data received.");
                }
            }
        } 
        catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }

    protected function handlePutRequest($uri){

    }

    protected function handleDeleteRequest($uri){
        
    }

    

    final protected function sendErrorMessage($message){
        header('Content-Type: application/json');
        echo json_encode(["error_message" => $message]);
    }

    final protected function sendSuccessMessage($message){
        header('Content-Type: application/json');
        echo json_encode(["success_message" => $message]);
    }

    /**
     * Checks if the current request is from localhost.
     */
    private function isLocalApiRequest(){
        // TODO: Implement local API checking
        return true; 

        //require_once(__DIR__ . "/../Config.php");
        //return $_SERVER["REMOTE_ADDR"] == $allowed_api_address;
    }

    
}
