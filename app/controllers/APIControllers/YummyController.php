<?php
class FoodFestivalController extends APIController{

    public function handleGetRequest($uri)
    {
            switch($uri){
            case "/api/foodfestival":
                $this->loadPage();
                break;
            case "/api/foodfestival/restaurants":
                $this->getAllRestaurants();
                break;
            case "/api/foodfestival/types":
                $this->getAllTypes();
                break;
            case "/api/foodfestival/restaurant/{id}":
                $id = explode("/", $uri)[3];
                $this->getRestaurantById($id);
                break;
            case "/api/foodfestival/type/{type}":
                $type = explode("/", $uri)[3];
                $this->getRestaurantByType($type);
                break;
            case "/api/foodfestival/rating/{rating}":
                $rating = explode("/", $uri)[3];
                $this->getRestaurantByRating($rating);
                break;
            case "/api/foodfestival/price/{price}":
                $price = explode("/", $uri)[3];
                $this->getRestaurantByPrice($price);
                break;
            default:
                $this->notFound();
                break;
            }
    }
    public function loadPage()
    {
        try {
            $festivalFoodService = new FestivalFoodService();
            $restaurants = $festivalFoodService->getAllRestaurants();
            $types = $festivalFoodService->getAllTypes();
            $location = $festivalFoodService->getAllLocations();
            require_once("../views/festival/food_Festival.php");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllRestaurants()
    {
        try{
            $festivalFoodService = new FestivalFoodService();
            $restaurants = $festivalFoodService->getAllRestaurants();
            return $restaurants;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllTypes()
    {
        try{
            $festivalFoodService = new FestivalFoodService();
            $types = $festivalFoodService->getAllTypes();
            return $types;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getAllLocations()
    {
        try{
            $festivalFoodService = new FestivalFoodService();
            $location = $festivalFoodService->getAllLocations();
            return $location;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getRestaurantById($id)
    {
        try{
            $festivalFoodService = new FestivalFoodService();
            $restaurant = $festivalFoodService->getRestaurantById($id);
            return $restaurant;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getRestaurantByType($type)
    {
        try{
            $festivalFoodService = new FestivalFoodService();
            $restaurant = $festivalFoodService->getRestaurantByType($type);
            return $restaurant;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getRestaurantByRating($rating)
    {
        try{
            $festivalFoodService = new FestivalFoodService();
            $restaurant = $festivalFoodService->getRestaurantByRating($rating);
            return $restaurant;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getRestaurantByPrice($price)
    {
        try{
            $festivalFoodService = new FestivalFoodService();
            $restaurant = $festivalFoodService->getRestaurantByPrice($price);
            return $restaurant;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>