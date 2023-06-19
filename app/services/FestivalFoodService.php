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