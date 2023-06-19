<?php
class FestivalFoodController
{
    public function  loadFoodFestivalPage()
    {
        try {
            require_once("../models/Restaurant.php");
            require_once("../services/FestivalFoodService.php");
            $festivalFoodService = new FestivalFoodService();
            $restaurants = $festivalFoodService->getAllRestaurants();
            $types = $festivalFoodService->getAllTypes();
            require_once("../views/festival/food_Festival.php");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function addRestaurant(){

    }
    public function addSession(){

    }
}
?>