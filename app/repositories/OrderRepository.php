<?php
require_once(__DIR__ . "/../repositories/Repository.php");
require_once(__DIR__ . "/../models/Exceptions/OrderNotFoundException.php");
require_once(__DIR__ . "/../models/Order.php");
require_once(__DIR__ . "/../models/Ticket/Ticket.php");
require_once(__DIR__ . "/../models/Event.php");
require_once(__DIR__ . "/../models/Address.php");
require_once(__DIR__ . "/../models/Customer.php");
require_once(__DIR__ . "/TicketRepository.php");
require_once(__DIR__ . "/UserRepository.php");
require_once(__DIR__ . "/CustomerRepository.php");


class OrderRepository extends Repository
{
    private TicketRepository $ticketRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->ticketRepository = new TicketRepository();
        $this->userRepository = new UserRepository();
    }

    private function buildOrder($result)
    {

    }

    public function getOrderById($orderId)
    {
        $sql = "select o.orderId, o.orderDate, o.totalFullPrice, o.customerId, t.ticketId  from orders o
        join tickets t on o.orderId  = t.orderId 
        WHERE orderId = :orderId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":orderId", $orderId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result))
            throw new OrderNotFoundException();

        $order = new Order();
        $order->setOrderId($result['orderId']);
        $order->setOrderDate($result['orderDate']);
        $order->setTotalFullPrice($result['totalFullPrice']);

        $customer = $this->userRepository->getById($result['customerId']);
        $order->setCustomer($customer);

        $tickets = [];

        foreach ($result as $row) {
            $ticket = $this->ticketRepository->getTicketById($row['ticketId']);
            $tickets[] = $ticket;
            $order->setTickets($tickets);
        }

        return $order;
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
            //set order date as date object not as a string
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

// public function getUnpaidOrder($customerId): Order
// {
//     try {

//     } catch (OrderNotFoundException $e) {

//     } catch (Exception $e) {

//     }
// }
}
?>