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
            // $event = $eventRepo->getEventById($item['eventId']);
            // $ticketType = $ttRepo->getById($item['ticketTypeId']);

            $event = new Event();
            $event->setId($item['eventId']);
            $event->setName($item['name']);
            $event->setStartTime(new DateTime($item['startTime']));
            $event->setEndTime(new DateTime($item['endTime']));
            $eventType = new EventType(
            $item['eventTypeId'], 
            $item['name'],
            $item['VAT']);
            $location = new Location(
            );
            $location->setLocationId($item['locationId']);
            $location->setName($item['name']);
            $address = new Address();
            $address->setStreetName($item['streetName']);
            $address->setHouseNumber($item['houseNumber']);
            $address->setPostalCode($item['postalCode']);
            $address->setCity($item['city']);
            $address->setCountry($item['country']);
            $location->setAddress($address);
            $location->setDescription($item['description']);
            $location->setLat($item['lat']);
            $location->setLon($item['lon']);
            $guide = new Guide(
            );
            $guide->setGuideId($item['guideId']);
            $guide->setFirstName($item['name']);
            $guide->setLastName($item['lastName']);
            $guide->setLanguage($item['language']);
            $event->setEventType($eventType);
            $event->setAvailableTickets($item['availableTickets']);


            $ticketType = new TicketType(
                $item['ticketTypeId'],
                $item['ticketTypeName'],
                $item['ticketTypePrice'],
                $item['nrOfPeople']
            );

            $cartItem = new TicketLink($item['ticketLinkId'], $event, $ticketType);
            array_push($output, $cartItem);
        }

        return $output;
    }

    public function getAll($sort = null, $filters = [])
    {
        try {
            $sql = "select c.ticketLinkId,
             e.eventId,
             e.name,
             e.startTime,
             e.eventId, 
             e.festivalEventType, 
             e.availableTickets, 
             t.ticketTypeId, 
             h.locationId,
             t.ticketTypeId, 
             t.ticketTypeName, 
             t.ticketTypePrice, 
             t.nrOfPeople,
             f.eventTypeId,
             f.name,
             f.VAT,
             l.name,
             l.locationType,
             l.lon,
             l.lat,
             l.description,
             a.streetName,
             a.houseNumber, 
             a.postalCode, 
             a.city, 
             a.country,
             g.guideId,
             g.name, 
             g.lastName, 
             g.`language`
             from ticketlinks c
             join tickettypes t ON t.ticketTypeId = c.ticketTypeId
             join events e  on e.eventId = c.eventId
             join historyevents h on h.eventId  = e.eventId
             join guides g on g.guideId = h.guideId
             join locations l on l.locationId = h.locationId
             join festivaleventtypes f on f.eventTypeId = e.festivalEventType
             join addresses a on a.addressId = l.addressId;";

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
