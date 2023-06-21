<?php

class FestivalFoodService
{
    public function getAllRestaurants()
    {
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $restaurants = $festivalFoodRepository->getAllRestaurants();

            return $restaurants;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function deleteSession($id){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $festivalFoodRepository->deleteSession($id);
            $festivalFoodRepository->deleteLink($id);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getRestarantEvents($id){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $events = $festivalFoodRepository->getRestarantEvents($id);
            
            return $events;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function insertSession($session, $restaurantId){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $eventId = $festivalFoodRepository->insertSession($session);
            $festivalFoodRepository->insertLink($restaurantId, $eventId);
            $festivalFoodRepository->insertTicketLink($eventId);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllTypes()
    {
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $types = $festivalFoodRepository->getAllTypes();

            return $types;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllLocations(){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $locations = $festivalFoodRepository->getAllLocations();

            return $locations;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertRestaurant($restaurant){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $festivalFoodRepository->insertRestaurant($restaurant);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getRestaurantById($id){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $restaurant = $festivalFoodRepository->getRestaurantById($id);

            return $restaurant;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getSessionById($id){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $event = $festivalFoodRepository->getSessionById($id);

            return $event;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function updateRestaurant($restaurant){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $festivalFoodRepository->updateRestaurant($restaurant);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateSession($session){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $festivalFoodRepository->updateSession($session);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getRestaurantByType($type){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $restaurant = $festivalFoodRepository->getRestaurantByType($type);

            return $restaurant;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getRestaurantByRating($rating){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $restaurant = $festivalFoodRepository->getRestaurantByRating($rating);

            return $restaurant;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getRestaurantByPrice($price){
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $restaurant = $festivalFoodRepository->getRestaurantByPrice($price);

            return $restaurant;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}