<?php

require_once(__DIR__ . "/../services/OrderService.php");

class OrderController
{
    private $service;

    public function __construct()
    {
        $this->service = new OrderService();
    }

    public function showShoppingCart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cartItemIds']) || count($_SESSION['cartItemIds']) == 0) {
            $cartItems = array();
        }
        else {
            $cartItems = $this->service->getCart();
            $totalPrice = 0;
            
            foreach ($cartItems as $cartItem) {
                $totalPrice += $cartItem['price'];
            }
        }
        require('../views/payment-funnel/cart.php');
    }

    public function showOrderHistory()
    {

    }

    //Create order after completing payment or selecting "pay later"
    public function createOrder()
    {
        try {
            if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
                throw new Exception("Cart is empty");
            }
            if (!isset($_SESSION['user'])) {
                throw new Exception("User is not logged in");
            }

            $customer = unserialize($_SESSION['user']);
            if ($customer->getUserType() != 3) {
                throw new Exception("Only customers can place orders");
            }

            $cartItemIds = $_SESSION['cart'];
            $orderService = new OrderService();
            $order = $orderService->createOrder($customer, $cartItemIds);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }
}
