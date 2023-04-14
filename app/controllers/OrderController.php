<?php

require_once(__DIR__ . "/../services/OrderService.php");

class OrderController
{
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    /**
     * Show the shopping cart
     * @author Joshua
     */
    public function showShoppingCart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cartItemIds']) || count($_SESSION['cartItemIds']) == 0) {
            $cartItems = array();
        } else {
            $cartItems = $this->orderService->getCart();
            $totalPrice = 0;

            foreach ($cartItems as $cartItem) {
                $totalPrice += $cartItem['price'];
            }
        }

        require('../views/payment-funnel/cart.php');
    }

    /**
     * Show the logged in customer's order history
     */
    public function showOrderHistory()
    {
        //TODO: Implement
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
            }
            else{
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
