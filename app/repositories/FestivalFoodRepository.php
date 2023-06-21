<?php

require_once("Repository.php");

class FestivalFoodRepository extends Repository
{

    public function insertRestaurant($restaurant)
    {
        try {
            $query = "INSERT INTO restaurants (restaurantName, addressId, description, price, rating, typeId) VALUES (:restaurantName, :addressId, :description, :price, :rating, :typeId)";
            $stmt = $this->connection->prepare($query);

            $name = $restaurant->getRestaurantName();
            $addressId = $restaurant->getAddressId();
            $description = $restaurant->getDescription();
            $price = $restaurant->getPrice();
            $rating = $restaurant->getRating();
            $type = $restaurant->getTypeId();
            $type_id = $type->getTypeId($type);

            $stmt->bindParam(":restaurantName", $name);
            $stmt->bindParam(":addressId", $addressId);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":rating", $rating);
            $stmt->bindParam(":typeId", $type_id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteLink($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM restaurantevent WHERE eventId = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteSession($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM events WHERE eventId = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function insertLink($restaurantId, $eventId)
    {
        try {
            $query = "INSERT INTO restaurantevent (restaurantId, eventId) VALUES (:restaurantId, :eventId)";
            $stmt = $this->connection->prepare($query);

            $stmt->bindParam(":restaurantId", $restaurantId);
            $stmt->bindParam(":eventId", $eventId);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
    public function insertSession($session)
    {
        try {
            $query = "INSERT INTO events (name, startTime, endTime, festivalEventType, availableTickets) VALUES (:name, :startTime, :endTime, 2, :availableTickets)";
            $stmt = $this->connection->prepare($query);

            $name = $session->getName();
            $startTime = $session->getStartTime();
            $endTime = $session->getEndTime();
            $availableTickets = $session->getAvailableTickets();

            $startTime = $startTime->format('Y-m-d H:i:s');
            $endTime = $endTime->format('Y-m-d H:i:s');

            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":startTime", $startTime);
            $stmt->bindValue(":endTime", $endTime);
            $stmt->bindValue(":availableTickets", $availableTickets);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }


    public function getAllRestaurants()
    {
        try {
            $query = "select * from restaurants join restaurantevent on restaurants.restaurantId = restaurantevent.restaurantId join events on restaurantevent.eventId = events.eventId  ; ";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'FestivalFood');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }

    }
    public function getAllTypes()
    {
        try {
            $query = "SELECT * FROM foodtype ";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'FestivalFood');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
    public function getAllLocations()
    {
        try {
            $query = "SELECT locationId, name, addressId, locationType, capacity, lon, lat, description
            FROM development.locations
            WHERE locationType=2;
        ";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestarantEvents($id)
    {
        try {
            $query = "SELECT *
            FROM development.events join restaurantevent on events.eventId=restaurantevent.eventId
            where restaurantevent.restaurantId = :id;";
            //$query = "SELECT * FROM events WHERE festivalEventType = 2";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestaurantById($id)
    {
        try {
            $query = "SELECT * FROM restaurants WHERE restaurantId = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $result = $stmt->fetch();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
    public function getSessionById($id){
        try {
            $query = "SELECT * FROM events WHERE eventId = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $result = $stmt->fetch();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updateRestaurant($restaurant)
    {
        try {
            $query = "UPDATE restaurants SET restaurantName = :restaurantName, addressId = :addressId, description = :description, price = :price, rating = :rating, typeId = :typeId WHERE restaurantId = :restaurantId";
            $stmt = $this->connection->prepare($query);

            $name = $restaurant->getRestaurantName();
            $addressId = $restaurant->getAddressId();
            $description = $restaurant->getDescription();
            $price = $restaurant->getPrice();
            $rating = $restaurant->getRating();
            $type = $restaurant->getTypeId();
            $type_id = $type->getTypeId($type);
            $id = $restaurant->getRestaurantId();

            $stmt->bindParam(":restaurantName", $name);
            $stmt->bindParam(":addressId", $addressId);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":rating", $rating);
            $stmt->bindParam(":typeId", $type_id);
            $stmt->bindParam(":restaurantId", $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updateSession($session){
        try {
            $query = "UPDATE events SET name = :name, startTime = :startTime, endTime = :endTime, availableTickets = :availableTickets WHERE eventId = :eventId";
            $stmt = $this->connection->prepare($query);

            $name = $session->getName();
            $startTime = $session->getStartTime();
            $endTime = $session->getEndTime();
            $availableTickets = $session->getAvailableTickets();
            $id = $session->getId();

            $startTime = $startTime->format('Y-m-d H:i:s');
            $endTime = $endTime->format('Y-m-d H:i:s');

            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":startTime", $startTime);
            $stmt->bindParam(":endTime", $endTime);
            $stmt->bindParam(":availableTickets", $availableTickets);
            $stmt->bindParam(":eventId", $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestaurantByType($type)
    {
        try {
            $query = "SELECT * FROM restaurants WHERE type = :type";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":type", $type);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'FestivalFood');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestaurantByRating($rating)
    {
        try {
            $query = "SELECT * FROM restaurants WHERE rating = :rating";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":rating", $rating);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'FestivalFood');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestaurantByPrice($price)
    {
        try {
            $query = "SELECT * FROM restaurants WHERE price = :price";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":price", $price);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'FestivalFood');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }



}