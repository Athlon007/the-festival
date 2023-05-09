<?php

require_once(__DIR__ . '/../models/Exceptions/EventSoldOutException.php');
require_once('OrderService.php');

/**
 * This class handles the cart session and uses OrderService to communicate with the database.
 * @author Joshua
 */
class CartService
{
    private $orderService;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->orderService = new OrderService();
    }
    
    /**
     * Is called to create a new cart order if there is none in session when it's required to be.
     * @return Order
     */
    private function initialiseCart($ticketLinkId) : Order{
        
        if (isset($_SESSION["cartId"])) {
            throw new Exception("Cart already initialised.");
        }

        //If a customer is logged in then we use their id, else we don't pass a customer id.
        if (isset($_SESSION["user"])) {
            $user = unserialize($_SESSION["user"]);
            
            //Only customers are able to buy tickets, not admins or staff.
            if ($user->getUserTypeAsString() == "Customer") {
                $customerId = $user->getUserId();
            }
            else{
                throw new Exception("User is not a customer.");
            }

            $order = $this->orderService->createOrder($ticketLinkId, $customerId);
        }
        else
            $order = $this->orderService->createOrder($ticketLinkId);
        

        $_SESSION["cartId"] = $order->getOrderId();
        return $order;
    }

    /**
     * Gets the cart using the session.
     * @return Order
     */
    public function getCart(): Order
    {
        //Check if the cart is initialised.
        if (!isset($_SESSION["cartId"])) {
            throw new Exception("Cart not initialised.");
        }

        //Retrieve the order that is in cart from the db and return it.
        $orderId = $_SESSION["cartId"];
        return $this->orderService->getOrderById($orderId);
    }
    
    /**
     * Adds one item to the cart.
     * @param $ticketLinkId The ID of the ticketlink to add.
     * @return Order
     */
    public function addItem($ticketLinkId): Order
    {
        //Check if the cart is initialized.
        if (!isset($_SESSION["cartId"])) {
            //If not, then a new order must be created to fill the cart.
            return $this->initialiseCart($ticketLinkId);
        }
        else{
            //Retrieve the order that is in cart from the db.
            $order = $this->orderService->getOrderById($_SESSION["cartId"]);

            //Check if an orderitem with the same ticketlinkid exists in the order
            foreach ($order->getOrderItems() as $orderItem){
                if ($orderItem->getTicketLink()->getTicketLinkId() == $ticketLinkId){
                    //If so, add to quantity of the orderItem, update the orderItem in the db, and return the updated order.    
                    $orderItem->setQuantity($orderItem->getQuantity() + 1);
                    return $this->orderService->updateOrderItem($orderItem->getId(), $orderItem);
                }
            }

            //If not, then a new orderitem must be created and added to the order.
            $this->orderService->addOrderItem($order, $ticketLinkId);
        }

        

        //Else, add new orderitem to order

        //Update the order in the database

        //Return the order
        return $order;
    }
    
    /**
     * Removes one item from the cart.
     * @param $ticketLinkId The ID of the item to remove.
     * @return Order returns the order object.
     * @author Joshua
     */
    public function removeItem($ticketLinkId): Order
    {
        //Check if the cart is initialized.
        if (!isset($_SESSION["cartId"])) {
            throw new Exception("Cart not initialized.");
        }
        
        //Retrieve the order that is in cart from the db.
        $cartOrder = $this->orderService->getOrderById($_SESSION["cartId"]);
        
        

        //Check for the orderitem that contains the ticketlinkId

        //If so, subtract from quantity

        //Update the order in the database

        //Return the order
    }

    public function checkoutCart(){

    }
}
