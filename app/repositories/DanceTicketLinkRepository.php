<?php

require_once("EventRepository.php");
require_once("TicketLinkRepository.php");
require_once(__DIR__ . '/../models/Address.php');
require_once(__DIR__ . "/../models/Location.php");
require_once(__DIR__ . "/../models/Types/TicketType.php");
require_once(__DIR__ . "/../models/Types/EventType.php");
require_once(__DIR__ . "/../models/Music/Artist.php");
require_once(__DIR__ . "/../models/Music/ArtistKind.php");
require_once(__DIR__ . "/../models/Music/DanceEvent.php");
require_once(__DIR__ . "/../models/TicketLink.php");
require_once(__DIR__ . "/../models/Exceptions/ObjectNotFoundException.php");

/**
 * Class DanceTicketLinkRepository
 * Much of the SQL ideas are taken from Konrad's JazzTicketLinkRepository and were customised for Dance
 * @author Joshua
 * @extends TicketLinkRepository
 */
class DanceTicketLinkRepository extends TicketLinkRepository
{
    /**
     * Builds a DanceTicketLink from DanceEvent and TicketType
     * @throws Exception
     */
    protected function build($arr): array
    {
        $output = array();
        foreach ($arr as $item) {
            $address = new Address();
            $address->setAddressId($item['addressId']);
            $address->setStreetName($item['addressStreetName']);
            $address->setHouseNumber($item['addressHouseNumber']);
            $address->setPostalCode($item['addressPostalCode']);
            $address->setCity($item['addressCity']);
            $address->setCountry($item['addressCountry']);

            $location = new Location();
            $location->setLocationId($item['locationId']);
            $location->setName($item['locationName']);
            $location->setAddress($address);
            $location->setLocationType($item['locationType']);
            $location->setLon($item['locationLon']);
            $location->setLat($item['locationLat']);
            $location->setCapacity($item['locationCapacity']);
            $location->setDescription($item['locationDescription']);

            $ticketType = new TicketType(
                $item['ticketTypeId'],
                $item['ticketTypeName'],
                $item['ticketTypePrice'],
                $item['ticketTypeNrOfPeople']
            );
            $eventType = new EventType(
                $item['eventTypeId'],
                $item['eventTypeName'],
                $item['evenTypeVat']
            );
            $artistKind = new ArtistKind(
                $item['artistKindId'],
                $item['artistKindName']
            );

            $artists = $this->getLineUpForEvent($item['eventId']);
            foreach ($artists as $artist){
                $artist = new Artist(
                    $artist['artistId'],
                    htmlspecialchars_decode($artist['artistName']),
                    htmlspecialchars_decode($this->readIfSet($artist['artistDescription'])),
                    array(),
                    $this->readIfSet($artist['artistCountry']),
                    $this->readIfSet($artist['artistGenres']),
                    $this->readIfSet($artist['artistHomepage']),
                    $this->readIfSet($artist['artistFacebook']),
                    $this->readIfSet($artist['artistTwitter']),
                    $this->readIfSet($artist['artistInstagram']),
                    $this->readIfSet($artist['artistSpotify']),
                    $this->readIfSet($artist['artistRecentAlbums']),
                    $artistKind
                );
            }

            $event = new DanceEvent(
                $item['eventId'],
                htmlspecialchars_decode($item['eventName']),
                new DateTime($item['startTime']),
                new DateTime($item['endTime']),
                $location,
                $eventType,
                $artists,
                $item['availableTickets']
            );

            $ticketLink = new TicketLink(
                $item['ticketLinkId'],
                $event,
                $ticketType
            );

            $output[] = $ticketLink;
        }

        return $output;
    }

    /**
     * Gets TicketLink by TicketLinkId
     * @throws Exception
     * @return array
     */
    public function getById($id) : ?TicketLink
    {
        $sql = "SELECT e.eventId,
		e.name as eventName,
		e.startTime,
		e.endTime,
		e.availableTickets - (select count(t2.eventId) from tickets t2 where t2.eventid = e.eventId) as availableTickets,
		f.eventTypeId as eventTypeId,
		f.name as eventTypeName,
		f.VAT as evenTypeVat,
		l.locationId as locationId,
		l.name as locationName,
		l.locationType as locationType,
		l.capacity as locationCapacity,
		l.lon as locationLon,
		l.lat as locationLat,
		l.description as locationDescription,
		ad.addressId as addressId,
		ad.streetName as addressStreetName,
		ad.houseNumber as addressHouseNumber,
		ad.postalCode as addressPostalCode,
		ad.city as addressCity,
		ad.country as addressCountry,
		t.ticketTypeId as ticketTypeId,
		t.ticketTypeName as ticketTypeName,
		t.ticketTypePrice as ticketTypePrice,
		t.nrOfPeople as ticketTypeNrOfPeople,
        c.ticketLinkId as ticketLinkId
        FROM danceevents de
        JOIN events e ON e.eventId = de.eventId
        JOIN ticketlinks c on e.eventId = c.eventId
        JOIN tickettypes t on c.ticketTypeId = t.ticketTypeId
        JOIN locations l on l.locationId = de.locationId
        JOIN festivaleventtypes f on f.eventTypeId  = e.festivalEventType
        JOIN addresses ad on ad.addressId =l.addressId
        WHERE c.ticketLinkId = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", htmlspecialchars($id));
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }
        return $this->build($result)[0];
    }

