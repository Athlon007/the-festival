<?php
            
class FestivalFoodController
{
    public function  loadFoodFestivalPage()
    {
        try {
            //require_once("../models/Restaurant.php");
            require_once("../services/FestivalFoodService.php");
            $festivalFoodService = new FestivalFoodService();
            $restaurants = $festivalFoodService->getAllRestaurants();
            $types = $festivalFoodService->getAllTypes();
            $location = $festivalFoodService->getAllLocations();
            require_once("../views/festival/food_Festival.php");

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function addRestaurant(){

        require_once("../models/Yummy/RestaurantType.php");
        require_once("../services/FestivalFoodService.php");
        $festivalFoodService = new FestivalFoodService();
        $types = $festivalFoodService->getAllTypes();
        $locations = $festivalFoodService->getAllLocations();
        require_once("../views/admin/Restaurant management/addRestaurant.php");
    }


    public function editRestaurant(){

        require_once("../models/Yummy/Restaurant.php");
        require_once("../models/Yummy/RestaurantType.php");
        $restaurant = new Restaurant();
        $id = $_POST['id'];
        $name = $_POST['name'];
        $addressId = $_POST['location'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $rating = $_POST['rating'];
        $type_post = $_POST['type'];

        $restaurant->setRestaurantId($id);
        $restaurant->setRestaurantName($name);
        $restaurant->setAddressId($addressId);
        $restaurant->setDescription($description);
        $restaurant->setPrice($price);
        $restaurant->setRating($rating);
        $type = new RestaurantType();
        $type->setTypeId((int)$type_post);
        $type->setTypeName("fish and chips");
        $restaurant->setTypeId($type);

        require_once("../services/FestivalFoodService.php");
        $festivalFoodService = new FestivalFoodService();
        $festivalFoodService->updateRestaurant($restaurant);

        header("Location: /manageRestaurants");

    }

    public function editSession(){
            
            require_once("../models/Yummy/RestaurantEvent.php");
            $restaurantEvent = new RestaurantEvent();
            $id = $_POST['eventId'];
            $name = $_POST['eventName'];
            $startTime = $_POST['startTime'];
            $endTime = $_POST['endTime'];
            $availableTickets = $_POST['availableTickets'];

            $startTime = DateTime::createFromFormat('Y-m-d\TH:i', $startTime);
            $endTime = DateTime::createFromFormat('Y-m-d\TH:i', $endTime);

            $restaurantEvent->setId($id);
            $restaurantEvent->setName($name);
            $restaurantEvent->setStartTime($startTime);
            $restaurantEvent->setEndTime($endTime);
            $restaurantEvent->setAvailableTickets($availableTickets);

    
            require_once("../services/FestivalFoodService.php");
            $festivalFoodService = new FestivalFoodService();
            $festivalFoodService->updateSession($restaurantEvent);
    
            header("Location: /updateSession?id=" . $id);
    
    }
    public function updateRestaurant($id){
            
            require_once("../services/FestivalFoodService.php");
            $festivalFoodService = new FestivalFoodService();
            $restaurant = $festivalFoodService->getRestaurantById($id);
            require_once("../views/admin/Restaurant management/updateRestaurant.php");
    }

    public function updateSession($id){
        require_once("../services/FestivalFoodService.php");
        $festivalFoodService = new FestivalFoodService();
        $event = $festivalFoodService->getSessionById($id);
        require_once("../views/admin/Restaurant management/updateSession.php");
    }

    public function addSession($id){
        require_once("../services/FestivalFoodService.php");
        $festivalFoodService = new FestivalFoodService();
        $restaurant = $festivalFoodService->getRestaurantById($id);
        require_once("../views/admin/Restaurant management/addSession.php");
    }

    public function insertRestaurant(){

        require_once("../models/Yummy/Restaurant.php");
        require_once("../models/Yummy/RestaurantType.php");
        $restaurant = new Restaurant();
        $name = $_POST['restaurant_name'];
        $addressId = $_POST['location'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $rating = $_POST['rating'];
        $type_post = $_POST['type'];

        $restaurant->setRestaurantName($name);
        $restaurant->setAddressId($addressId);
        $restaurant->setDescription($description);
        $restaurant->setPrice($price);
        $restaurant->setRating($rating);
        $type = new RestaurantType();
        $type->setTypeId((int)$type_post);
        $type->setTypeName("fish and chips");
        $restaurant->setTypeId($type);

        require_once("../services/FestivalFoodService.php");
        $festivalFoodService = new FestivalFoodService();
        $festivalFoodService->insertRestaurant($restaurant);

        header("Location: /manageRestaurants");
    }
    public function insertSession($restaurantId){
        require_once("../models/Yummy/RestaurantEvent.php");
        $session = new RestaurantEvent();

        $name = $_POST['name'];
        $availableSeats = $_POST['availableTickets'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $startTime = DateTime::createFromFormat('Y-m-d\TH:i', $startTime);
        $endTime = DateTime::createFromFormat('Y-m-d\TH:i', $endTime);

        $session->setName($name);
        $session->setAvailableTickets($availableSeats);
        $session->setStartTime($startTime);
        $session->setEndTime($endTime);

        require_once("../services/FestivalFoodService.php");
        $festivalFoodService = new FestivalFoodService();
        $festivalFoodService->insertSession($session, $restaurantId);

        header("Location: /manageSessions?restaurantId=$restaurantId");

        
    }
}
?>