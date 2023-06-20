<?php

require_once("EventRepository.php");
require_once("TicketLinkRepository.php");
require_once("TicketTypeRepository.php");

class HistoryTicketLinkRepository extends TicketLinkRepository
{
    protected function build($arr): array
    {
        $eventRepo = new EventRepository();
        $ttRepo = new TicketTypeRepository();
        $output = array();

        foreach ($arr as $item) {
            $event = $eventRepo->getEventById($item['eventId']);
            $ticketType = $ttRepo->getById($item['ticketTypeId']);
            $cartItem = new TicketLink($item['ticketLinkId'], $event, $ticketType);
            array_push($output, $cartItem);
        }

        return $output;
    }


    public function getAll($sort = null, $filters = [])
    {
        try {
            $sql = "select c.ticketLinkId, e.eventId, t.ticketTypeId, h.locationId
            from ticketlinks c
            join tickettypes t ON t.ticketTypeId = c.ticketTypeId
            join events e  on e.eventId = c.eventId
            join historyevents h on h.eventId  = e.eventId
            join guides g on g.guideId = h.guideId ";

            if (!empty($filters)) {
                $sql .= " WHERE ";

                foreach ($filters as $key => $value) {
                    switch ($key) {
                        case "date":
                            // date equals.
                            $sql .= " DATE(e.startTime) = :$key ";
                            break;
                        case "language":
                            $sql .= " g.language = :$key ";
                            break;
                        case "time":
                            $sql .= " hour(e.startTime) = :$key ";
                            break;
                        case "type":
                            $sql .= " c.ticketTypeId = :$key ";
                            break;
                    }

                    if (next($filters)) {
                        $sql .= " AND ";
                    }
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

    public function getById($id)
    {
        $sql = "SELECT ticketLinkId, eventId, ticketTypeId FROM ticketlinks WHERE ticketLinkId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $this->build([$result])[0];
    }

    public function getByEventId($id): ?TicketLink
    {
        $sql = "SELECT ticketLinkId, eventId, ticketTypeId FROM ticketlinks WHERE eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $output = $this->build($result);
        if (count($output) > 0) {
            return $output[0];
        }
        return null;
    }

    public function getLocationIdFromEventId($eventId): int
    {
        $sql = "select h.locationId from historyevents h where h.eventId = :eventId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['locationId'];
    }
}
