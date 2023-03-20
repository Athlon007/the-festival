<?php

require_once(__DIR__ . "/../models/Event.php");
require_once(__DIR__ . "/../models/Music/MusicEvent.php");
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

    private function buildJazzEvent($arr, $filters = null): array
    {
        $events = [];
        $locationRepo = new LocationRepository();
        $artistRepo = new JazzArtistRepository();
        foreach ($arr as $event) {
            $event = new MusicEvent(
                $event['eventId'],
                $event['name'],
                new DateTime($event['startTime']),
                new DateTime($event['endTime']),
                $event['price'],
                $artistRepo->getById($event['artistId']),
                $locationRepo->getById($event['locationId'])
            );

            if (isset($filters['artist_kind'])) {
                if ($filters['artist_kind'] === 'jazz' && $event->getArtist()->getArtistKind()->getName() !== 'Jazz') {
                    continue;
                }
                if ($filters['artist_kind'] === 'dance' && $event->getArtist()->getArtistKind()->getName() !== 'DANCE!') {
                    continue;
                }
            }

            array_push($events, $event);
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
        $stmt->bindValue(':price', $price);
        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function updateEvent($id, $name, $startTime, $endTime, $price)
    {
        $sql = "UPDATE Events SET name = :name, startTime = :startTime, endTime = :endTime, price = :price WHERE eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':startTime', $this->formatDateTimeToString($startTime), PDO::PARAM_STR);
        $stmt->bindParam(':endTime', $this->formatDateTimeToString($endTime), PDO::PARAM_STR);
        $stmt->bindValue(':price', $price);
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

    public function getAllJazzEvents($sort, array $filters)
    {
        $sql = "SELECT je.eventId, je.artistId, je.locationId, e.name, e.startTime, e.endTime, e.price "
            . "FROM JazzEvents je "
            . "JOIN Events e ON e.eventId = je.eventId";


        if (!empty($filters) && !(count($filters) === 1 && isset($filters['artist_kind']))) {
            // if only filter is artist_kind, skip
            $sql .= " WHERE ";
            $i = 0;
            foreach ($filters as $filter) {
                $key = array_keys($filters, $filter)[0];

                switch ($key) {
                    case 'price_from':
                        $sql .= " e.price >= :$key ";
                        break;
                    case 'price_to':
                        $sql .= " e.price <= :$key ";
                        break;
                    case 'time_from':
                        $sql .= " HOUR(e.startTime) >= :$key ";
                        break;
                    case 'time_to':
                        $sql .= " HOUR(e.endTime) <= :$key ";
                        break;
                    case 'hide_no_seats':
                        // TODO: Hide events with no seats.
                        break;
                    default:
                        // no filtering by default
                        $i++;
                        continue 2;
                }

                if ($i < count($filters) - 1) {
                    $sql .= " AND ";
                }
                $i++;
            }
        }

        switch ($sort) {
            case "time_desc":
                $sql .= " ORDER BY e.startTime DESC";
                break;
            case "price":
                $sql .= " ORDER BY e.price";
                break;
            case "price_desc":
                $sql .= " ORDER BY e.price DESC";
                break;
            default:
                $sql .= " ORDER BY e.startTime";
                break;
        }

        $stmt = $this->connection->prepare($sql);

        if (!(count($filters) === 1 && isset($filters['artist_kind']))) {
            foreach ($filters as $filter) {
                $key = array_keys($filters, $filter)[0];

                if ($key == 'artist_kind') {
                    continue;
                }

                $pdoType = is_numeric($filter) ? PDO::PARAM_INT : PDO::PARAM_STR;
                if (str_starts_with($key, 'price')) {
                    $pdoType = PDO::PARAM_STR;
                }
                $stmt->bindValue(':' . $key, $filter, $pdoType);
            }
        }

        $stmt->execute();
        $arr = $stmt->fetchAll();
        return $this->buildJazzEvent($arr, $filters);
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
