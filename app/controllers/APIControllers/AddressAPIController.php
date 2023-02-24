<?php
require_once(__DIR__ . "/APIController.php");

class UserAPIController extends APIController
{
    protected function handlePostRequest($uri)
    {
        parent::handlePostRequest($uri);


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