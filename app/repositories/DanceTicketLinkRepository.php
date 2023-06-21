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
     * Gets one TicketLink by TicketLinkId
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
     * Gets one TicketLink by EventId
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
     * Gets all Dance TicketLinks (combo event + tickettype)
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
        JOIN events e ON e.eventId = de.eventId
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

    /**
     * Fetches all artists for a specific dance event
     * @param $id
     * @return array
     * @throws Exception
     */
    private function getLineUpForEvent($id): array
    {
        $sql = "SELECT
        a.artistId as artistId,
        a.name as artistName,
        a.description as artistDescription,
        a.recentAlbums as artistRecentAlbums,
        a.genres as artistGenres,
        a.country as artistCountry,
        a.homepageUrl as artistHomepage,
        a.facebookUrl as artistFacebook,
        a.twitterUrl as artistTwitter,
        a.instagramUrl as artistInstagram,
        a.spotifyUrl as artistSpotify,
        a.artistKindId as artistKindId,
        ak.name as artistKindName
        FROM dancelineups d 
        JOIN artists a on a.artistId = d.artistId
        JOIN artistkinds ak on ak.id = a.artistKindId
        WHERE d.eventId = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(":id", htmlspecialchars($id));
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->buildArtists($result);
    }

    /**
     * Used to build the dance lineup (artists array) from extracted sql data
     * @param $result
     * @return array
     * @throws Exception
     */
    private function buildArtists($result) : array {
        $artists = array();
        foreach($result as $row){
            $artistKind = new ArtistKind(
                $row['artistKindId'],
                $row['artistKindName']
            );

            $artist = new Artist(
                $row['artistId'],
                htmlspecialchars_decode($row['artistName']),
                htmlspecialchars_decode($this->readIfSet($row['artistDescription'])),
                array(),
                htmlspecialchars_decode($this->readIfSet($row['artistCountry'])),
                htmlspecialchars_decode($this->readIfSet($row['artistGenres'])),
                htmlspecialchars_decode($this->readIfSet($row['artistHomepage'])),
                htmlspecialchars_decode($this->readIfSet($row['artistFacebook'])),
                htmlspecialchars_decode($this->readIfSet($row['artistTwitter'])),
                htmlspecialchars_decode($this->readIfSet($row['artistInstagram'])),
                htmlspecialchars_decode($this->readIfSet($row['artistSpotify'])),
                htmlspecialchars_decode($this->readIfSet($row['artistRecentAlbums'])),
                $artistKind
            );
            $artists[] = $artist;
        }

        return $artists;
    }
}