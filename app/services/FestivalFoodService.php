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
}