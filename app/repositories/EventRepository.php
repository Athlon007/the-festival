<?php

require_once(__DIR__ . "/../models/Event.php");
require_once(__DIR__ . "/../models/Jazz/JazzEvent.php");
require_once("Repository.php");
require_once("LocationRepository.php");
require_once("JazzArtistRepository.php");

class EventRepository extends Repository
{
    private function buildEvent($arr): array
    {
        $events = [];
        foreach ($arr as $event) {
            if ($this->isInJazzEvents($event['eventId'])) {
                $events[] = $this->getJazzEventById($event['eventId']);
            } else {
                $eventEntry = new Event();
                $eventEntry->setId($event['eventId']);
                $eventEntry->setName($event['name']);
                $eventEntry->setStartTime(new DateTime($event['startTime']));
                $eventEntry->setEndTime(new DateTime($event['endTime']));
                $eventEntry->setPrice($event['price']);
                array_push($events, $eventEntry);
            }
        }
        return $events;
    }

    private function buildJazzEvent($arr): array
    {
        $events = [];
        $locationRepo = new LocationRepository();
        $artistRepo = new JazzArtistRepository();
        foreach ($arr as $event) {
            $events[] = new JazzEvent(
                $event['eventId'],
                $event['name'],
                new DateTime($event['startTime']),
                new DateTime($event['endTime']),
                $event['price'],
                $artistRepo->getById($event['artistId']),
                $locationRepo->getById($event['locationId'])
            );
        }
        return $events;
    }

    public function getAll()
    {
        $sql = "SELECT eventId, name, startTime, endTime, price FROM Events";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $arr = $stmt->fetchAll();
        return $this->buildEvent($arr);
    }

    public function getEventById($id)
    {
        $sql = "SELECT eventId, name, startTime, endTime, price FROM Events WHERE eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);
        $arr = $stmt->fetchAll();
        return $this->buildEvent($arr)[0];
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM Events WHERE eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    private function formatDateTimeToString(DateTime $dateTime): string
    {
        return $dateTime->format('Y-m-d H:i:s');
    }

    public function createEvent($name, DateTime $startTime, DateTime $endTime, $price): int
    {
        $sql = "INSERT INTO Events (name, startTime, endTime, price) VALUES (:name, :startTime, :endTime, :price)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $startToString = $this->formatDateTimeToString($startTime);
        $stmt->bindParam(':startTime', $startToString, PDO::PARAM_STR);
        $endToString = $this->formatDateTimeToString($endTime);
        $stmt->bindParam(':endTime', $endToString, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function updateEvent($id, $name, $startTime, $endTime, $price)
    {
        $sql = "UPDATE Events SET name = :name, startTime = :startTime, endTime = :endTime, price = :price WHERE eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
    }

    // JAZZ
    public function isInJazzEvents($id)
    {
        $sql = "SELECT eventId FROM JazzEvents WHERE eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => $id]);
        $arr = $stmt->fetchAll();
        return count($arr) > 0;
    }

    public function getAllJazzEvents()
    {
        $sql = "SELECT je.eventId, je.artistId, je.locationId, e.name, e.startTime, e.endTime, e.price "
            . "FROM JazzEvents je "
            . "JOIN Events e ON e.eventId = je.eventId";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $arr = $stmt->fetchAll();
        return $this->buildJazzEvent($arr);
    }

    public function getJazzEventById($id)
    {
        $sql = "SELECT je.eventId, je.artistId, je.locationId, e.name, e.startTime, e.endTime, e.price "
            . "FROM JazzEvents je "
            . "JOIN Events e ON e.eventId = je.eventId "
            . "WHERE je.eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $arr = $stmt->fetchAll();
        return $this->buildJazzEvent($arr)[0];
    }

    public function createJazzEvent($eventId, $artistId, $locationId): int
    {
        $sql = "INSERT INTO JazzEvents (eventId, artistId, locationId) VALUES (:eventId, :artistId, :locationId)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':artistId', $artistId);
        $stmt->bindParam(':locationId', $locationId);
        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function updateJazzEvent($eventId, $artistId, $locationId)
    {
        $sql = "UPDATE JazzEvents SET artistId = :artistId, locationId = :locationId WHERE eventId = :eventId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':eventId', $eventId);
        $stmt->bindParam(':artistId', $artistId);
        $stmt->bindParam(':locationId', $locationId);
        $stmt->execute();
    }

    public function getJazzEventsForArtist($artistId)
    {
        $sql = "SELECT je.eventId, je.artistId, je.locationId, e.name, e.startTime, e.endTime, e.price "
            . "FROM JazzEvents je "
            . "JOIN Events e ON e.eventId = je.eventId "
            . "WHERE artistId = :artistId";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['artistId' => $artistId]);
        $arr = $stmt->fetchAll();
        return $this->buildJazzEvent($arr);
    }
}
