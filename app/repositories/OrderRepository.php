<?php
require_once(__DIR__ . "/../repositories/Repository.php");
require_once(__DIR__ . "/../models/Exceptions/OrderNotFoundException.php");
require_once(__DIR__ . "/../models/Order.php");
require_once(__DIR__ . "/../models/Ticket/Ticket.php");
require_once(__DIR__ . "/../models/Event.php");
require_once(__DIR__ . "/../models/Address.php");
require_once(__DIR__ . "/../models/Customer.php");
require_once(__DIR__ . "/UserRepository.php");
require_once(__DIR__ . "/CustomerRepository.php");
require_once(__DIR__ . "/TicketLinkRepository.php");

/**
 * Repository for orders and orderitems
 * @author Joshua
 */
class OrderRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getById($orderId) : Order{
        try{
            $sql = "SELECT * FROM orders WHERE orderId = :orderId";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(":orderId", htmlspecialchars($orderId));
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $order = $this->buildOrder($result);
            $order->setOrderItems($this->getOrderItemsByOrderId($orderId));

            return $order;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    public function getAll(){

    }

    public function getCartOrder(int $customerId) : ?Order{
        $sql = "SELECT * FROM orders WHERE customerId = :customerId AND isPaid = 0";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":customerId", htmlspecialchars($customerId));
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result)
            return null;

        $order = $this->buildOrder($result);
        $order->setOrderItems($this->getOrderItemsByOrderId($order->getOrderId()));

        return $order;
    }

    

    public function getOrderHistory($customerId): array
    {
        $sql = "SELECT * FROM orders WHERE customerId = :customerId AND isPaid = 1";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":customerId", $customerId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$result)
            throw new OrderNotFoundException();

        $orders = array();
        foreach ($result as $row) {
            $order = $this->buildOrder($row);
            $order->setOrderItems($this->getOrderItemsByOrderId($order->getOrderId()));
            array_push($orders, $order);
        }

        return $orders;
    }

    public function getOrderItemsByOrderId($orderId) : array{
        try{
            $sql = "select o.orderItemId, tl.ticketLinkId, e.name as eventName, tt.ticketTypeName as ticketName, e.startTime, tt.ticketTypePrice, f.VAT, o.quantity 
                    from orderitems o
                    join ticketlinks tl on tl.ticketLinkId = o.ticketLinkId 
                    join tickettypes tt on tt.ticketTypeId = tl.ticketTypeId
                    join events e on e.eventId = tl.eventId
                    join festivaleventtypes f on f.eventTypeId = e.festivalEventType
                    where o.orderId = :orderId";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(":orderId", htmlspecialchars($orderId));
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //Build order item array
            $orderItems = array();
            foreach($result as $row){
                $orderItem = $this->buildOrderItem($row);
                array_push($orderItems, $orderItem);
            }

            return $orderItems;
        }
        catch(Exception $ex){
            throw new Exception("Error while getting order items: " . $ex->getMessage());
        }
    }

    public function updateOrder($orderId, $order){
        
    }

    public function updateOrderItem($orderItemId, $orderItem){

    }

    //Insert a new order into the database
    public function insertOrder($order){
        try{
            $sql = "INSERT INTO orders (orderDate, customerId, isPaid) VALUES (:orderDate, :customerId, 0)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(":orderDate", htmlspecialchars($order->getOrderDate()));
            $stmt->bindValue(":customerId", htmlspecialchars($order->getCustomer()->getCustomerId()));
            $stmt->execute();
        }
        catch(Exception $ex){

        }
    }

    public function insertOrderItem($orderItem, $orderId){
        $sql = "INSERT INTO orderitems (ticketLinkId, orderId, quantity) VALUES (:ticketLinkId, :orderId, :quantity)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":ticketLinkId", htmlspecialchars($orderItem->getTicketLinkId()));
        $stmt->bindValue(":orderId", htmlspecialchars($orderId));
        $stmt->bindValue(":quantity", htmlspecialchars($orderItem->getQuantity()));
        $stmt->execute();
    }

    //This method is used to remove orders that were never linked to an account and that are 7 days old.
    private function cleanseOldOrders(){
        try{
            $sql = "DELETE FROM orders WHERE customerId IS NULL AND orderDate < DATE_SUB(NOW(), INTERVAL 7 DAYS)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
        catch(Exception $ex){

        }
    }

    private function buildOrder($row) : Order{
        $order = new Order();
        $order->setOrderId($row['orderId']);
        $order->setOrderDate($row['orderDate']);
        $order->getCustomer()->setUserId($row['customerId']);
        $order->setIsPaid($row['isPaid']);

        return $order;
    }

    private function buildOrderItem($row) : OrderItem{
        $orderItem = new OrderItem();
        $orderItem->setOrderItemId($row['orderItemId']);
        $orderItem->setTicketLinkId($row['ticketLinkId']);
        $orderItem->setEventName($row['eventName']);
        $orderItem->setTicketName($row['ticketName']);
        $orderItem->setVatPercentage($row['VAT']);
        $orderItem->setFullTicketPrice($row['fullTicketPrice']);
        $orderItem->setQuantity($row['quantity']);

        return $orderItem;
    }
}
?>