<?php

class FestivalFoodRepository extends Repository
{


    public function getAllRestaurants()
    {
        try {
            $query = "SELECT * FROM restaurants ";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'FestivalFood');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } 
        catch (Exception $ex) {
            throw ($ex);
        }

    }
    public function getAllTypes(){
        try {
            $query = "SELECT * FROM foodtype ";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            //$stmt->setFetchMode(PDO::FETCH_CLASS, 'FestivalFood');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } 
        catch (Exception $ex) {
            throw ($ex);
        }
    }



}