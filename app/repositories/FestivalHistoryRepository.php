<?php

require_once("../models/History/HistoryEvent.php");
require_once("../repositories/Repository.php");

require_once("../models/Guide.php");
require_once("../models/Location.php");
require_once("../models/Address.php");

require_once("AddressRepository.php");
require_once("LocationRepository.php");

class FestivalHistoryRepository extends Repository
{

    public function getAllHistoryEvents()
    {
        try {
            $query = "SELECT e.eventId AS eventId, e.name AS name, e.startTime AS startTime, e.endTime AS endTime, e.price AS price, h.guideId AS guideId, h.locationId AS locationId
        FROM historyevents h 
        JOIN events e ON e.eventId = h.eventId";

            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            $historyEvents = [];
            // fetch results as HistoryEvent objects
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $guide = $this->getGuideByID($result['guideId']);
                $locationRep = new LocationRepository();
                $location = $locationRep->getById($result['locationId']);
                $startTime = new DateTime($result['startTime']);
                $endTime = new DateTime($result['endTime']);

                $historyEvent = new HistoryEvent($result['eventId'], $result['name'], $startTime, $endTime, $result['price'], $guide, $location);
                $historyEvents[] = $historyEvent;
            }

            if (count($historyEvents) === 0) {
                throw new Exception("No history events found");
            }

            return $historyEvents;
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function getGuideByID($id)
    {
        try {
            $query = "SELECT g.guideId, g.name as firstName, g.lastName , g.`language` , g.description  FROM guides g where guideId = :id";

            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            // fetch result as an object
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Guide');
            $guide = $stmt->fetch();

            if (!$guide) {
                throw new Exception("No guide found");
            }

            return $guide;
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

}