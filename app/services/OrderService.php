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
require_once(__DIR__ . '/../services/TicketService.php');
require_once(__DIR__ . '/../services/InvoiceService.php');
require_once(__DIR__ . '/../service/PDFService.php');


class OrderService
{
    private $orderRepository;
    private $cartItemRepository;
    private $ticketRepository;
    private $ticketService;
    private $invoiceService;
    private $pdfService;

    const CART_ARRAY = 'cartItemIds';

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->cartItemRepository = new CartItemRepository();
        $this->ticketRepository = new TicketRepository();
        $this->ticketService = new TicketService();
        $this->invoiceService = new InvoiceService();
        $this->pdfService = new PDFService();
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

    //
    public function createOrder($customer, $cartItemIds)
    {
        
    }


    public function sendInvoiceAndTicketsByEmail($order)
    {
        foreach ($order->getTickets() as $ticket) {
            //Generate a PDF for the ticket and send it by email.
            $domPdf = $this->pdfService->generatePDF($ticket->getHtml(), "Ticket", "ticket " . $ticket->getId() .".pdf");
            $this->ticketService->sendTicketByEmail($domPdf, $ticket, $order);
        }
    }

    /**
     * Returns the cart as an array of cart item arrays.
     * @param CartItem $cartItem The cart item to add.
     * @return array The cart as an array of cart item arrays.
     * @author Konrad
     */
    public function addItemToCart(CartItem $cartItem): array
    {
        // Free event have no limit on tickets.
        if ($cartItem->getTicketType()->getPrice() > 0 && $cartItem->getEvent()->getAvailableTickets() == 0) {
            throw new Exception("No tickets available for this event.");
        }

        // Check if session is initialized.
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

    /**
     * Returns the cart as an array of cart item arrays.
     * @param CartItem $cartItem The cart item to remove.
     * @return array The cart as an array of cart item arrays.
     * @author Konrad
     */
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

    /**
     * Counts the number of specific cart item in the cart.
     * @param CartItem $cartItem The cart item to count.
     * @return int The number of cart items in the cart.
     * @author Konrad
     */
    public function countItemInCart(CartItem $cartItem): int
    {
        // If session is not initialized anyway, we can't remove anything.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
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

    /**
     * Returns the number of items in the cart.
     * @return int The number of items in the cart.
     * @author Konrad
     */
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

    /**
     * Returns the cart as an array of cart items and their count.
     * @return array The cart as an array of cart items and their count.
     * @author Konrad
     */
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
            $price = $ci->getTicketType()->getPrice() * $count;

            // If output already contains the cart item, we don't need to add it again.
            if (in_array($ci->getId(), $idsAdded)) {
                continue;
            }

            $output[] = [
                'cartItem' => $ci,
                'count' => $count,
                'price' => $price,
            ];

            $idsAdded[] = $ci->getId();
        }

        // return the array.
        return $output;
    }

    /**
     * Clears the cart.
     * @author Konrad
     */
    public function clearCart()
    {
        // If session is not initialized anyway, we can't remove anything.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[OrderService::CART_ARRAY])) {
            return [];
        }

        $_SESSION[OrderService::CART_ARRAY] = [];
    }
}
