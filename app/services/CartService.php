<?php

require_once(__DIR__ . '/../models/Exceptions/EventSoldOutException.php');
require_once(__DIR__ . '/../models/TicketLink.php');
require_once(__DIR__ . '/../repositories/TicketLinkRepository.php');
require_once('OrderService.php');

/**
 * This class handles the cart and uses orderservice to communicate with db.
 * @author Konrad
 */
class CartService
{
    public function __construct()
    {
        //Start/continue session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Adds one instance of specific cart item to the cart and returns the cart as an array of cart item arrays.
     * @param $ticketLinkId The item to add.
     * @return Order returns the order object.
     * @author Joshua
     */
    public function getCart(): Order
    {
        //Check if the cart is initialized.
        if (!isset($_SESSION["cartId"])) {
            return null;
        }
        //Retrieve the order from the cart and db

        //Return the order
    }
    
    /**
     * Adds one instance of specific cart item to the cart and returns the cart as an array of cart item arrays.
     * @param $ticketLinkId The item to add.
     * @return Order returns the order object.
     * @author Joshua
     */
    public function addItem($ticketLinkId): Order
    {
        //Check if the cart is initialized.
        if (!isset($_SESSION["cartId"])) {
            return [];
        }
        
        //Retrieve the order from the cart

        //Check if an orderitem with the same ticketlinkid exists in the order

        //If so, add to quantity

        //Else, add new orderitem to order

        //Update the order in the database

        //Return the order
    }

    public function removeItem($ticketLinkId): Order
    {
        //Check if the cart is initialized.
        if (!isset($_SESSION["cartId"])) {
            return [];
        }
        
        //Retrieve the order from the cart

        //Check for the orderitem that contains the ticketlinkId

        //If so, subtract from quantity

        //Update the order in the database

        //Return the order
    }

    /**
     * Sets the amount of specific cart item in the cart and returns the cart as an array of cart item arrays.
     * @param TicketLink $ticketLink The cart item to add.
     * @param int $amount The amount of cart items to add.
     * @return array The cart as an array of cart item arrays.
     * @throws EventSoldOutException If the event is sold out.
     */
    public function set(TicketLink $ticketLink, int $amount): Order
    {
        $amountOfTicketsAfterAdding = $ticketLink->getEvent()->getAvailableTickets() - $amount;

        // Free event have no limit on tickets.
        // Same goes for the passes.
        if (
            $ticketLink->getTicketType()->getPrice() > 0
            && $ticketLink->getEvent()->getAvailableTickets() != null
            && $amountOfTicketsAfterAdding < 0
        ) {
            $eventName = $ticketLink->getEvent()->getName();
            $availableTickets = $ticketLink->getEvent()->getAvailableTickets();
            throw new EventSoldOutException(
                "Not enough tickets left for event '$eventName'. Available tickets: $availableTickets"
            );
        }


        // If array is not initialized, initialize it.
        if (!isset($_SESSION[CartService::CART_ARRAY])) {
            $_SESSION[CartService::CART_ARRAY] = array();
        }

        // add the cart item to the array (yes, we can have multiple cart items with the same id).
        $object = [
            'ticketLinkId' => $ticketLink->getId(),
            'amount' => $amount,
        ];

        // Check if the cart item already exists in the cart.
        // If so, update the amount.
        $index = $this->findIndex($ticketLink);

        if ($index !== false) {
            $_SESSION[CartService::CART_ARRAY][$index]['amount'] = $amount;
        } else {
            array_push($_SESSION[CartService::CART_ARRAY], $object);
        }

        // Amount is set to 0?
        // If so, remove the cart item from the cart.
        if ($amount == 0) {
            $this->remove($ticketLink);
        }

        // return the array.
        return $this->cart();
    }
    
    
    public function totalCount(): int
    {
        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[CartService::CART_ARRAY])) {
            return 0;
        }

        $count = 0;
        foreach ($_SESSION[CartService::CART_ARRAY] as $cartItem) {
            $count += $cartItem['amount'];
        }

        return $count;
    }

    /**
     * Clears the cart by removing all order items from the order in db.
     * @author Joshua
     */
    public function clear(): Order
    {
        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[CartService::CART_ARRAY])) {
            return [];
        }

    }
}
