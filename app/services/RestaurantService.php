<?php
require_once __DIR__ . '/../repositories/RestaurantRepository.php';
require_once __DIR__ . '/../models/Yummy/Restaurant.php';
require_once __DIR__ . '/../models/Yummy/RestaurantEvent.php';

class RestaurantService
{

    protected RestaurantRepository $repository;

    public function __construct()
    {
        $this->repository = new RestaurantRepository();
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
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    function getAllRestaurants(/*$date = null*/): array
    {
        try {
            return $this->repository->getAllRestaurants(/*$date*/);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
    function deleteRestaurant($id): void
    {
        try {
            $this->repository->deleteRestaurant($id);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}
