<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../repositories/OrderRepository.php');
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../models/Exceptions/OrderNotFoundException.php');
require_once(__DIR__ . '/../repositories/CartItemRepository.php');
require_once(__DIR__ . '/../models/CartItem.php');
require_once(__DIR__ . '/../repositories/TicketRepository.php');

class OrderService
{
    private $orderRepository;
    private $cartItemRepository;
    private $ticketRepository;

    const CART_ARRAY = 'cartItemIds';

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
        foreach ($cartItemIds as $cartItemId) {
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

    public function addItemToCart(CartItem $cartItem): array
    {
        // Check if session is initalized.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[OrderService::CART_ARRAY])) {
            $_SESSION[OrderService::CART_ARRAY] = array();
        }

        // add the cart item to the array (yes, we can have multiple cart items with the same id).
        array_push($_SESSION[OrderService::CART_ARRAY], $cartItem->getId());

        // return the array.
        return $this->getCart();
    }

    public function removeItemFromCart(CartItem $cartItem): array
    {
        // If session is not initialized anyway, we can't remove anything.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[OrderService::CART_ARRAY])) {
            return [];
        }

        // Because we can have duplicates, remove only ONE instance of the cart item, if it exists.
        $index = array_search($cartItem->getId(), $_SESSION[OrderService::CART_ARRAY]);
        if ($index !== false) {
            unset($_SESSION[OrderService::CART_ARRAY][$index]);
        }

        // return the array.
        return $_SESSION[OrderService::CART_ARRAY];
    }

    private function countItemInCart(CartItem $cartItem): int
    {
        // If session is not initialized anyway, we can't remove anything.
        if (session_status() == PHP_SESSION_NONE) {
            return 0;
        }

        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[OrderService::CART_ARRAY])) {
            $_SESSION[OrderService::CART_ARRAY] = array();
        }

        // Because we can have duplicates, remove only ONE instance of the cart item, if it exists.
        $count = 0;
        foreach ($_SESSION[OrderService::CART_ARRAY] as $id) {
            if ($id == $cartItem->getId()) {
                $count++;
            }
        }

        // return the array.
        return $count;
    }

    public function getCartCount(): int
    {
        // If session is not initialized anyway, we can't remove anything.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }



        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[OrderService::CART_ARRAY])) {
            return 0;
        }

        // return the array.
        return count($_SESSION[OrderService::CART_ARRAY]);
    }

    public function getCart(): array
    {
        // If session is not initialized anyway, we can't remove anything.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[OrderService::CART_ARRAY])) {
            return [];
        }

        $output = [];
        $idsAdded = [];
        foreach ($_SESSION[OrderService::CART_ARRAY] as $id) {
            $ci = $this->cartItemRepository->getById($id);
            $count = $this->countItemInCart($ci);

            // If output already contains the cart item, we don't need to add it again.
            if (in_array($ci->getId(), $idsAdded)) {
                continue;
            }

            $output[] = [
                'cartItem' => $ci,
                'count' => $count
            ];

            $idsAdded[] = $ci->getId();
        }

        // return the array.
        return $output;
    }
}
