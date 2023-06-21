<?php
require_once(__DIR__ . '/../models/Yummy/Restaurant.php');
require_once(__DIR__ . '/../models/Yummy/RestaurantEvent.php');
require_once(__DIR__ . '/../models/Yummy/RestaurantType.php');
require_once(__DIR__ . '/../repositories/Repository.php');
require_once(__DIR__ . '/../models/Types/EventType.php');

class RestaurantRepository extends Repository
{
    private function buildRestaurantEvents($input): array
    {
        $output = array();

        foreach ($input as $row) {
            $restaurantEvent = new RestaurantEvent();
            $restaurantEvent->setId($row['eventId']);
            $restaurantEvent->setName($row['name']);
            $restaurantEvent->setStartTime(new DateTime($row['startTime']));
            $restaurantEvent->setEndTime(new DateTime($row['endTime']));
            $restaurantEvent->setAvailableTickets($row['availableTickets']);

            $eventType = new EventType($row['eventTypeId'], $row['name'], $row['VAT']);
            $restaurantEvent->setEventType($eventType);

            $restaurant = new Restaurant();
            $restaurant->setRestaurantId($row['restaurantId']);
            $restaurant->setRestaurantName($row['restaurantName']);
            $restaurant->setAddressId($row['addressId']);
            $restaurant->setDescription($row['description']);
            $restaurant->setPrice($row['price']);

            $type = new RestaurantType();
            $type->setTypeId($row['typeId']);
            $type->setTypeName($row['typeName']);

            $restaurant->setTypeId($type);
            $restaurant->setRating($row['rating']);

            $restaurantEvent->setRestaurant($restaurant);

            array_push($output, $restaurantEvent);
        }

        return $output;
    }

    private function buildRestaurant($input): array
    {
        $output = array();

        foreach ($input as $row) {


            $restaurant = new Restaurant();
            $restaurant->setRestaurantId($row['restaurantId']);
            $restaurant->setRestaurantName($row['restaurantName']);
            $restaurant->setAddressId($row['addressId']);
            $restaurant->setDescription($row['description']);
            $restaurant->setPrice($row['price']);
            $restaurant->setRating($row['rating']);
            $restaurant->location = $row['name'];

            $type = new RestaurantType();
            $type->setTypeId($row['typeId']);
            $type->setTypeName($row['typeName']);

            array_push($output, $restaurant);
        }

        return $output;
    }

    public function getAllRestaurants($date = null)
    {
        try {
            $query = "Select * from restaurants join restaurantevent on restaurants.restaurantId = restaurantevent.restaurantId join events on restaurantevent.eventId = events.eventId join foodtype on restaurants.typeId = foodtype.typeId join festivaleventtypes on events.festivalEventType  = festivaleventtypes.eventTypeId";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            $result = $this->buildRestaurantEvents($stmt->fetchAll());

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getAll(){
        try {
            $query = "Select r.*, l.name as name, ft.*  from restaurants as r join foodtype as ft on r.typeId = ft.typeId join locations as l on r.addressId = l.addressId";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            $result = $this->buildRestaurant($stmt->fetchAll());

            if (is_bool($result))
                return null;
            else

                return $result;
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteRestaurant($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM restaurants WHERE restaurantId = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteRestaurantEvent($id){
        try {
            $stmt = $this->connection->prepare("DELETE FROM restaurantevent WHERE restaurantId = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }

    }

    public function deleteEvent($id){
        try {
            $stmt = $this->connection->prepare("DELETE FROM events WHERE eventId = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }

    }

    public function getEventId($id){
        try {
            $stmt = $this->connection->prepare("SELECT eventId FROM restaurantevent WHERE restaurantId = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result['eventId'];
        } catch (Exception $ex) {
            throw ($ex);
        }

    }

    public function insertRestaurant(Restaurant $restaurant): void
    {
        try {
            $query = "INSERT INTO development.restaurants
            (restaurantName, addressId, numOfSessions, durationOfSessions, description, price, AvailableSeats, typeId, rating)
             VALUES (:name, :addressId, :numOfSessions, :durationOfSessions, :description, :availableSeats, :typeId, :rating)";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":name", $restaurant->getRestaurantName());
            $stmt->bindValue(":addressId", $restaurant->getAddressId());
            $stmt->bindValue(":numOfSessions", $restaurant->getNumOfSessions());
            $stmt->bindValue(":durationOfSessions", $restaurant->getDurationOfSessions());
            $stmt->bindValue(":description", $restaurant->getDescription());
            $stmt->bindValue(":price", $restaurant->getPrice());
            $stmt->bindValue(":availableSeats", $restaurant->getAvailableSeats());
            $stmt->bindValue(":typeId", $restaurant->getTypeId());
            $stmt->bindValue(":rating", $restaurant->getRating());

            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}
