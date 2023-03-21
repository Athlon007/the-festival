<?php
class OrderRepository extends Repository{

    public function getOrderById($id) : Order
    {
       try {
            $order = $this->db->query("SELECT * FROM orders WHERE id = :id", ['id' => $id]);
            return $order;
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