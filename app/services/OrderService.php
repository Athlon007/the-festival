<?php

//Repositories
require_once(__DIR__ . '/../repositories/OrderRepository.php');
require_once(__DIR__ . '/../repositories/TicketLinkRepository.php');
require_once(__DIR__ . '/../repositories/TicketRepository.php');
require_once(__DIR__ . '/../repositories/CustomerRepository.php');

//Services
require_once(__DIR__ . '/../services/TicketService.php');
require_once(__DIR__ . '/../services/PDFService.php');

//Models
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../models/Ticket/Ticket.php');
require_once(__DIR__ . '/../models/Exceptions/OrderNotFoundException.php');

class OrderService
{
    private $orderRepository;
    private $customerRepository;
    private $ticketLinkRepository;
    private $ticketRepository;
    private $ticketService;
    private $pdfService;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->ticketLinkRepository = new TicketLinkRepository();
        $this->ticketRepository = new TicketRepository();
        $this->customerRepository = new CustomerRepository();
        $this->ticketService = new TicketService();
        $this->pdfService = new PDFService();
    }

    public function getOrderById(int $id) : Order
    {
        //Get the order object
        $order = $this->orderRepository->getOrderById($id);
        //Get the customer object attached in order
        $order->setCustomer($this->customerRepository->getById($order->getCustomer()->getUserId()));
        return $order;
    }

    public function getOrderHistory(int $customerId) : array
    {
        $orders = $this->orderRepository->getOrderHistory($customerId);
        foreach ($orders as $order) {
            $order->setCustomer($this->customerRepository->getById($order->getCustomer()->getUserId()));
        }
        return $orders;
    }

    public function getOrdersToExport()
    {
        return $this->orderRepository->getOrdersToExport();
    }

    public function downloadOrders()
    {
        $orders = $this->getOrdersToExport();

        if ($orders == null) {
            echo "No orders found";
            exit;
        }

        $fileName = "orders-data_" . date('Y-m-d') . ".xls";
        $fields = array('ID', 'ORDER DATE', 'CUSTOMER NAME', 'CUSTOMER EMAIL', 'EVENT NAME', 'PRICE', 'QUANTITY', 'TOTAL PRICE');
        $excelData = implode("\t", $fields) . "\n";

        foreach ($orders as $order) {
            foreach ($order->getOrderItems() as $orderItem) {
                $lineData = array(
                    $order->getOrderId(),
                    date_format($order->getOrderDate(), 'd/m/Y'),
                    $order->getCustomer()->getFirstName() . " " . $order->getCustomer()->getLastName(),
                    $order->getCustomer()->getEmail(),
                    $orderItem->getEventName(),
                    $orderItem->getFullPrice(),
                    $orderItem->getQuantity(),
                    $orderItem->getQuantity() * $orderItem->getFullPrice()
                );
                array_walk($lineData, array($this, 'filterData'));
                $excelData .= implode("\t", $lineData) . "\n";
            }
        }

        // Send HTTP headers
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Cache-Control: max-age=0");

        // Output the Excel data to the output buffer and exit
        echo $excelData;
        exit;
    }

    public function sendInvoice(){
        
    }


    private function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"'))
            $str = '"' . str_replace('"', '""', $str) . '"';
    }

    public function getCartOrderForCustomer($customerId)
    {
        return $this->orderRepository->getCartOrderForCustomer($customerId);
    }
    
    public function createOrder(int $ticketLinkId, int $customerId = NULL) : Order
    {
        $order = new Order();
        $order->setOrderDate(new DateTime());
        $order->setIsPaid(false);
        $order = $this->orderRepository->insertOrder($order);
        //Create and insert the first order item that will be linked to the new order.
        $this->createOrderItem($ticketLinkId, $order->getOrderId());
        return $order;
    }

    public function createOrderItem(int $ticketLinkId, int $orderId) : OrderItem
    {
        $orderItem = new OrderItem();
        $orderItem->setTicketLinkId($ticketLinkId);
        $orderItem->setQuantity(1);

        return $this->orderRepository->insertOrderItem($orderItem, $orderId);
    }

    public function updateOrder($orderId, $order) : Order
    {
        $this->orderRepository->updateOrder($orderId, $order);
    }

    public function updateOrderItem($orderItemId, $orderItem) : OrderItem
    {
        $this->orderRepository->updateOrderItem($orderItemId, $orderItem);
    }

    public function deleteOrder($orderId) : void
    {
        $this->orderRepository->deleteOrder($orderId);
    }

    public function deleteOrderItem($orderItemId) : void
    {
        $this->orderRepository->deleteOrderItem($orderItemId);
    }

    //If the customer has an unpaid order and logs in while having created another order as a visitor, merge the two orders.
    public function mergeOrders($customerOrder, $sessionOrder) : Order{

    }
}
