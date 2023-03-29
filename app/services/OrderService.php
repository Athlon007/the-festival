<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../repositories/OrderRepository.php');
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../models/Exceptions/OrderNotFoundException.php');
require_once(__DIR__ . '/../repositories/CartItemRepository.php');

class OrderService{
    private $orderRepository;
    private $cartItemService;
    private $ticketService;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->cartItemService = new CartItemService();
        $this->ticketService = new TicketService();
    }

    public function getOrderById($id)
    {
        return $this->orderRepository->getOrderById($id);
    }

    public function getOrderHistory($customerId)
    {
        return $this->orderRepository->getOrderHistory($customerId);
    }

    public function getUnpaidOrder($customerId)
    {
        return $this->orderRepository->getUnpaidOrder($customerId);
    }

    public function createOrder($customer, $cartItemIds)
    {
        $order = new Order();
        $order->setCustomer($customer);
        foreach($cartItemIds as $cartItemId){
            $cartItem = $this->cartItemService->getById($cartItemId);
            $ticket = $cartItem->getTicket();
            $tickets[] = $ticket;
        }
        
    }

    public function generateInvoice($order)
    {
        
    }

    public function sendInvoiceAndTicketsByEmail($order)
    {

    }
}
?>