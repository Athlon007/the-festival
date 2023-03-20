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
        if (str_starts_with($uri, "/api/locations/geocode")) {
            if (!isset($_GET['street'])) {
                $this->sendErrorMessage("Street is required", 400);
                return;
            }
            if (!isset($_GET['number'])) {
                $this->sendErrorMessage("House number is required", 400);
                return;
            }
            if (!isset($_GET['postal'])) {
                $this->sendErrorMessage("Postal code is required", 400);
                return;
            }
            if (!isset($_GET['city'])) {
                $this->sendErrorMessage("City is required", 400);
                return;
            }

            $street = $_GET['street'];
            $houseNumber = $_GET['number'];
            $postalCode = $_GET['postal'];
            $city = $_GET['city'];

            $output = $this->locationService->fetchGeocoding($street, $houseNumber, $postalCode, $city);
            echo json_encode($output);
            return;
        }

        if (str_starts_with($uri, "/api/locations/type/")) {
            echo json_encode($this->locationService->getLocationsByType(basename($uri)));
            return;
        }

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
            if (!isset($data['capacity'])) {
                throw new MissingVariableException("Capacity is required");
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
            $capacity = $data['capacity'];

            $location = $this->locationService->insertLocation(
                $name,
                $streetName,
                $houseNumber,
                $postalCode,
                $city,
                $country,
                $locationType,
                $lon,
                $lat,
                $capacity
            );

            echo json_encode($location);
        } catch (MissingVariableException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        }
    }

    public function handlePutRequest($uri)
    {
        if (!is_numeric(basename($uri))) {
            $this->sendErrorMessage("Invalid ID", 400);
            return;
        }

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
            if (!isset($data['capacity'])) {
                throw new MissingVariableException("Capacity is required");
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
            if (!isset($data['address']['addressId'])) {
                throw new MissingVariableException("Address ID is required");
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
            $capacity = $data['capacity'];
            $addressId = $data['address']['addressId'];

            $location = $this->locationService->updateLocation(
                basename($uri),
                $name,
                $streetName,
                $houseNumber,
                $postalCode,
                $city,
                $country,
                $locationType,
                $lon,
                $lat,
                $capacity,
                $addressId
            );

            echo json_encode($location);
        } catch (MissingVariableException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        }
    }

    public function handleDeleteRequest($uri)
    {
        if (!is_numeric(basename($uri))) {
            $this->sendErrorMessage("Invalid ID", 400);
            return;
        }

        $this->locationService->deleteLocation(basename($uri));
        $this->sendSuccessMessage("Location deleted");
    }
}
