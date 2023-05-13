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
        //api/cart GET - returns the cart order as an order object
        try {
            $cartOrder = $this->cartService->getCart();
            parent::sendResponse($cartOrder);

        } catch (Throwable $e) {
            Logger::write($e);
            parent::sendErrorMessage("Unable to retrieve the cart.", 500);
        }
    }

    protected function handlePostRequest($uri)
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

    protected function handlePutRequest($uri)
    {
        parent::sendErrorMessage("Method not allowed.", 405);
    }

    protected function handleDeleteRequest($uri)
    {
        parent::sendErrorMessage("Method not allowed.", 405);
    }
}
