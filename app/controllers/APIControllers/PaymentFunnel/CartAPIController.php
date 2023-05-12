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
        try {
            $cartOrder = $this->cartService->getCart();
           parent::sendResponse($cartOrder, 200);

        } catch (Throwable $e) {
            Logger::write($e);
            parent::sendErrorMessage("Unable to retrieve the cart.", 500);
        }
    }

    protected function handlePostRequest($uri)
    {
        //api/cart/add/{ticketlinkId} method
        if(str_starts_with($uri, "/api/cart/add/") && is_numeric(basename($uri))){
            $data = json_decode(file_get_contents("php://input"));
            $cartOrder = $this->cartService->addItem($data);
            parent::sendResponse($cartOrder);
            return;
        }
        
        //api/cart/remove/{ticketlinkId} method
        if(str_starts_with($uri, "/api/cart/remove/") && is_numeric(basename($uri))){
            $data = json_decode(file_get_contents("php://input"));
            $cartOrder = $this->cartService->removeItem($data);
            parent::sendResponse($cartOrder);
            return;
        }
    }

    protected function handlePutRequest($uri){
        parent::sendErrorMessage("Method not allowed.", 405);
    }

    protected function handleDeleteRequest($uri)
    {
        parent::sendErrorMessage("Method not allowed.", 405);
    }
}
