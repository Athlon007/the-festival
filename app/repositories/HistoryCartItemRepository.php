<?php

require_once("EventRepository.php");
require_once("CartItemRepository.php");
require_once("TicketTypeRepository.php");

class HistoryCartItemRepository extends CartItemRepository
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
        try {
            $sql = "select c.cartItemId, e.eventId, t.ticketTypeId, h.locationId
            from cartitems c
            join tickettypes t ON t.ticketTypeId = c.ticketTypeId
            join events e  on e.eventId = c.eventId
            join historyevents h on h.eventId  = e.eventId
            join guides g on g.guideId = h.guideId ";

            foreach ($filters as $key => $value) {
                switch ($key) {
                    case "date":
                        // date equals.
                        $sql .= " WHERE DATE(e.startTime) = :$key ";
                        break;
                    case "language":
                        $sql .= " WHERE g.language = :$key ";
                        break;
                    case "time":
                        $sql .= " WHERE hour(e.startTime) = :$key";
                        break;
                    case "type":
                        $sql .= " WHERE c.ticketTypeId = :$key";
                        break;
                }

                if (next($filters)) {
                    $sql .= " AND ";
                }
            }

            $stmt = $this->connection->prepare($sql);

            foreach ($filters as $key => $value) {
                if ($key === 'time') {
                    // split at : and get first part
                    $value = explode(':', $value)[0];
                }

                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            $result = $stmt->fetchAll();

            return $this->build($result);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
