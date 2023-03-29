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
    private $cartItemRepository;
    private $ticketRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->cartItemRepository = new CartItemRepository();
        $this->ticketRepository = new TicketRepository();
    }

    public function getOrderById($id)
    {
        return $this->repository->getOrderById($id);
    }

    public function getOrderHistory($customerId)
    {
        return $this->repository->getOrderHistory($customerId);
    }

    public function getUnpaidOrder($customerId)
    {
        return $this->repository->getUnpaidOrder($customerId);
    }

    public function createOrder($customer, $cartItemIds)
    {
        $order = new Order();
        $order->setCustomer($customer);
        foreach($cartItemIds as $cartItemId){
            $cartItem = $this->cartItemRepository->getCartItemById($cartItemId);
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