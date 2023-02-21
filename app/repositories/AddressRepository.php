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

    public function getAddressById($addressId) : ?Address
    {
        try{
            $query = "SELECT * FROM addresses WHERE addressId = :addressId";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":addressId", $addressId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Address');

            $result = $stmt->fetch();

            if (is_bool($result))
                throw new AddressNotFoundException("Address ID does not exist");
            else
                return $result;
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