/**
     * Gets TicketLink by EventId
     * @throws Exception
     * @return array
     */
    public function getByEventId($id): ?TicketLink
    {
        $sql = "SELECT e.eventId,
		e.name as eventName,
		e.startTime,
		e.endTime,
		e.availableTickets - (select count(t2.eventId) from tickets t2 where t2.eventid = e.eventId) as availableTickets,
		f.eventTypeId as eventTypeId,
		f.name as eventTypeName,
		f.VAT as evenTypeVat,
		l.locationId as locationId,
		l.name as locationName,
		l.locationType as locationType,
		l.capacity as locationCapacity,
		l.lon as locationLon,
		l.lat as locationLat,
		l.description as locationDescription,
		ad.addressId as addressId,
		ad.streetName as addressStreetName,
		ad.houseNumber as addressHouseNumber,
		ad.postalCode as addressPostalCode,
		ad.city as addressCity,
		ad.country as addressCountry,
		t.ticketTypeId as ticketTypeId,
		t.ticketTypeName as ticketTypeName,
		t.ticketTypePrice as ticketTypePrice,
		t.nrOfPeople as ticketTypeNrOfPeople,
        c.ticketLinkId as ticketLinkId
        FROM danceevents de
        JOIN events e ON e.eventId = de.eventId
        JOIN ticketlinks c on e.eventId = c.eventId
        JOIN tickettypes t on c.ticketTypeId = t.ticketTypeId
        JOIN locations l on l.locationId = de.locationId
        JOIN festivaleventtypes f on f.eventTypeId  = e.festivalEventType
        JOIN addresses ad on ad.addressId =l.addressId
        WHERE de.eventId = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":id", htmlspecialchars($id));
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }
        return $this->build($result)[0];
    }


    /**
     * Gets all TicketLinks
     * @param string $sort
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getAll($sort = null, $filters = []): array
    {
        $sql = "SELECT e.eventId,
		e.name as eventName,
		e.startTime,
		e.endTime,
		e.availableTickets - (select count(t2.eventId) from tickets t2 where t2.eventid = e.eventId) as availableTickets,
		f.eventTypeId as eventTypeId,
		f.name as eventTypeName,
		f.VAT as evenTypeVat,
		l.locationId as locationId,
		l.name as locationName,
		l.locationType as locationType,
		l.capacity as locationCapacity,
		l.lon as locationLon,
		l.lat as locationLat,
		l.description as locationDescription,
		ad.addressId as addressId,
		ad.streetName as addressStreetName,
		ad.houseNumber as addressHouseNumber,
		ad.postalCode as addressPostalCode,
		ad.city as addressCity,
		ad.country as addressCountry,
		t.ticketTypeId as ticketTypeId,
		t.ticketTypeName as ticketTypeName,
		t.ticketTypePrice as ticketTypePrice,
		t.nrOfPeople as ticketTypeNrOfPeople,
        c.ticketLinkId as ticketLinkId
        FROM danceevents de
        JOIN events e ON e.eventId = je.eventId
        JOIN ticketlinks c on e.eventId = c.eventId
        JOIN tickettypes t on c.ticketTypeId = t.ticketTypeId
        JOIN locations l on l.locationId = de.locationId
        JOIN festivaleventtypes f on f.eventTypeId  = e.festivalEventType
        JOIN addresses ad on ad.addressId =l.addressId";

        if (!empty($filters)) {
            $sql .= " WHERE ";

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
                    case 'hide_without_seats':
                        $sql .= " availableTickets > 0 ";
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
                    default:
                        continue 2;
                }

                // Add "AND" if there are more filters
                if (next($filters)) {
                    $sql .= " AND ";
                }
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

        foreach ($filters as $key => $filter) {
            // If the filter is empty, skip. DO NOT SKIP IF THAT IS A NUMBER!
            if (empty($filter) && !is_numeric($filter)) {
                continue;
            }

            $pdoType = is_numeric($filter) ? PDO::PARAM_INT : PDO::PARAM_STR;
            if (str_starts_with($key, 'price')) {
                $pdoType = PDO::PARAM_STR;
            }
            $stmt->bindValue(':' . $key, $filter, $pdoType);
        }

        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->build($result);
    }

    private function getLineUpForEvent($id): array
    {
        $sql = "SELECT * from dancelineups d 
        join artists a on a.artistId = d.artistId
        where d.eventId = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id", htmlspecialchars($id));
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}