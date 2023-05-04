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
     * @param TicketLink $ticketLink The ticket link to add.
     * @return array The cart as an array of cart item arrays.
     * @author Konrad
     */
    public function add($orderId, $ticketLinkId): array
    {
        // Check if the cart item already exists in the cart.
        // If so, update the amount.
        if (isset($_SESSION[CartService::CART_ARRAY])) {
            $index = $this->findIndex($ticketLink);

            if ($index !== false) {
                $_SESSION[CartService::CART_ARRAY][$index]['amount']++;
                return $this->cart();
            }
        }

        return $this->set($ticketLink, 1);
    }

    public function remove($orderId, $ticketLinkId): array
    {
        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[CartService::CART_ARRAY])) {
            return [];
        }

        // Find the index of the cart item in the cart.
        $index = $this->findIndex($ticketLink);
        // Remove it.
        unset($_SESSION[CartService::CART_ARRAY][$index]);

        // return the array.
        return $this->cart();
    }

    /**
     * Subtracts one instance of specific cart item from the cart and returns the cart as an array of cart item arrays.
     * @param TicketLink $ticketLink The cart item to add.
     * @return array The cart as an array of cart item arrays.
     * @author Konrad
     */
    public function subtract($orderId, $ticketLinkId): array
    {
        // Check if the cart item already exists in the cart.
        // If so, update the amount.
        if (isset($_SESSION[CartService::CART_ARRAY])) {
            $index = $this->findIndex($ticketLink);
            if ($index !== false) {
                $_SESSION[CartService::CART_ARRAY][$index]['amount']--;

                // If the amount is 0, remove the cart item from the cart.
                if ($_SESSION[CartService::CART_ARRAY][$index]['amount'] == 0) {
                    unset($_SESSION[CartService::CART_ARRAY][$index]);
                }
            }
        }

        return $this->cart();
    }

    /**
     * Sets the amount of specific cart item in the cart and returns the cart as an array of cart item arrays.
     * @param TicketLink $ticketLink The cart item to add.
     * @param int $amount The amount of cart items to add.
     * @return array The cart as an array of cart item arrays.
     * @throws EventSoldOutException If the event is sold out.
     */
    public function set(TicketLink $ticketLink, int $amount): array
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

    /**
     * Returns the cart as an array of cart item arrays.
     * @param TicketLink $ticketLink The cart item to remove.
     * @return array The cart as an array of cart item arrays.
     * @author Konrad
     */
    

    /**
     * Returns the number of items in the cart.
     * @return int The number of items in the cart.
     * @author Konrad
     */
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
     * Returns the cart as an array of cart items and their count.
     * @return array The cart as an array of cart items and their count.
     * @author Konrad
     */
    public function cart(): array
    {
        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[CartService::CART_ARRAY])) {
            return [];
        }

        $tls = [];
        $count = 0;
        $totalPrice = 0;
        foreach ($_SESSION[CartService::CART_ARRAY] as $entry) {
            $tl = $this->ticketLinkRepository->getById($entry['ticketLinkId']);
            $price = $tl->getTicketType()->getPrice() * $entry['amount'];

            $tls[] = [
                'ticketLink' => $tl,
                'amount' => $entry['amount'],
                'price' => $price,
            ];

            $count += $entry['amount'];
            $totalPrice += $price;
        }

        return [
            'count' => $count,
            'totalPrice' => $totalPrice,
            'ticketLinks' => $tls
        ];
    }

    /**
     * Clears the cart.
     * @author Konrad
     */
    public function clear(): array
    {
        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[CartService::CART_ARRAY])) {
            return [];
        }

        $_SESSION[CartService::CART_ARRAY] = [];
        return $this->cart();
    }

    /**
     * Returns the index of the cart item in the cart.
     * @param TicketLink $ticketLink The cart item to find.
     * @return int The index of the cart item in the cart.
     * @author Konrad
     */
    private function findIndex(TicketLink $ticketLink)
    {
        // check if array of cart item arrays is initialized.
        if (!isset($_SESSION[CartService::CART_ARRAY])) {
            return false;
        }

        // Find the index of the cart item in the cart.
        return array_search($ticketLink->getId(), array_column($_SESSION[CartService::CART_ARRAY], 'ticketLinkId'));
    }
}
