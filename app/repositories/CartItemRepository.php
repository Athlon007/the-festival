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

    public function getAllPasses($filters = [])
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
        return $this->buildCartItems($result);
    }

    public function getAllHistory($filters)
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

            return $this->buildCartItems($result);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    private function buildJazzCartItems($arr)
    {
        require_once(__DIR__ . '/../models/Address.php');
        require_once(__DIR__ . "/../models/Location.php");
        require_once(__DIR__ . "/../models/Types/TicketType.php");
        require_once(__DIR__ . "/../models/Types/EventType.php");
        require_once(__DIR__ . "/../models/Music/Artist.php");
        require_once(__DIR__ . "/../models/Music/ArtistKind.php");
        require_once(__DIR__ . '/ImageRepository.php');
        require_once(__DIR__ . "/../models/Music/MusicEvent.php");
        require_once(__DIR__ . "/../models/CartItem.php");

        $imageRepository = new ImageRepository();
        $output = array();
        foreach ($arr as $item) {
            $address = new Address(
                $item['addressId'],
                $item['addressStreetName'],
                $item['addressHouseNumber'],
                $item['addressPostalCode'],
                $item['addressCity'],
                $item['addressCountry']
            );
            $location = new Location(
                $item['locationId'],
                $item['locationName'],
                $address,
                $item['locationType'],
                $item['locationLon'],
                $item['locationLat'],
                $item['locationCapacity'],
                $item['locationDescription']
            );
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
            $images = $imageRepository->getImagesForArtistId($item['artistId']);
            $artistKind = new ArtistKind(
                $item['artistKindId'],
                $item['artistKindName']
            );
            $artist = new Artist(
                $item['artistId'],
                htmlspecialchars_decode($item['artistName']),
                htmlspecialchars_decode($this->readIfSet($item['artistDescription'])),
                $images,
                $this->readIfSet($item['artistCountry']),
                $this->readIfSet($item['artistGenres']),
                $this->readIfSet($item['artistHomepage']),
                $this->readIfSet($item['artistFacebook']),
                $this->readIfSet($item['artistTwitter']),
                $this->readIfSet($item['artistInstagram']),
                $this->readIfSet($item['artistSpotify']),
                $this->readIfSet($item['artistRecentAlbums']),
                $artistKind
            );

            $event = new MusicEvent(
                $item['eventId'],
                htmlspecialchars_decode($item['eventName']),
                new DateTime($item['startTime']),
                new DateTime($item['endTime']),
                $artist,
                $location,
                $eventType,
                $item['availableTickets']
            );

            $cartItem = new CartItem(
                $item['cartItemId'],
                $event,
                $ticketType
            );

            array_push($output, $cartItem);
        }

        return $output;
    }

    private function readIfSet($value)
    {
        if (isset($value)) {
            return $value;
        } else {
            return "";
        }
    }

    public function getAllJazz($sort = null, $filters = [])
    {
        $sql = "SELECT e.eventId,
		e.name as eventName,
		e.startTime,
		e.endTime,
		e.availableTickets - (select count(t2.eventId) from tickets t2 where t2.eventid = e.eventId) as availableTickets,
		a.artistId,
		a.name  as artistName,
		a.description as artistDescription,
		a.recentAlbums as artistRecentAlbums,
		a.genres as artistGenres,
		a.country as artistCountry,
		a.homepageUrl as artistHomepage,
		a.facebookUrl as artistFacebok,
		a.twitterUrl as artistTwitter,
		a.instagramUrl as artistInstagram,
		a.spotifyUrl as artistSpotify,
		a.homepageUrl as artistHomepage,
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
		a2.id as artistKindId,
		a2.name as artistKindName,
        c.cartItemId as cartItemId
FROM JazzEvents je
JOIN Events e ON e.eventId = je.eventId
JOIN cartitems c on e.eventId = c.eventId
join tickettypes t on c.ticketTypeId = t.ticketTypeId
join jazzartists a on a.artistId = je.artistId
join locations l on l.locationId = je.locationId
join festivaleventtypes f on f.eventTypeId  = e.festivalEventType
join addresses ad on ad.addressId =l.addressId
join artistkinds a2 on a2.id = a.artistKindId ";

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
        return $this->buildJazzCartItems($result);
    }


    public function getById($id)
    {
        $sql = "SELECT e.eventId,
		e.name as eventName,
		e.startTime,
		e.endTime,
		e.availableTickets - (select count(t2.eventId) from tickets t2 where t2.eventid = e.eventId) as availableTickets,
		a.artistId,
		a.name  as artistName,
		a.description as artistDescription,
		a.recentAlbums as artistRecentAlbums,
		a.genres as artistGenres,
		a.country as artistCountry,
		a.homepageUrl as artistHomepage,
		a.facebookUrl as artistFacebok,
		a.twitterUrl as artistTwitter,
		a.instagramUrl as artistInstagram,
		a.spotifyUrl as artistSpotify,
		a.homepageUrl as artistHomepage,
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
		a2.id as artistKindId,
		a2.name as artistKindName,
        c.cartItemId as cartItemId
FROM JazzEvents je
JOIN Events e ON e.eventId = je.eventId
JOIN cartitems c on e.eventId = c.eventId
join tickettypes t on c.ticketTypeId = t.ticketTypeId
join jazzartists a on a.artistId = je.artistId
join locations l on l.locationId = je.locationId
join festivaleventtypes f on f.eventTypeId  = e.festivalEventType
join addresses ad on ad.addressId =l.addressId
join artistkinds a2 on a2.id = a.artistKindId
WHERE cartItemId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        $output = $this->buildJazzCartItems($result);
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
		a.artistId,
		a.name  as artistName,
		a.description as artistDescription,
		a.recentAlbums as artistRecentAlbums,
		a.genres as artistGenres,
		a.country as artistCountry,
		a.homepageUrl as artistHomepage,
		a.facebookUrl as artistFacebok,
		a.twitterUrl as artistTwitter,
		a.instagramUrl as artistInstagram,
		a.spotifyUrl as artistSpotify,
		a.homepageUrl as artistHomepage,
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
		a2.id as artistKindId,
		a2.name as artistKindName,
        c.cartItemId as cartItemId
FROM JazzEvents je
JOIN Events e ON e.eventId = je.eventId
JOIN cartitems c on e.eventId = c.eventId
join tickettypes t on c.ticketTypeId = t.ticketTypeId
join jazzartists a on a.artistId = je.artistId
join locations l on l.locationId = je.locationId
join festivaleventtypes f on f.eventTypeId  = e.festivalEventType
join addresses ad on ad.addressId =l.addressId
join artistkinds a2 on a2.id = a.artistKindId
WHERE e.eventId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $output = $this->buildJazzCartItems($result);
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
