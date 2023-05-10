<?php
require_once(__DIR__ . "/../APIController.php");
require_once(__DIR__ . "/../../../services/OrderService.php");
require_once(__DIR__ . "/../../../models/Order.php");
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
        if (basename($uri) == "orders") {
            $this->sendResponse($this->orderService->getAllOrders());
        }

        
        

        //api/orders/unpaid/{customerId}

        //api/orders/paid/{customerId}

        //api/orders/{id}
        if (str_starts_with($uri, "api/orders/") && is_numeric(basename($uri))) {
            
        }
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