<?php

class FestivalFoodService
{
    public function getAllRestaurants()
    {
        try{
            require_once("../repositories/FestivalFoodRepository.php");
            $festivalFoodRepository = new FestivalFoodRepository();
            $restaurants = $festivalFoodRepository->getAllRestaurants();

            return $historyEvents;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}