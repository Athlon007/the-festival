<?php

require_once(__DIR__ . "/../services/OrderService.php");
require_once(__DIR__ . "/../services/CartService.php");
require_once(__DIR__ . "/../services/InvoiceService.php");

class OrderController
{
    private $orderService;
    private $cartService;
    private $invoiceService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->invoiceService = new InvoiceService();
    }

    public function showShoppingCart()
    {
        $hasStuffInCart = false;
        $cartOrder = null;
        $shareMode = false;

        try {
            // http://localhost/shopping-cart?id=16
            // Check if "id" is set in the URL query string
            // if so, other user is trying to share their cart with you
            if (isset($_GET["id"])) {
                $cartOrder = $this->cartService->getCartByOrderId($_GET["id"]);
                $shareMode = true;
            } else {
                $cartOrder = $this->cartService->getCart();
                if ($cartOrder->getTotalItemCount() > 0) {
                    $hasStuffInCart = true;
                }
            }
        } catch (Throwable $e) {
            Logger::write($e);
            $cartOrder = null;
        }

        require('../views/payment-funnel/cart.php');
    }

    /**
     * Show the logged in customer's order history
     */
    public function showOrderHistory()
    {
        try {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $customer = unserialize($_SESSION['user']);
            $orders = $this->orderService->getOrderHistory($customer->getUserId());
            //$orders = $this->orderService->getOrderHistory(33);
            require_once('../views/orderHistory.php');
        } catch (Throwable $e) {
            Logger::write($e);
        }
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

    public function getOrdersToExport()
    {
        try {
            // if (session_status() == PHP_SESSION_NONE) {
            //     session_start();
            // }

            // if (!isset($_SESSION['user'])) {
            //     header("Location: /");
            // }

            // $user = unserialize($_SESSION['user']);
            // if ($user->getUserTypeAsString() != "Admin") {
            //     header("Location: /");
            // }

            $orders = $this->orderService->getOrdersToExport(true);
            require_once('../views/admin/viewOrders.php');

            return $orders;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function downloadOrders()
    {
        try {
            // if (session_status() == PHP_SESSION_NONE) {
            //     session_start();
            // }

            // if (!isset($_SESSION['user'])) {
            //     header("Location: /");
            // }

            // $user = unserialize($_SESSION['user']);
            // if ($user->getUserTypeAsString() != "Admin") {
            //     header("Location: /");
            // }

            return $this->orderService->downloadOrders();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function sendInvoiceEmail()
    {
        // if (session_status() == PHP_SESSION_NONE) {
        //     session_start();
        // }

        // if (!isset($_SESSION['user'])) {
        //     header("Location: /");
        // }

        // $user = unserialize($_SESSION['user']);
        // if ($user->getUserTypeAsString() != "Admin") {
        //     header("Location: /");
        // }
        $order = new Order();
        return $this->invoiceService->sendInvoiceEmail($order);
    }
}
