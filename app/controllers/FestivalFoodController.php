<?php
class FestivalFoodController
{
    public function loadFoodFestivalPage()
    {
        try {
            require_once("../services/FestivalFoodService.php");
            $festivalFoodService = new FestivalFoodService();
            $restaurants = $festivalFoodService->getAllRestaurants();
            require("../views/festival/food_festival.php");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>