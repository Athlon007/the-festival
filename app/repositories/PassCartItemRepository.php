<?php

require_once("EventRepository.php");
require_once("CartItemRepository.php");

class PassCartItemRepository extends CartItemRepository
{
    protected function build($arr): array
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

    public function getAll($sort = null, $filters = [])
    {
        // availableTickets is null if it's a pass
        $sql = "SELECT c.cartItemId, c.eventId, c.ticketTypeId FROM cartitems c
        JOIN events e ON e.eventId = c.eventId
        WHERE e.availableTickets = 0";

        if (!empty($filters)) {
            $sql .= " AND ";
            foreach ($filters as $key => $value) {
                switch ($key) {
                    case 'event_type':
                        $sql .= "e.festivalEventType >= :$key ";
                        break;
                }

                if (next($filters)) {
                    $sql .= " AND ";
                }
            }
        }

        $stmt = $this->connection->prepare($sql);

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->build($result);
    }
}
