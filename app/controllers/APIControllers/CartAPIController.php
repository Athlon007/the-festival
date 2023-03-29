<?php
require_once(__DIR__ . "/APIController.php");
require_once(__DIR__ . "/../../services/OrderService.php");
require_once(__DIR__ . "/../../models/CartItem.php");
require_once(__DIR__ . "/../../services/CartItemService.php");

/**
 * Cart Controller, yeah...
 * @author Konrad
 */
class CartAPIController extends APIController
{
    private $orderService;
    private $ciService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->ciService = new CartItemService();
    }

    protected function handleGetRequest($uri)
    {
        $cart = $this->orderService->getCart();
        echo json_encode($cart);
    }

    protected function handlePostRequest($uri)
    {
        $ciID = basename($uri);
        try {
            $cartItem = $this->ciService->getById($ciID);

            if ($cartItem == null) {
                $this->sendErrorMessage("Cart item not found", 404);
                return;
            }

            $this->orderService->addItemToCart($cartItem);
            $cart = $this->orderService->getCart();
            echo json_encode($cart);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled error. " . $e->getMessage(), 500);
            return;
        }
    }

    protected function handleDeleteRequest($uri)
    {
        $ciID = basename($uri);
        try {
            $cartItem = $this->ciService->getById($ciID);

            if ($cartItem == null) {
                $this->sendErrorMessage("Cart item not found", 404);
                return;
            }

            $this->orderService->removeItemFromCart($cartItem);
            $cart = $this->orderService->getCart();
            echo json_encode($cart);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled error", 500);
            return;
        }
    }
}
