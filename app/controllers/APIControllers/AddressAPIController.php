<?php
require_once(__DIR__ . "/APIController.php");
require_once(__DIR__ . "/../services/AddressService.php");
require_once(__DIR__ . "/../models/Address.php");

class AddressAPIController extends APIController
{
    protected function handlePostRequest($uri)
    {
        parent::handlePostRequest($uri);
        $data = json_decode(file_get_contents("php://input"));

        switch ($uri) {
            case "/api/address/fetch-address":
                $this->fetchAddress($data);
                break;
            default:
                $this->sendErrorMessage("Invalid API Request", 400);
                break;
        }

    }

    protected function handleGetRequest($uri)
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

    private function fetchAddress($data)
    {
        try{
        $addressService = new AddressService();
        $address = $addressService->fetchAddressFromPostCodeAPI($data);

        header('Content-Type: application/json');
        echo json_encode(["address" => $address]);
        }
        catch(Exception $ex){
            $this->sendErrorMessage($ex->getMessage());
        }
    }
}