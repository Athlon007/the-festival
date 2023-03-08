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

            $address = $addressRepository->getAddressById($addressId);

            $location = new Location($locationId, $name, $address, $locationType, $lon, $lat);

            array_push($output, $location);
        }

        return $output;
    }

    public function getAll()
    {
        $sql = "SELECT locationId, name, addressId, locationType, lon, lat FROM `Locations`";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->buildLocations($result);
    }

    public function getById($id)
    {
        $sql = "SELECT locationId, name, addressId, locationType, lon, lat FROM Locations WHERE locationId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $locations = $this->buildLocations($result);
        return empty($locations) ? null : $locations[0];
    }

    public function getLocationsByType($type)
    {
        $sql = "SELECT locationId, name, addressId, locationType, lon, lat FROM Locations WHERE locationType = :type";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":type", $type, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->buildLocations($result);
    }

    public function insertLocation($name, $addressId, $locationType, $lon, $lat): int
    {
        $sql = "INSERT INTO Locations (name, addressId, locationType, lon, lat) VALUES (:name, :addressId, :locationType, :lon, :lat)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":addressId", $addressId, PDO::PARAM_INT);
        $stmt->bindParam(":locationType", $locationType, PDO::PARAM_INT);
        $stmt->bindParam(":lon", $lon, PDO::PARAM_STR);
        $stmt->bindParam(":lat", $lat, PDO::PARAM_STR);
        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function updateLocation($id, $name, $addressId, $locationType, $lon, $lat)
    {
        $sql = "UPDATE Locations SET name = :name, addressId = :addressId, locationType = :locationType, lon = :lon, lat = :lat WHERE locationId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":addressId", $addressId, PDO::PARAM_INT);
        $stmt->bindParam(":locationType", $locationType, PDO::PARAM_INT);
        $stmt->bindParam(":lon", $lon, PDO::PARAM_STR);
        $stmt->bindParam(":lat", $lat, PDO::PARAM_STR);
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
