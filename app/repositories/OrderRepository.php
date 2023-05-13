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

    public function getOrderById($orderId) : Order{
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

    private function getOrderItemById($orderItemId) : OrderItem{
        $sql = "select o.orderItemId, tl.ticketLinkId, e.name as eventName, tt.ticketTypeName as ticketName, e.startTime, tt.ticketTypePrice as fullTicketPrice, f.VAT, o.quantity 
                from orderitems o 
                join ticketlinks tl on tl.ticketLinkId = o.ticketLinkId 
                join tickettypes tt on tt.ticketTypeId = tl.ticketTypeId 
                join events e on e.eventId = tl.eventId 
                join festivaleventtypes f on f.eventTypeId = e.festivalEventType 
                where o.orderItemId = :orderItemId";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":orderItemId", htmlspecialchars($orderItemId));
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->buildOrderItem($result);
    }

    public function getAllOrders($limit = null, $offset = null, $isPaid = null){
        try{
            $sql = "SELECT * FROM orders";
            
            if($isPaid != null){
                $sql .= " WHERE isPaid = :isPaid";
            }
            if($limit != null){
                $sql .= " LIMIT :limit";
            }
            if($offset != null){
                $sql .= " OFFSET :offset";
            }

            $stmt = $this->connection->prepare($sql);

            if($isPaid != null){
                $stmt->bindValue(":isPaid", htmlspecialchars($isPaid));
            }
            if($limit != null){
                $stmt->bindValue(":limit", htmlspecialchars($limit), PDO::PARAM_INT);
            }
            if($offset != null){
                $stmt->bindValue(":offset", htmlspecialchars($offset), PDO::PARAM_INT);
            }
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $orders = array();

            foreach($result as $row){
                $order = $this->buildOrder($row);
                $order->setOrderItems($this->getOrderItemsByOrderId($order->getOrderId()));
                array_push($orders, $order);
            }

            return $orders;
        }
        catch(Exception $ex){
            throw $ex;
        }   
    }

    public function getOrderItemsByOrderId($orderId) : array{
        try{
            $sql = "select o.orderItemId, tl.ticketLinkId, e.name as eventName, tt.ticketTypeName as ticketName, e.startTime, tt.ticketTypePrice as fullTicketPrice, f.VAT, o.quantity 
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
            foreach ($result as $row) {
                $orderItem = $this->buildOrderItem($row);
                array_push($orderItems, $orderItem);
            }

            return $orderItems;
        }
        catch(Exception $ex){
            throw new Exception("Error while getting order items: " . $ex->getMessage());
        }
    }

    public function getCartOrderForCustomer(int $customerId) : ?Order{
        $sql = "SELECT * FROM orders WHERE customerId = :customerId AND isPaid = 0";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":customerId", htmlspecialchars($customerId));
        $stmt->execute();
    }

    public function getOrdersToExport()
    {
        $sql = "select o.orderId, o.orderDate, u.firstName , u.lastName , u.email , e.name, t.ticketId, o.customerId from orders o
        join users u on u.userId = o.customerId
        join tickets t on t.orderId = t.ticketId 
        join events e on t.eventId = e.eventId";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];
        foreach ($result as $row) {
            $order = new Order();
            $order->setOrderId($row['orderId']);
            $order->setOrderDate(DateTime::createFromFormat('Y-m-d H:i:s', $row['orderDate']));
            $orderItems = $this->getOrderItemsByOrderId($row['orderId']);
            $order->setOrderItems($orderItems);

            $userRep = new UserRepository();
            $customerRep = new CustomerRepository();
            $user = $userRep->getById($row['customerId']);
            $customer = $customerRep->getByUser($user);
            $order->setCustomer($customer);

            array_push($orders, $order);
        }
        return $orders;
    }

    public function getOrderForInvoice($orderId)
    {
        $sql = "select o.orderDate, u.firstName , u.lastName , u.email , e.name, t.ticketId, o.customerId from orders o
        join users u on u.userId = o.customerId
        join tickets t on t.orderId = t.ticketId 
        join events e on t.eventId = e.eventId
        where o.orderId = :orderId ";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":orderId", $orderId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $order = new Order();
        $order->setOrderId($orderId);
        $order->setOrderDate(DateTime::createFromFormat('Y-m-d H:i:s', $result['orderDate']));
        $orderItems = $this->getOrderItemsByOrderId($orderId);
        $order->setOrderItems($orderItems);

        $customerRep = new CustomerRepository();
        $customer = $customerRep->getById($result['customerId']);
        $order->setCustomer($customer);

        return $order;
    }

    public function update($orderId, $order)
    {

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

    public function updateOrder($orderId, $order) : Order{
        $sql = "UPDATE orders SET orderDate = :orderDate, customerId = :customerId, isPaid = :isPaid WHERE orderId = :orderId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":orderDate", htmlspecialchars($order->getOrderDate()));
        $stmt->bindValue(":customerId", htmlspecialchars($order->getCustomer()->getCustomerId()));
        $stmt->bindValue(":isPaid", htmlspecialchars($order->getIsPaid()));
        $stmt->bindValue(":orderId", htmlspecialchars($orderId));
        
        $stmt->execute();
        return $this->getOrderById($orderId);
    }

    public function updateOrderItem($orderItemId, $orderItem) : OrderItem{
        $sql = "UPDATE orderitems SET ticketLinkId = :ticketLinkId, orderId = :orderId, quantity = :quantity WHERE orderItemId = :orderItemId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":ticketLinkId", htmlspecialchars($orderItem->getTicketLinkId()));
        $stmt->bindValue(":orderId", htmlspecialchars($orderItemId));
        $stmt->bindValue(":quantity", htmlspecialchars($orderItem->getQuantity()));

        $stmt->execute();
        return $this->getOrderItemById($orderItemId);

    }

    //Insert a new order into the database
    public function insertOrder($order) : Order{
        try{
            $sql = "INSERT INTO orders (orderDate, customerId, isPaid) VALUES (:orderDate, :customerId, 0)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(":orderDate", htmlspecialchars($order->getOrderDate()));
            $stmt->bindValue(":customerId", htmlspecialchars($order->getCustomer()->getCustomerId()));
            $stmt->execute();

            return $this->getOrderById($this->connection->lastInsertId());
        }
        catch(Exception $ex){

        }
    }

    public function insertOrderItem($orderItem, $orderId) : OrderItem{
        $sql = "INSERT INTO orderitems (ticketLinkId, orderId, quantity) VALUES (:ticketLinkId, :orderId, :quantity)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":ticketLinkId", htmlspecialchars($orderItem->getTicketLinkId()));
        $stmt->bindValue(":orderId", htmlspecialchars($orderId));
        $stmt->bindValue(":quantity", htmlspecialchars($orderItem->getQuantity()));
        $stmt->execute();

        return $this->getOrderItemById($this->connection->lastInsertId());
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