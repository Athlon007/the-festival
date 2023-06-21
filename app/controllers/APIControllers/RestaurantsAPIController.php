<?php
require_once("APIController.php");
require_once __DIR__ . "/../../services/RestaurantService.php";
class RestaurantApiController
{

    private $service;

    public function __construct()
    {
        $this->service = new RestaurantService();
    }


    public function handleGetRequest()
    {
        try {
            error_reporting(E_ERROR | E_PARSE);

            $filters = isset($_GET) ? $_GET : [];
            $filters = array_map('htmlspecialchars', $filters);

            $output = $this->service->getAllRestaurants($filters);
            echo json_encode($output);
        } catch (Exception $e) {
            Logger::write($e);
            echo json_encode(["error_message" => "Unable to retrive restaurants."]);
        }
    }

    public function handleDeleteRequest()
    {
        try {
            $this->service->deleteRestaurant($_GET['id']);
            echo "Restaurant deleted successfully.";
        } catch (Exception $e) {
            Logger::write($e);
            echo json_encode(["error_message" => "Unable to delete restaurant."]);
        }
    }
}
