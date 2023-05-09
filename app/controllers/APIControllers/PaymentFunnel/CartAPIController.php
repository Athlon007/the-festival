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
            echo json_encode($cartOrder);

        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to retrieve the cart.", 500);
        }
    }

    protected function handlePostRequest($uri)
    {
        $this->sendErrorMessage("Bad request.", 400);
    }

    protected function handlePutRequest($uri){
        if(str_starts_with($uri, "/api/cart/add/") && is_numeric(basename($uri))){
            $data = json_decode(file_get_contents("php://input"));
            $cart = $this->cartService->addItem($data);
        }

        if(str_starts_with($uri, "/api/cart/remove/") && is_numeric(basename($uri))){
            $data = json_decode(file_get_contents("php://input"));
            $cart = $this->cartService->removeItem($data);
            return;

        }
    }

    protected function handleDeleteRequest($uri)
    {
        $this->sendErrorMessage("Bad request.", 400);
    }
}
