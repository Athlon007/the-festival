<?php
require_once("APIController.php");
require_once(__DIR__ . "/../../services/CartService.php");
require_once(__DIR__ . "/../../models/TicketLink.php");
require_once(__DIR__ . "/../../services/TicketLinkService.php");

/**
 *
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
            if (basename($uri) == 'count') {
                echo json_encode(["count" => $this->cartService->totalCount()]);
                return;
            } elseif (is_numeric(basename($uri))) {
                echo json_encode($this->ciService->getById(basename($uri)));
                return;
            }

            $cart = $this->cartService->cart();
            echo json_encode($cart);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to retrive cart.", 500);
        }
    }

    protected function handlePostRequest($uri)
    {
        $ciID = basename($uri);
        try {
            $ticketLink = $this->ciService->getById($ciID);

            if ($ticketLink == null) {
                $this->sendErrorMessage("Cart item not found", 404);
                return;
            }

            $cart = null;

            // Check if in the GET has amount.
            if (isset($_GET['amount'])) {
                $amount = $_GET['amount'];
                $cart = $this->cartService->set($ticketLink, $amount);
            } else {
                $cart = $this->cartService->add($ticketLink);
            }

            echo json_encode($cart);
        } catch (EventSoldOutException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to add item into cart.", 500);
            return;
        }
    }

    protected function handleDeleteRequest($uri)
    {
        if (basename($uri) == 'clear') {
            $cart = $this->cartService->clear();
            echo json_encode($cart);
            return;
        }

        $tlID = -1;
        $deleteAllOfTicket = false;
        if (basename($uri) == 'all') {
            // Get the tlID from the second last part of the URI.
            $uriParts = explode('/', $uri);
            $tlID = $uriParts[count($uriParts) - 2];
            $deleteAllOfTicket = true;
        } else {
            $tlID = basename($uri);
        }

        try {
            $ticketLink = $this->ciService->getById($tlID);

            if ($ticketLink == null) {
                $this->sendErrorMessage("Cart item not found", 404);
                return;
            }

            $cart = null;

            if ($deleteAllOfTicket) {
                $cart = $this->cartService->remove($ticketLink);
            } else {
                $cart = $this->cartService->subtract($ticketLink);
            }

            echo json_encode($cart);
            return;
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to remove item from cart.", 500);
            return;
        }
    }
}
