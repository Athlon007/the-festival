<?php

require_once(__DIR__ . '/../models/Exceptions/EventSoldOutException.php');
require_once(__DIR__ . '/../models/Exceptions/CartException.php');
require_once('OrderService.php');


/**
 * Handles the cart session and uses OrderService to communicate with the database.
 * @author Joshua
 */
class CartService
{
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }
    
    /**
     * Is called to create a new cart order if there is none in session when it's required to be.
     * @return Order
     */
    private function initialiseCart($ticketLinkId) : Order
    {
        if ($this->cartIsInitialised()) {
            throw new CartException("Cart is already initialised.");
        }

        //If a customer is logged in then we use their id, else we don't pass a customer id.
        if (isset($_SESSION["user"])) {
            $user = unserialize($_SESSION["user"]);
            
            //Only visitors or customers are able to buy tickets, not admins or staff.
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
     * Gets the cart from the session.
     * @return Order
     */
    public function getCart(): Order
    {
        if (!$this->cartIsInitialised()) {
            throw new CartException("Cart is not initialised.");
        }

        //Retrieve the order that is in cart from the db and return it.
        $orderId = $_SESSION["cartId"];
        return $this->orderService->getOrderById($orderId);
    }

    /**
     * Gets the total item count from the session.
     * @return Order
     */
    public function getCount() : int{   
        
        if (!$this->cartIsInitialised()) {
            return 0;
        }
        else{
            $orderId = $_SESSION["cartId"];
            $order = $this->orderService->getOrderById($orderId);
            //Returns the total number of items in the order
            return $order->getTotalItemCount();
        }
    }
    
    /**
     * Adds one item to the cart.
     * @param $ticketLinkId The ID of the ticketlink to add.
     * @return Order
     */
    public function addItem($ticketLinkId): Order
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //If cart wasn't initialised, we initialise it using the ticket.
        if (!isset($_SESSION["cartId"])) {
            return $this->initialiseCart($ticketLinkId);
        }
        else{
            //Retrieve the order that is in cart from the db.
            $order = $this->orderService->getOrderById($_SESSION["cartId"]);

            //Check if an orderitem with the same ticketlinkid already exists in the order.
            foreach ($order->getOrderItems() as $orderItem){
                if ($orderItem->getTicketLink()->getTicketLinkId() == $ticketLinkId){
                    //If so, add to the quantity of the orderItem and update the orderItem.
                    $orderItem->setQuantity($orderItem->getQuantity() + 1);
                    $this->orderService->updateOrderItem($orderItem->getId(), $orderItem);
                }
            }
            //If not, then we create a new orderitem with the ticketlinkid and add it to the order.
            $orderItem = $this->orderService->createOrderItem($ticketLinkId, $order->getOrderId());
            $order->addOrderItem($orderItem);
        }
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
        //Retrieve the order that is in cart from the db.
        $order = $this->getCart();

        //Check for the orderitem that contains the ticketlinkId
        foreach ($order->getOrderItems() as $orderItem){
            if ($orderItem->getTicketLink()->getTicketLinkId() == $ticketLinkId){
                //If so, subtract 1 from the quantity of the orderItem.
                $orderItem->setQuantity($orderItem->getQuantity() - 1);
                
                if ($orderItem->getQuantity() == 0){
                    //If the quantity is 0, then we remove the orderitem from the order.
                    $this->orderService->deleteOrderItem($orderItem->getId());
                    $order->removeOrderItem($orderItem);
                }
                else{
                    //If not, then we only update the orderitem with the new quantity.
                    $this->orderService->updateOrderItem($orderItem->getId(), $orderItem);
                }
            }
        }
        return $order;
    }

    public function checkoutCart(){
        //Retrieve the order that is in cart from the db.
        $cartOrder = $this->getCart();
        $cartOrder->setIsPaid(true);
        $this->orderService->updateOrder($cartOrder->getOrderId(), $cartOrder);


    }

    public function getCartAfterLogin($customerId) {
        $this->cartIsInitialised();
        
        $customerOrder = $this->orderService->getCartOrderForCustomer($customerId);
        
        if(!$customerOrder){
            //If there is no cart order saved for the customer, then this method has no further purpose.
            return;
        }
        
        //Check if there is an active cart in session.
        if (!isset($_SESSION["cartId"])) {
            //If so, then we have to merge the two orders. The one that is in session and the one that the customer saved in the database during an earlier visit.
            $sessionOrder = $this->orderService->getOrderById($_SESSION["cartId"]);
            $mergedOrder = $this->orderService->mergeOrders($customerOrder, $sessionOrder);
            
            //Overwrite the session cart with the merged order.
            $_SESSION["cartId"] = $mergedOrder->getOrderId();
        }

        //If not, then we store the saved customer cart into the session so they can pick up where they left off.
        $_SESSION["cartId"] = $customerOrder->getOrderId();
    }

    private function cartIsInitialised() : bool 
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        //Check if the cart is initialised.
        return (isset($_SESSION["cartId"]));
    }
}
