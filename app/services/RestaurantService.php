<?php
require_once __DIR__ . '/../repositories/RestaurantRepository.php';
require_once __DIR__ . '/../models/Restaurant.php';

class RestaurantService{

    protected RestaurantRepository $repository;

    public function __construct()
    {
        $this->repository = new RestaurantRepository();
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
    public function createNewRestaurant(string $name, int $addressId, int $numOfSessions, string $durationOfSessions, string $description, int $price, $availableSeats, int $typeId, string $rating): void
    {
        try {
            $restaurant = new Restaurant();
            $restaurant->setRestaurantName($name);
            $restaurant->setAddressId($addressId);
            $restaurant->setNumOfSessions($numOfSessions);
            $restaurant->setDurationOfSessions($durationOfSessions);
            $restaurant->setDescription($description);
            $restaurant->setPrice($price);
            $restaurant->setAvailableSeats($availableSeats);
            $restaurant->setTypeId($typeId);
            $restaurant->setRating($rating);

            $this->repository->insertRestaurant($restaurant);
        } 
        catch (Exception $ex) {
            throw ($ex);
        }
    }

function getAllRestaurants(): array{
    try {
        return $this->repository->getAllRestaurants();
    } catch (Exception $ex) {
        throw ($ex);
    }
}
function deleteRestaurant($id): void{
    try {
        $this->repository->deleteRestaurant($id);
    } catch (Exception $ex) {
        throw ($ex);
    }
}

}

?>