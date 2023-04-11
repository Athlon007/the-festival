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
}