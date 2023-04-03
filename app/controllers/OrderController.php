<?php
class OrderController
{
    public function showShoppingCart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
            $_SESSION['cart'] = array();
        }
        require('app/views/payment-funnel/cart.php');
    }

    public function showOrderHistory()
    {
    }

    public function generateInvoice()
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
