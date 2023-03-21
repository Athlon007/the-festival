<?php
require_once(__DIR__ . "/../repositories/Repository.php");

class OrderRepository extends Repository{

    private function buildOrder($result){
        $result 

    }

    public function getOrderById($id) : Order
    {
       try {
            $query ="SELECT * FROM orders WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result)
                throw new OrderNotFoundException();
            else
                uildOrder($result);
        } catch (Exception $e) {
            throw new Exception("Order not found");
        }
    }

    public function getOrderHistory($customerId) : ?array
    {
        
    }

    public function getUnpaidOrder($customerId) : ?Order
    {
        
    }
}
?>