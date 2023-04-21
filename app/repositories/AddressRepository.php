<?php
//
require_once(__DIR__ . '/../models/Address.php');
require_once(__DIR__ . '/../repositories/Repository.php');
require_once(__DIR__ . '/../models/Exceptions/AddressNotFoundException.php');

class AddressRepository extends Repository
{

    public function insertAddress($address): Address
    {
        try {
            $query = "INSERT INTO addresses (streetName, houseNumber, postalCode, city, country) VALUES (:streetName, :houseNumber, :postalCode, :city, :country)";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":streetName", htmlspecialchars($address->getStreetName()));
            $stmt->bindValue(":houseNumber", htmlspecialchars($address->getHouseNumber()));
            $stmt->bindValue(":postalCode", htmlspecialchars($address->getPostalCode()));
            $stmt->bindValue(":city", htmlspecialchars($address->getCity()));
            $stmt->bindValue(":country", htmlspecialchars($address->getCountry()));

            $stmt->execute();

            $address->setAddressId($this->connection->lastInsertId());
            return $address;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getAddressById($addressId): Address
    {
        try {
            $query = "SELECT * FROM addresses WHERE addressId = :addressId";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":addressId", htmlspecialchars($addressId));
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result){
                throw new AddressNotFoundException();
            }
            
            //Build and return address object
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

    public function updateAddress($address): Address
    {
        try {
            $query = "UPDATE addresses SET streetName = :streetName, houseNumber = :houseNumber, postalCode = :postalCode, city = :city, country = :country WHERE addressId = :addressId";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":streetName", htmlspecialchars($address->getStreetName()));
            $stmt->bindValue(":houseNumber", htmlspecialchars($address->getHouseNumber()));
            $stmt->bindValue(":postalCode", htmlspecialchars($address->getPostalCode()));
            $stmt->bindValue(":city", htmlspecialchars($address->getCity()));
            $stmt->bindValue(":country", htmlspecialchars($address->getCountry()));
            $stmt->bindValue(":addressId", htmlspecialchars($address->getAddressId()));
            
            $stmt->execute();

            return $address;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteAddress($addressId): void
    {
        try {
            $query = "DELETE FROM addresses WHERE addressId = :addressId";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":addressId", htmlspecialchars($addressId));
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}
