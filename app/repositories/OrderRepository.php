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
        }
        catch(Exception $ex){
            throw $ex;
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

    public function getOrderHistory($customerId): array
    {
        $sql = "SELECT o.orderId, o.orderDate, e.name AS eventName, t.ticketId, t.basePrice, t.vat, o.totalFullPrice, o.customerId
        FROM orders o
        JOIN tickets t ON t.orderId = o.orderId
        JOIN events e ON t.eventId = e.eventId
        WHERE o.customerId = :customerId
        ORDER BY o.orderId, t.ticketId";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":customerId", $customerId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if (!$result)
            throw new OrderNotFoundException();

        $orders = [];
        $tickets = [];
        foreach ($result as $row) {
            $order = new Order();
            $order->setOrderId($row['orderId']);
            //Set order date as date object not as a string
            $order->setOrderDate(DateTime::createFromFormat('Y-m-d H:i:s', $row['orderDate']));
            $order->setTotalFullPrice($row['totalFullPrice']);

            $ticketRep = new TicketRepository();
            $ticket = $ticketRep->getTicketById($row['ticketId']);
            $ticket->setBasePrice($row['basePrice']);
            $ticket->setVat($row['vat']);

            $userRep = new UserRepository();
            $customerRep = new CustomerRepository();
            $user = $userRep->getById($row['customerId']);
            $customer = $customerRep->getCustomerByUser($user);
            $order->setCustomer($customer);

            array_push($tickets, $ticket);

            $order->setTickets($tickets);
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

    public function update($orderId, $order){
        try{
            
        }
        catch(Exception $ex){

        }
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

    }

    //This method is used to remove old orders that were never linked to an account.
    private function cleanseOrders(){

    }
}
?>