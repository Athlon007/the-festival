<?php

require_once(__DIR__ . "/../../services/LocationService.php");
require_once('APIController.php');

class LocationAPIController extends APIController
{
    private $locationService;

    public function __construct()
    {
        $this->locationService = new LocationService();
    }

    public function handleGetRequest($uri)
    {
        if (is_numeric(basename($uri))) {
            echo json_encode($this->locationService->getById(basename($uri)));
            return;
        }

        echo json_encode($this->locationService->getAll());
    }
}
