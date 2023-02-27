<?php
require_once(__DIR__ . '/../models/Restaurant.php');
require_once(__DIR__ . '/../repositories/Repository.php');

class RestaurantRepository extends Repository
{

    public function getAllRestaurants()
    {
        try {
            $query = "...";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Restaurant');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }



}

?>
