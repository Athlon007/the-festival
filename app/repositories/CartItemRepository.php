<?php

require_once(__DIR__ . "/../models/CartItem.php");
require_once("Repository.php");
require_once("EventRepository.php");
require_once("TicketTypeRepository.php");

class CartItemRepository extends Repository
{
    private function buildCartItems($arr): array
    {
        $eventRepo = new EventRepository();
        $ttRepo = new TicketTypeRepository();
        $output = array();

        foreach ($arr as $item) {
            $event = $eventRepo->getEventById($item['eventId']);
            $ticketType = $ttRepo->getById($item['ticketTypeId']);
            $cartItem = new CartItem($item['cartItemId'], $event, $ticketType);
            array_push($output, $cartItem);
        }

        return $output;
    }

    public function getAll()
    {
        $sql = "SELECT cartItemId, eventId, ticketTypeId FROM cartitems";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->buildCartItems($result);
    }

    public function getAllPasses()
    {
        // availableTickets is null if it's a pass
        $sql = "SELECT c.cartItemId, c.eventId, c.ticketTypeId FROM cartitems c
        JOIN events e ON e.eventId = c.eventId
        WHERE availableTickets IS NULL";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->buildCartItems($result);
    }

    public function getAllHistory()
    {
        try {
            $sql = "select c.cartItemId, e.eventId, t.ticketTypeId, h.locationId
            from cartitems c
            join tickettypes t ON t.ticketTypeId = c.ticketTypeId
            join events e  on e.eventId = c.eventId
            join historyevents h on h.eventId  = e.eventId ";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $this->buildCartItems($result);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getAllJazz($sort = null, $filters = [])
    {
        $sql = "select c.cartItemId, e.eventId, t.ticketTypeId, je.locationId " .
            "from cartitems c " .
            "join tickettypes t ON t.ticketTypeId = c.ticketTypeId " .
            "join events e  on e.eventId = c.eventId " .
            "join jazzevents je on je.eventId = e.eventId ";

        if (!empty($filters) && !(count($filters) === 1 && isset($filters['artist_kind']))) {
            // if only filter is artist_kind, skip
            $sql .= " WHERE ";
            $i = 0;
            if (isset($filters['artist_kind'])) {
                $i++;
            }

            foreach ($filters as $key => $filter) {
                switch ($key) {
                    case 'price_from':
                        $sql .= " t.ticketTypePrice >= :$key ";
                        break;
                    case 'price_to':
                        $sql .= " t.ticketTypePrice <= :$key ";
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
                    case 'day':
                        $sql .= " DAY(e.startTime) = :$key ";
                        break;
                    case 'date':
                        $sql .= " DATE(e.startTime) = :$key ";
                        break;
                    case 'location':
                        $sql .= " je.locationId = :$key ";
                        break;
                    case 'artist':
                        $sql .= " je.artistId = :$key ";
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

        if (isset($sort)) {
            switch ($sort) {
                case "time_desc":
                    $sql .= " ORDER BY e.startTime DESC";
                    break;
                case "price":
                    $sql .= " ORDER BY t.ticketTypePrice";
                    break;
                case "price_desc":
                    $sql .= " ORDER BY t.ticketTypePrice DESC";
                    break;
                default:
                    $sql .= " ORDER BY e.startTime";
                    break;
            }
        }

        $stmt = $this->connection->prepare($sql);

        if (!(count($filters) === 1 && isset($filters['artist_kind']))) {
            foreach ($filters as $key => $filter) {
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
        $result = $stmt->fetchAll();

        require_once(__DIR__ . "/LocationRepository.php");
        $eventRepo = new EventRepository();
        $locationRepo = new LocationRepository();
        $ticketTypeRepo = new TicketTypeRepository();
        $output = array();
        foreach ($result as $key => $item) {
            $event = $eventRepo->getJazzEventById($item['eventId']);
            $location = $locationRepo->getById($item['locationId']);
            $event->setLocation($location);
            $ticketType = $ticketTypeRepo->getById($item['ticketTypeId']);
            $cartItem = new CartItem($item['cartItemId'], $event, $ticketType);
            array_push($output, $cartItem);
        }

        return $output;
    }


    public function getById($id)
    {
        $sql = "SELECT cartItemId, eventId, ticketTypeId FROM cartitems WHERE cartItemId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $this->buildCartItems([$result])[0];
    }

    public function getByEventId($id): ?CartItem
    {
        $sql = "SELECT cartItemId, eventId, ticketTypeId FROM cartitems WHERE eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $output = $this->buildCartItems($result);
        if (count($output) > 0) {
            return $output[0];
        }
        return null;
    }

    public function createCartItem($eventId, $ticketTypeId): int
    {
        $sql = "INSERT INTO cartitems (eventId, ticketTypeId) VALUES (:eventId, :ticketTypeId)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->bindParam(':ticketTypeId', $ticketTypeId, PDO::PARAM_INT);
        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function updateCartItem($id, $eventId, $ticketTypeId)
    {
        $sql = "UPDATE cartitems SET eventId = :eventId, ticketTypeId = :ticketTypeId WHERE cartItemId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->bindParam(':ticketTypeId', $ticketTypeId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteCartItem($id)
    {
        $sql = "DELETE FROM cartitems WHERE cartItemId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
