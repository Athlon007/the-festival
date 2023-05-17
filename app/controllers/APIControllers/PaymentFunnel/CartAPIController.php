<?php
require_once("APIController.php");
require_once(__DIR__ . "/../../services/CartService.php");
require_once(__DIR__ . "/../../models/TicketLink.php");
require_once(__DIR__ . "/../../services/TicketLinkService.php");

/**
 * This API controller is specifically used to manipulate the cart in session.
 * @author Joshua
 */
class CartAPIController extends APIController
{
    private $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    protected function handleGetRequest($uri)
    { 
        try 
        {
            if($uri == "/api/cart/count"){
                //api/cart/count GET - returns the amount of items in the cart
                $count = $this->cartService->getCount();
                $response = ["count" => $count];
                parent::sendResponse($response);
                return;
            }
            else if($uri == "/api/cart"){
                //api/cart GET - returns the cart order as an order object
                $cartOrder = $this->cartService->getCart();
                parent::sendResponse($cartOrder);
            }
            else
                throw new Exception("Bad request.", 400);
        } 
        catch (Throwable $e) {
            Logger::write($e);
            parent::sendErrorMessage($e->getMessage(), $e->getCode());
        }
    }

    protected function handlePostRequest($uri)
    {
        try
        {
            //api/cart/add/{ticketlinkId} POST method - adds the ticket link to the cart order
            if(str_starts_with($uri, "/api/cart/add/") && is_numeric(basename($uri))){
                $ticketLinkId = basename($uri);
                $cartOrder = $this->cartService->addItem($ticketLinkId);
                parent::sendResponse($cartOrder);
                return;
            }
        
            //api/cart/remove/{ticketlinkId} POST method - removes the ticket link from the cart order
            if(str_starts_with($uri, "/api/cart/remove/") && is_numeric(basename($uri))){
                $ticketLinkId = basename($uri);
                $cartOrder = $this->cartService->removeItem($ticketLinkId);
                parent::sendResponse($cartOrder);
                return;
            }
        }
        catch(Throwable $e)
        {
            Logger::write($e);
            parent::sendErrorMessage($e->getMessage(), $e->getCode());
        }
        
        
    }

    protected function handlePutRequest($uri)
    {
        parent::sendErrorMessage("Method not allowed.", 405);
    }

    protected function handleDeleteRequest($uri)
    {
        parent::sendErrorMessage("Method not allowed.", 405);
    }
}
