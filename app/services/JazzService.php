<?php
//require_once __DIR__ . '/../repositories/JazzRepository.php';

class JazzService{

    private JazzRepository $repository;


function getAllJazz(){
    try {
        //$this->repository = new JazzRepository();
        //return $this->repository->getAllRestaurants();
    } catch (Exception $ex) {
        throw ($ex);
    }
}

}

?>