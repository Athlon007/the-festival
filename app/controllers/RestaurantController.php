<?php
class RestaurantController
{
    public function manageRestaurants()
    {
        try{
            require_once("../services/RestaurantService.php");
            $restaurantService = new RestaurantService();
            $restaurants = $restaurantService->getAllRestaurants();
            require("../views/admin/manageRestaurants.php");
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}

?>
