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

class OrderRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getById($orderId) : Order{
        $sql = "select * from orders where orderId = :orderId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":orderId", $orderId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->buildOrder($result);
    }

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


        if (empty($result))
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
?>