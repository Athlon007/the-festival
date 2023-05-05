<?php
require_once("APIController.php");
require_once(__DIR__ . "/../../services/AddressService.php");
require_once(__DIR__ . "/../../models/Address.php");

/**
 * Controller for the Address API endpoint.
 * @author Joshua
 */
class AddressAPIController extends APIController
{
    private $addressService;

    public function __construct()
    {
        $this->addressService = new AddressService();
    }

    protected function handlePostRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }

        if (str_starts_with($uri, "/api/address/fetch-address")) {
            $data = json_decode(file_get_contents("php://input"));
            $this->fetchAddress($data);
            return;
        }

        $json = file_get_contents('php://input');

        $data = json_decode($json);

        if ($data == null) {
            $this->sendErrorMessage("Invalid JSON", 400);
            return;
        }

        try {
            if (!isset($data->streetName)) {
                throw new MissingVariableException("Street name is required");
            }
            if (!isset($data->houseNumber)) {
                throw new MissingVariableException("House number is required");
            }
            if (!isset($data->postalCode)) {
                throw new MissingVariableException("Postal code is required");
            }
            if (!isset($data->city)) {
                throw new MissingVariableException("City is required");
            }
            if (!isset($data->country)) {
                throw new MissingVariableException("Country is required");
            }
            $address = new Address();
            $address->setStreetName($data->streetName);
            $address->setHouseNumber($data->houseNumber);
            $address->setPostalCode($data->postalCode);
            $address->setCity($data->city);
            $address->setCountry($data->country);
            $address = $this->addressService->insertAddress($address);

            echo json_encode($address);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to post address.", 400);
        }
    }

    protected function handleGetRequest($uri)
    {
        if (!is_numeric(basename($uri))) {
            $this->sendErrorMessage("Invalid API Request. You can only request specific addresses.", 400);
            return;
        }

        try {
            $addressId = basename($uri);
            $address = $this->addressService->getAddressById($addressId);
            echo json_encode($address);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage($e);
        }
    }

    protected function handlePutRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 403);
            return;
        }

        if (!is_numeric(basename($uri))) {
            $this->sendErrorMessage("Invalid API Request. You can only update specific addresses.", 400);
            return;
        }

        $addressId = basename($uri);

        $json = file_get_contents('php://input');

        $data = json_decode($json);

        if ($data == null) {
            $this->sendErrorMessage("Invalid JSON", 400);
            return;
        }

        try {
            if (!isset($data->streetName)) {
                throw new MissingVariableException("Street name is required");
            }
            if (!isset($data->houseNumber)) {
                throw new MissingVariableException("House number is required");
            }
            if (!isset($data->postalCode)) {
                throw new MissingVariableException("Postal code is required");
            }
            if (!isset($data->city)) {
                throw new MissingVariableException("City is required");
            }
            if (!isset($data->country)) {
                throw new MissingVariableException("Country is required");
            }

            $streetName =   $data->streetName;
            $houseNumber =  $data->houseNumber;
            $postalCode =   $data->postalCode;
            $city =         $data->city;
            $country =      $data->country;

            $address = $this->addressService->updateAddress(
                $addressId,
                $streetName,
                $houseNumber,
                $postalCode,
                $city,
                $country
            );
            echo json_encode($address);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to update address.", 400);
        }
    }

    protected function handleDeleteRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }

        if (!is_numeric(basename($uri))) {
            $this->sendErrorMessage("Invalid API Request. You can only delete specific addresses.", 400);
            return;
        }

        try {
            $addressId = basename($uri);
            $this->addressService->deleteAddress($addressId);
            $this->sendSuccessMessage("Address deleted successfully");
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to delete address.", 400);
        }
    }

    private function fetchAddress($data)
    {
        try {
            $address = $this->addressService->fetchAddressFromPostCodeAPI($data);

            header('Content-Type: application/json');
            echo json_encode([
                "street" => $address->street,
                "city" => $address->city,
            ]);
        } catch (Throwable $ex) {
            Logger::write($ex);
            $this->sendErrorMessage("Unable to fetch address.", 400);
        }
    }
}
