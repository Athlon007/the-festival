<?php
require_once(__DIR__ . "/APIController.php");
require_once(__DIR__ . "/../../services/AddressService.php");
require_once(__DIR__ . "/../../models/Address.php");

/**
 * This class is the controller for the Address API.
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

            $streetName = $data->streetName;
            $houseNumber = $data->houseNumber;
            $postalCode = $data->postalCode;
            $city = $data->city;
            $country = $data->country;

            $address = $this->addressService->insertAddress($streetName, $houseNumber, $postalCode, $city, $country);
            echo json_encode($address);
        } catch (MissingVariableException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        }
    }

    protected function handleGetRequest($uri)
    {
        if (!is_numeric(basename($uri))) {
            $this->sendErrorMessage("Invalid API Request. You can only request specific addresses.", 400);
            return;
        }

        $addressId = basename($uri);
        $address = $this->addressService->getAddressById($addressId);
        echo json_encode($address);
    }

    protected function handlePutRequest($uri)
    {
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
        } catch (Exception $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        }
    }

    protected function handleDeleteRequest($uri)
    {
        if (!is_numeric(basename($uri))) {
            $this->sendErrorMessage("Invalid API Request. You can only delete specific addresses.", 400);
            return;
        }

        $addressId = basename($uri);
        $this->addressService->deleteAddress($addressId);
        $this->sendSuccessMessage("Address deleted successfully");
    }

    private function fetchAddress($data)
    {
        try {
            $addressService = new AddressService();
            $address = $addressService->fetchAddressFromPostCodeAPI($data);

            header('Content-Type: application/json');
            echo json_encode([
                "street" => $address->street,
                "city" => $address->city,
            ]);
        } catch (Exception $ex) {
            $this->sendErrorMessage($ex->getMessage());
        }
    }
}
