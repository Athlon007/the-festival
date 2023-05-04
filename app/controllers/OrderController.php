<?php

require_once(__DIR__ . "/../services/OrderService.php");
require_once(__DIR__ . "/../services/CartService.php");

class OrderController
{
    private $orderService;
    private $cartService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
    }

    public function showShoppingCart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $cart = $this->cartService->cart();
        $ticketLinks = $cart['ticketLinks'];

        require('../views/payment-funnel/cart.php');
    }

    /**
     * Show the logged in customer's order history
     */
    public function showOrderHistory()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $customer = unserialize($_SESSION['user']);
        // $orders = $this->orderService->getOrderHistory($customer->getUserId());
        $orders = $this->orderService->getOrderHistory(33);
        require_once('../views/orderHistory.php');

        return $orders;
    }

    /**
     * Create order after completing payment or selecting "pay later"
     * TODO: Still needs actual implementation after payment funnel redesign
     */
    public function createOrder()
    {
        try {
            if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
                throw new Exception("Cart is empty");
            }
            if (!isset($_SESSION['user'])) {
                throw new Exception("User is not logged in");
            } else {
                $customer = unserialize($_SESSION['user']);
            }

            if ($customer->getUserType() != 3) {
                throw new Exception("Only customers can place orders");
            }

            $cartItemIds = $_SESSION['cart'];
            $order = $this->orderService->createOrder($customer, $cartItemIds);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }
    }
}