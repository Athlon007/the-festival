<?php

require_once(__DIR__ . "/../../services/LocationService.php");
require_once('APIController.php');
require_once(__DIR__ . "/../../models/Exceptions/MissingVariableException.php");

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

    public function handlePostRequest($uri)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data == null) {
            $this->sendErrorMessage("Invalid JSON", 400);
            return;
        }

        try {
            if (!isset($data['name'])) {
                throw new MissingVariableException("Name is required");
            }
            if (!isset($data['locationType'])) {
                throw new MissingVariableException("Location type is required");
            }
            if (!isset($data['lon'])) {
                throw new MissingVariableException("Longtitude is required");
            }
            if (!isset($data['lat'])) {
                throw new MissingVariableException("Latitude is required");
            }

            // now also check for variables needed for Address
            if (!isset($data['address'])) {
                throw new MissingVariableException("Address is required");
            }
            if (!isset($data['address']['streetName'])) {
                throw new MissingVariableException("Street name is required");
            }
            if (!isset($data['address']['houseNumber'])) {
                throw new MissingVariableException("House number is required");
            }
            if (!isset($data['address']['postalCode'])) {
                throw new MissingVariableException("Postal code is required");
            }
            if (!isset($data['address']['city'])) {
                throw new MissingVariableException("City is required");
            }
            if (!isset($data['address']['country'])) {
                throw new MissingVariableException("Country is required");
            }

            $name = $data['name'];
            $locationType = $data['locationType'];
            $lon = $data['lon'];
            $lat = $data['lat'];
            $streetName = $data['address']['streetName'];
            $houseNumber = $data['address']['houseNumber'];
            $postalCode = $data['address']['postalCode'];
            $city = $data['address']['city'];
            $country = $data['address']['country'];

            $location = $this->locationService->insertLocation(
                $name,
                $locationType,
                $lon,
                $lat,
                $streetName,
                $houseNumber,
                $postalCode,
                $city,
                $country
            );

            echo json_encode($location);
        } catch (MissingVariableException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        }
    }
}
