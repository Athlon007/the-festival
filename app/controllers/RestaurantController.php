<?php
class RestaurantController
{
    public function manageRestaurants()
    {
        try{
            require_once("../services/RestaurantService.php");
            $restaurantService = new RestaurantService();
            $restaurants = $restaurantService->getAll();
            require_once("../views/admin/Restaurant management/manageRestaurants.php");
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }

}

?>
