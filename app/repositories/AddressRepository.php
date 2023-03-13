<?php

require_once(__DIR__ . '/../models/Address.php');
require_once(__DIR__ . '/../repositories/Repository.php');
require_once(__DIR__ . '/../models/Exceptions/AddressNotFoundException.php');

class AddressRepository extends Repository
{

    public function insertAddress(Address $address): int
    {
        try {
            $query = "INSERT INTO Addresses (streetName, houseNumber, postalCode, city, country) VALUES (:streetName, :houseNumber, :postalCode, :city, :country)";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":streetName", $address->getStreetName());
            $stmt->bindValue(":houseNumber", $address->getHouseNumber());
            $stmt->bindValue(":postalCode", $address->getPostalCode());
            $stmt->bindValue(":city", $address->getCity());
            $stmt->bindValue(":country", $address->getCountry());

            $stmt->execute();

            return $this->connection->lastInsertId();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getAddressById($addressId): ?Address
    {
        try {
            $query = "SELECT * FROM Addresses WHERE addressId = :addressId";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":addressId", $addressId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (is_bool($result))
                throw new AddressNotFoundException();
            else
                $streetName = $result['streetName'];
                $houseNumber = $result['houseNumber'];
                $postalCode = $result['postalCode'];
                $city = $result['city'];
                $country = $result['country'];
                return new Address($addressId, $streetName, $houseNumber, $postalCode, $city, $country);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updateAddress(Address $address): void
    {
        try {
            $query = "UPDATE Addresses SET streetName = :streetName, houseNumber = :houseNumber, postalCode = :postalCode, city = :city, country = :country WHERE addressId = :addressId";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":streetName", $address->getStreetName());
            $stmt->bindValue(":houseNumber", $address->getHouseNumber());
            $stmt->bindValue(":postalCode", $address->getPostalCode());
            $stmt->bindValue(":city", $address->getCity());
            $stmt->bindValue(":country", $address->getCountry());
            $stmt->bindValue(":addressId", $address->getAddressId());

            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteAddress($addressId): void
    {
        try {
            $query = "DELETE FROM Addresses WHERE addressId = :addressId";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":addressId", $addressId);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}
