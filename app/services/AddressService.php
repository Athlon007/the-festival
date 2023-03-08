<?php
require_once(__DIR__ . "/../models/Address.php");
require_once(__DIR__ . "/../repositories/AddressRepository.php");

class AddressService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new AddressRepository();
    }

    public function getAddressById($id): Address
    {
        return $this->repo->getAddressById($id);
    }

    public function insertAddress($streetName, $houseNumber, $postalCode, $city, $country): Address
    {
        $streetName = htmlspecialchars($streetName);
        $houseNumber = htmlspecialchars($houseNumber);
        $postalCode = htmlspecialchars($postalCode);
        $city = htmlspecialchars($city);
        $country = htmlspecialchars($country);

        $address = new Address(-1, $streetName, $houseNumber, $postalCode, $city, $country);
        $addressId = $this->repo->insertAddress($address);
        return $this->getAddressById($addressId);
    }

    public function updateAddress($addressId, $streetName, $houseNumber, $postalCode, $city, $country): Address
    {
        $addressId = htmlspecialchars($addressId);
        $streetName = htmlspecialchars($streetName);
        $houseNumber = htmlspecialchars($houseNumber);
        $postalCode = htmlspecialchars($postalCode);
        $city = htmlspecialchars($city);
        $country = htmlspecialchars($country);

        $address = new Address($addressId, $streetName, $houseNumber, $postalCode, $city, $country);
        $this->repo->updateAddress($address);
        return $this->getAddressById($addressId);
    }

    public function deleteAddress($addressId): void
    {
        $addressId = htmlspecialchars($addressId);
        $this->repo->deleteAddress($addressId);
    }
}
