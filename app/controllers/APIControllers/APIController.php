<?php

class APIController
{
    protected function handleGetRequest($uri){
       
    }

    protected function handlePostRequest($uri){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents("php://input"));

            if ($data == null)
                $this->sendErrorMessage("No data received.");
        }
    }

    protected function handlePutRequest($uri){

    }

    protected function handleDeleteRequest($uri){
        
    }

    

    final protected function sendErrorMessage($message){
        htmlspecialchars($message);
        header('Content-Type: application/json');
        echo json_encode(["error_message" => $message]);
    }

    final protected function sendSuccessMessage($message){
        htmlspecialchars($message);
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
