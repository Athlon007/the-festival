<?php
require_once(__DIR__ . '/../models/Restaurant.php');
require_once(__DIR__ . '/../repositories/Repository.php');

class RestaurantRepository extends Repository
{

    public function getAllRestaurants($date = null)
    {
        try {
            if ($date) {
                //$query = "SELECT * FROM restaurants as r WHERE r.date = :date ";
                $query = "Select * from restaurants join restaurantevent on restaurants.restaurantId = restaurantevent.restaurantId join events on restaurantevent.eventId = events.eventId";
                $stmt = $this->connection->prepare($query);
                //$stmt->bindValue(':date', $date);
            } else{
                $query = "SELECT * FROM restaurants";
                $stmt = $this->connection->prepare($query);
            }
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Restaurant');

            $result = $stmt->fetchAll();

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
        }
        catch (Exception $ex) {
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
        }  
        catch (Exception $ex) {
            throw ($ex);
        }
    }


}

?>
