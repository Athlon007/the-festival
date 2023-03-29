<?php

require_once(__DIR__ . "/../repositories/CartItemRepository.php");

class CartItemService
{
    private CartItemRepository $cartItemRepository;

    public function __construct()
    {
        $this->cartItemRepository = new CartItemRepository();
    }

    public function getAll(): array
    {
        return $this->cartItemRepository->getAll();
    }

    public function getAllJazz($sort = null, $filters = []): array
    {
        return $this->cartItemRepository->getAllJazz($sort, $filters);
    }

    public function getById(int $id): CartItem
    {
        return $this->cartItemRepository->getById($id);
    }

    public function getByEventId(int $id): CartItem
    {
        $item = $this->cartItemRepository->getByEventId($id);
        if ($item == null) {
            throw new Exception("CartItem not found");
        }
        return $item;
    }

    public function add(CartItem $cartItem): void
    {
        $eventId = htmlspecialchars($cartItem->getEvent()->getId());
        $ticketTypeId = htmlspecialchars($cartItem->getTicketType()->getId());

        $this->cartItemRepository->createCartItem($eventId, $ticketTypeId);

        // TODO
    }

    public function updateCartItem(CartItem $cartItem): void
    {
        $id = htmlspecialchars($cartItem->getId());
        $eventId = htmlspecialchars($cartItem->getEvent()->getId());
        $ticketTypeId = htmlspecialchars($cartItem->getTicketType()->getId());

        $this->cartItemRepository->updateCartItem($id, $eventId, $ticketTypeId);

        // TODO
    }

    public function deleteCartItem(int $id): void
    {
        $id = htmlspecialchars($id);
        $this->cartItemRepository->deleteCartItem($id);
    }
}
