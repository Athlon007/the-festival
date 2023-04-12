<?php

require_once(__DIR__ . "/../models/CartItem.php");
require_once(__DIR__ . "/../models/Types/TicketType.php");
require_once(__DIR__ . "/../models/Types/EventType.php");
require_once("Repository.php");

class CartItemRepository extends Repository
{
    protected function build($arr): array
    {
        require_once(__DIR__ . "/../models/Event.php");

        $output = array();

        foreach ($arr as $item) {
            $evenType = new EventType(
                $item['eventTypeId'],
                $item['eventTypeName'],
                $item['evenTypeVat']
            );

            $event = new Event();
            $event->setId($item['eventId']);
            $event->setName(htmlspecialchars_decode($item['eventName']));
            $event->setStartTime(new DateTime($item['startTime']));
            $event->setEndTime(new DateTime($item['endTime']));
            $event->setAvailableTickets($item['availableTickets']);
            $event->setEventType($evenType);

            $ticketType = new TicketType(
                $item['ticketTypeId'],
                $item['ticketTypeName'],
                $item['ticketTypePrice'],
                $item['ticketTypeNrOfPeople']
            );

            $cartItem = new CartItem($item['cartItemId'], $event, $ticketType);

            $output[] = $cartItem;
        }

        return $output;
    }

    protected function readIfSet($value)
    {
        if (isset($value)) {
            return $value;
        } else {
            return "";
        }
    }

    public function getAll($sort = null, $filters = [])
    {
        $sql = "SELECT e.eventId,
		e.name as eventName,
		e.startTime,
		e.endTime,
		e.availableTickets - (select count(t2.eventId) from tickets t2 where t2.eventid = e.eventId) as availableTickets,
		f.eventTypeId as eventTypeId,
		f.name as eventTypeName,
		f.VAT as evenTypeVat,
		t.ticketTypeId as ticketTypeId,
		t.ticketTypeName as ticketTypeName,
		t.ticketTypePrice as ticketTypePrice,
		t.nrOfPeople as ticketTypeNrOfPeople,
        c.cartItemId as cartItemId
    FROM events e
    JOIN cartitems c on e.eventId = c.eventId
    join tickettypes t on c.ticketTypeId = t.ticketTypeId
    join festivaleventtypes f on f.eventTypeId  = e.festivalEventType";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->build($result);
    }


    public function getById($id)
    {
        $sql = "SELECT e.eventId,
		e.name as eventName,
		e.startTime,
		e.endTime,
		e.availableTickets - (select count(t2.eventId) from tickets t2 where t2.eventid = e.eventId) as availableTickets,
		f.eventTypeId as eventTypeId,
		f.name as eventTypeName,
		f.VAT as evenTypeVat,
		t.ticketTypeId as ticketTypeId,
		t.ticketTypeName as ticketTypeName,
		t.ticketTypePrice as ticketTypePrice,
		t.nrOfPeople as ticketTypeNrOfPeople,
        c.cartItemId as cartItemId
        FROM events e
        JOIN cartitems c on e.eventId = c.eventId
        join tickettypes t on c.ticketTypeId = t.ticketTypeId
        join festivaleventtypes f on f.eventTypeId  = e.festivalEventType
        WHERE cartItemId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $output = $this->build($result);

        if (empty($output)) {
            return null;
        }
        return $output[0];
    }

    public function getByEventId($id): ?CartItem
    {
        $sql = "SELECT e.eventId,
		e.name as eventName,
		e.startTime,
		e.endTime,
		e.availableTickets - (select count(t2.eventId) from tickets t2 where t2.eventid = e.eventId) as availableTickets,
		f.eventTypeId as eventTypeId,
		f.name as eventTypeName,
		f.VAT as evenTypeVat,
		t.ticketTypeId as ticketTypeId,
		t.ticketTypeName as ticketTypeName,
		t.ticketTypePrice as ticketTypePrice,
		t.nrOfPeople as ticketTypeNrOfPeople,
        c.cartItemId as cartItemId
        FROM events e
        JOIN cartitems c on e.eventId = c.eventId
        join tickettypes t on c.ticketTypeId = t.ticketTypeId
        join festivaleventtypes f on f.eventTypeId  = e.festivalEventType
        WHERE e.eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $output = $this->build($result);
        if (empty($output)) {
            return null;
        }
        return $output[0];
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
