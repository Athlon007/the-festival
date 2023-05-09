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
require_once(__DIR__ . '/../models/TicketLink.php');
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
        $order = $this->orderRepository->getById($id);
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

    public function getCartOrder(int $customerId) : Order
    {
        return $this->orderRepository->getCartOrder($customerId);
    }
    
    public function createOrder(int $ticketLinkId, int $customerId = NULL) : Order
    {
        $order = new Order();
        $order->setOrderDate(new DateTime());
        $order->setIsPaid(false);

        $firstOrderItem = new OrderItem();
        $firstOrderItem->setTicketLinkId($ticketLinkId);

        $this->orderRepository->insertOrder($order);
    }

    public function createOrderItem(int $orderId, int $ticketLinkId) : OrderItem
    {
        $orderItem = new OrderItem();
        $orderItem->setTicketLinkId($ticketLinkId);
        $orderItem->setQuantity(1);

        $this->orderRepository->insertOrderItem($orderItem, $orderId);
    }

    public function sendInvoiceAndTicketsByEmail($order)
    {
        //Generate and email the tickets
        foreach ($order->getTickets() as $ticket) {
            //Generate a PDF for the ticket and send it by email.
            $qrCode = $this->ticketService->generateQRCode($ticket);
            $dompdf = $this->ticketService->generatePDFTicket($ticket, $qrCode, $order);
            $this->ticketService->sendTicketByEmail($dompdf, $ticket, $order);
        }
        
        //Generate and email the invoice
    }

    //If the customer has an unpaid order and logs in while having created another order as a visitor, merge the two orders.
    public function mergeOrders($order1, $order2){

    }
}
