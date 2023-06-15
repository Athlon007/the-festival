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

    public function handleGetRequest($uri)
    {
        // Getting access to this API requires either a valid API key, or a valid session.
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage("You are not logged in as an admin.", 401);
        }

        //api/orders

        //api/orders/unpaid/{customerId}

        //api/orders/paid/{customerId}

        //api/orders/{id}
    }
}
