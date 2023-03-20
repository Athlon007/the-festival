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
            $query = "INSERT INTO restaurants (name, addressId, numOfSessions, durationOfSessions) VALUES (:name, :addressId, :numOfSessions, :durationOfSessions)";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":name", $restaurant->getRestaurantName());
            $stmt->bindValue(":addressId", $restaurant->getAddressId());
            $stmt->bindValue(":numOfSessions", $restaurant->getNumOfSessions());
            $stmt->bindValue(":durationOfSessions", $restaurant->getDurationOfSessions());

            $stmt->execute();
        }  
        catch (Exception $ex) {
            throw ($ex);
        }
    }
    public function createNewRestaurant(string $name, int $addressId, int $numOfSessions, time $durationOfSessions): void
    {
        try {
            $restaurant = new Restaurant();
            $restaurant->setRestaurantName($name);
            $restaurant->setAddressId($addressId);
            $restaurant->setNumOfSessions($numOfSessions);
            $restaurant->setDurationOfSessions($durationOfSessions);

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