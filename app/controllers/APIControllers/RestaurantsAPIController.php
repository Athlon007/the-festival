<?php
require_once("APIController.php");
require_once __DIR__ . "/../../services/RestaurantService.php";
class RestaurantApiController{

    private $service;

    public function __construct()
    {
        $this->service = new RestaurantService();
    }


    public function handleGetRequest()
    {
        try {
            error_reporting(E_ERROR | E_PARSE);
            if($_GET['date']){
            $output = $this->service->getAllRestaurants(/*$_GET['date']*/);
            }else{
            $output = $this->service->getAllRestaurants();
            }
            echo json_encode($output);
        } catch (Exception $e) {
            Logger::write($e);
           echo "Unable to retrive restaurants.", 500;
        }
    }
}
?>