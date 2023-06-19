<?php

class FestivalFoodRepository extends Repository
{


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
        } 
        catch (Exception $ex) {
            throw ($ex);
        }

    }
    public function getAllTypes(){
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
        } 
        catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestaurantById($id){
        try {
            $query = "SELECT * FROM restaurants WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'FestivalFood');

            $result = $stmt->fetch();

            if (is_bool($result))
                return null;
            else
                return $result;
        } 
        catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestaurantByType($type){
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
        } 
        catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestaurantByRating($rating){
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
        } 
        catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getRestaurantByPrice($price){
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
        } 
        catch (Exception $ex) {
            throw ($ex);
        }
    }



}