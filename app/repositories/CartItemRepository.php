<?php

require_once(__DIR__ . "/../models/CartItem.php");
require_once("Repository.php");
require_once("EventRepository.php");
require_once("TicketTypeRepository.php");

class CartItemRepository extends Repository
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
        $sql = "SELECT cartItemId, eventId, ticketTypeId FROM cartitems";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $this->build($result);
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
        return $this->build($result);
    }

    protected function readIfSet($value)
    {
        if (isset($value)) {
            return $value;
        } else {
            return "";
        }
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
