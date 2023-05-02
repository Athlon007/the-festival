<?php
require_once(__DIR__ . "/../repositories/Repository.php");
require_once(__DIR__ . "/../models/Order.php");
require_once(__DIR__ . "/../models/OrderItem.php");

class OrderRepository extends Repository{

    private function buildOrder($row) : Order{
        $order = new Order();
        $order->setOrderId($row['orderId']);
        $order->setOrderDate($row['orderDate']);
        $order->setOrderItems($this->getOrderItemsByOrderId($row['orderId']));
        return $order;
    }

    private function buildOrderItem($row) : OrderItem{
        $orderItem = new OrderItem();
        $orderItem->setEventName($row['name']);
        $orderItem->setTicketTypeName($row['ticketTypeName']);
        $orderItem->setBasePrice($row['basePrice']);
        $orderItem->setVatPercentage($row['vatPercentage']);
        $orderItem->setVatAmount($row['vatAmount']);
        $orderItem->setFullPrice($row['fullPrice']);
        $orderItem->setQuantity($row['quantity']);
        return $orderItem;
    }
    
    public function getById($orderId) : Order{
        $sql = "select * from orders where orderId = :orderId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":orderId", $orderId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $this->buildOrder($result);
    }

    public function getOrderItemsByOrderId($orderId) : array{
        try{
            $sql = "select e.name as eventName, ti.ticketTypeName as ticketTypeName, t.basePrice as basePrice, f.VAT as vatPercentage, t.vat as vatAmount, t.fullPrice as fullPrice, count(t.eventId) as quantity " +
            "from tickets t " +
            "join tickettypes ti on t.ticketTypeId = ti.ticketTypeId " +
            "join events e on e.eventId = t.eventId " +
            "join festivaleventtypes f on e.festivalEventType = f.eventTypeId " +
            "where t.orderId = :orderId " +
            "group by e.name, ti.ticketTypeName, e.startTime, t.basePrice, f.VAT, t.vat, t.fullPrice";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(":orderId", $orderId);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $orderItems = array();
            foreach($result as $row){
                $orderItem = $this->buildOrderItem($row);
                array_push($orderItems, $orderItem);
            }

            return $orderItems;
        }
        catch(Exception $e){
            throw new Exception("Error while getting order items: " . $e->getMessage());
        }
    }

    public function update($orderId, $order){

    }


}