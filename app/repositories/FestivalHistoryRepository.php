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

    // public function getAllHistoryEvents()
    // {
    //     try {
    //         $query = "SELECT e.eventId AS eventId, e.name AS name, e.startTime AS startTime,
    //         e.endTime AS endTime, h.guideId AS guideId, h.locationId AS locationId,
    //         t2.ticketTypePrice as Price, g.`language` as Lang, l.name as LocationName,
    //         e.availableTickets as Capacity
    //         FROM historyevents h
    //                 JOIN events e ON e.eventId = h.eventId
    //                 join ticketlinks t on e.eventId = t.eventId 
    //                 join tickettypes t2 on t2.ticketTypeId = t.ticketTypeId
    //                 join guides g ON g.guideId = h.guideId
    //                 join locations l ON h.locationId = l.locationId";

    //         $stmt = $this->connection->prepare($query);
    //         $stmt->execute();

    //         $historyEvents = [];
    //         // fetch results as HistoryEvent objects
    //         while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //             $guide = $this->getGuideByID($result['guideId']);
    //             $locationRep = new LocationRepository();
    //             $location = $locationRep->getById($result['locationId']);
    //             $startTime = new DateTime($result['startTime']);
    //             $endTime = new DateTime($result['endTime']);

    //             $historyEvent = new HistoryEvent($result['eventId'], $result['name'], 0, $startTime, $endTime, $guide, $location);
    //             $historyEvents[] = $historyEvent;
    //         }

    //         if (count($historyEvents) === 0) {
    //             throw new Exception("No history events found");
    //         }

    //         return $historyEvents;
    //     } catch (Exception $ex) {
    //         throw $ex;
    //     }
    // }

    public function getAllHistoryEvents()
    {
        try {
            $query = "SELECT e.eventId AS eventId, f.name  AS name, e.startTime AS startTime,
            e.endTime AS endTime, h.guideId AS guideId, h.locationId AS locationId,
            g.`language` as Lang, l.name as LocationName,
            e.availableTickets as Capacity
            FROM historyevents h
                    JOIN events e ON e.eventId = h.eventId
                    join ticketlinks t on e.eventId = t.eventId 
                    join guides g ON g.guideId = h.guideId
                    join locations l ON h.locationId = l.locationId
                    join festivaleventtypes f on f.eventTypeId = e.festivalEventType";

            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            $historyEvents = [];
            while ($results = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $guide = $this->getGuideByID($results['guideId']);
                $locationRep = new LocationRepository();
                $location = $locationRep->getById($results['locationId']);
                $startTime = new DateTime($results['startTime']);
                $endTime = new DateTime($results['endTime']);
                $availableTickets = $results['Capacity'];
                $eventType = $results['name'];
            }

            if (count($historyEvents) === 0) {
                throw new Exception("No history events found");
            }

            return $historyEvents;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    // TODO: remove this method
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
}