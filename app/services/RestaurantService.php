<?php

class RestaurantService{

    private RestaurantRepository $repository;


function getAllRestaurants(){
    try {
        return $this->repository->getAllRestaurants();
    } catch (Exception $ex) {
        throw ($ex);
    }
}

}

?>