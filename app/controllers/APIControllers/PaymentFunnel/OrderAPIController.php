<?php

class OrderAPIController extends APIController
{
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function handlePostRequest($uri)
    {

    }
    
    public function handleGetRequest($uri)
    {
        
    }

    public function handleDeleteRequest($uri)
    {
       
    }

    public function handlePutRequest($uri)
    {
        
    }
} 


?>