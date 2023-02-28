<?php
require_once(__DIR__ . "/APIController.php");

class AddressAPIController extends APIController
{
    protected function handlePostRequest($uri)
    {
        parent::handlePostRequest($uri);

        switch ($uri) {
            case "/api/address/fetch-address":

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
}