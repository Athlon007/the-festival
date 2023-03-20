<?php
class FestivalFoodController
{
    public function loadFoodFestivalPage()
    {
        try {
            $festivalFoodService = new FestivalFoodService();
            $restaurants = $festivalFoodService->getAllRestaurants();
            require("../views/festival/food_festival.php");
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>