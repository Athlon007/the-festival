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
        try {
            if (basename($uri) == 'count') {
                echo json_encode(["count" => $this->orderService->getCartCount()]);
                return;
            } elseif (is_numeric(basename($uri))) {
                $cartItem = $this->ciService->getById(basename($uri));
                $count = $this->orderService->countItemInCart($cartItem);
                echo json_encode(["count" => $count]);
                return;
            }

            $cart = $this->orderService->getCart();
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
            $cartItem = $this->ciService->getById($ciID);

            if ($cartItem == null) {
                $this->sendErrorMessage("Cart item not found", 404);
                return;
            }

            $this->orderService->addItemToCart($cartItem);
            $cart = $this->orderService->getCart();
            echo json_encode($cart);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to add item into cart.", 500);
            return;
        }
    }

    protected function handleDeleteRequest($uri)
    {
        if (basename($uri) == 'clear') {
            $this->orderService->clearCart();
            echo json_encode(["count" => 0]);
            return;
        }

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
            Logger::write($e);
            $this->sendErrorMessage("Unable to remove item from cart.", 500);
            return;
        }
    }
}
