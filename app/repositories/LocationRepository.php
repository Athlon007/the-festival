<?php

require_once("Repository.php");
require_once("AddressRepository.php");
require_once(__DIR__ . "/../models/Location.php");

class LocationRepository extends Repository
{
    private function buildLocations($arr): array
    {
        $output = array();
        $addressRepository = new AddressRepository();

        foreach ($arr as $row) {
            $locationId = $row["locationId"];
            $name = $row["name"];
            $addressId = $row["addressId"];
            $locationType = $row["locationType"];
            $lon = $row["lon"];
            $lat = $row["lat"];
            $capacity = $row["capacity"];
            $description = isset($row["description"]) ? $row["description"] : null;

            $address = $addressRepository->getAddressById($addressId);

            $location = new Location($locationId, $name, $address, $locationType, $lon, $lat, $capacity, $description);

            array_push($output, $location);
        }

        return $output;
    }

    public function getAll()
    {
        $sql = "SELECT locationId, name, addressId, locationType, capacity, lon, lat, description FROM `Locations`";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->buildLocations($result);
    }

    // Location type of history is 3
    public function getAllHistoryLocations()
    {
        $sql = "SELECT locationId, name, addressId, locationType, capacity, lon, lat, description FROM `Locations` WHERE locationType = 3";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->buildLocations($result);
    }
    public function getById($id)
    {
        $sql = "SELECT locationId, name, addressId, locationType, capacity, lon, lat FROM Locations WHERE locationId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $locations = $this->buildLocations($result);
        return empty($locations) ? null : $locations[0];
    }

    public function getLocationsByType($type)
    {
        $sql = "SELECT locationId, name, addressId, locationType, capacity, lon, lat FROM Locations WHERE locationType = :type";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":type", $type, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->buildLocations($result);
    }

    public function insertLocation($name, $addressId, $locationType, $lon, $lat, $capacity): int
    {
        $sql = "INSERT INTO Locations (name, addressId, locationType, lon, lat, capacity) VALUES (:name, :addressId, :locationType, :lon, :lat, :capacity)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":addressId", $addressId, PDO::PARAM_INT);
        $stmt->bindParam(":locationType", $locationType, PDO::PARAM_INT);
        $stmt->bindParam(":lon", $lon, PDO::PARAM_STR);
        $stmt->bindParam(":lat", $lat, PDO::PARAM_STR);
        $stmt->bindParam(":capacity", $capacity, PDO::PARAM_INT);
        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function updateLocation($id, $name, $addressId, $locationType, $lon, $lat, $capacity)
    {
        $sql = "UPDATE Locations SET name = :name, addressId = :addressId, locationType = :locationType, lon = :lon, lat = :lat, capacity = :capacity WHERE locationId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":addressId", $addressId, PDO::PARAM_INT);
        $stmt->bindParam(":locationType", $locationType, PDO::PARAM_INT);
        $stmt->bindParam(":lon", $lon, PDO::PARAM_STR);
        $stmt->bindParam(":lat", $lat, PDO::PARAM_STR);
        $stmt->bindParam(":capacity", $capacity, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteLocation($id)
    {
        $sql = "DELETE FROM Locations WHERE locationId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}