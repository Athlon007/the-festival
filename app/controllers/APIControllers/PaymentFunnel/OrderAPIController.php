<?php
/**
 * This class is the controller for the Order API.
 * @author Joshua
 */
class OrderAPIController extends APIController
{
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function handlePostRequest($uri)
    {
       //api/orders
    }
    
    public function handleGetRequest($uri)
    {
        //api/orders

        //api/orders/{id}
    }

    public function handleDeleteRequest($uri)
    {
       //api/orders/{id}
    }

    public function handlePutRequest($uri)
    {
        //api/orders/{id}
    }
}
?>