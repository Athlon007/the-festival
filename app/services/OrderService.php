<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../repositories/OrderRepository.php');
require_once(__DIR__ . '/../models/Order.php');

class OrderService{
    private $repository;

    public function __construct()
    {
        $this->repository = new OrderRepository();
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

    public function createOrder($customerId, $cartItems)
    {
        $order = new Order();
        
    }

    public function generateInvoice($order)
    {
        
    }

    public function sendTicketsByEmail($order)
    {

    }
}
?>