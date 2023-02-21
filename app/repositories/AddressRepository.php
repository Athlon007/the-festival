<?php

require_once(__DIR__ . '/../models/Address.php');

class AddressRepository extends Repository{
    
    public function insertAddress(Address $address){
        try
        {
            $query = "INSERT INTO addresses (streetName, houseNumber, postalCode, city, country) VALUES (:streetName, :houseNumber, :postalCode, :city, :country)";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":streetName", $address->getStreetName());
            $stmt->bindValue(":houseNumber", $address->getHouseNumber());
            $stmt->bindValue(":postalCode", $address->getPostalCode());
            $stmt->bindValue(":city", $address->getCity());
            $stmt->bindValue(":country", $address->getCountry());
            
            $stmt->execute();
        }
        catch(PDOException $ex)
        {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }
}

?>