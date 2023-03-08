<?php
require_once __DIR__ . '/../repositories/RestaurantRepository.php';
require_once __DIR__ . '/../models/Restaurant.php';

class RestaurantService{

    private RestaurantRepository $repository;


function getAllRestaurants(){
    try {
        $this->repository = new RestaurantRepository();
        //return $this->repository->getAllRestaurants();
    } catch (Exception $ex) {
        throw ($ex);
    }
}

}

?>