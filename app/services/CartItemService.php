<?php

require_once(__DIR__ . "/../repositories/CartItemRepository.php");
require_once("EventService.php");
require_once("TicketTypeService.php");

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

    public function getAllHistory()
    {
        return $this->cartItemRepository->getAllHistory();
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

    public function add(CartItem $cartItem): CartItem
    {
        $eventService = new EventService();
        $ticketTypeService = new TicketTypeService();

        $ticketType = $ticketTypeService->getById($cartItem->getTicketType()->getId());
        $event = $eventService->addEvent($cartItem->getEvent());

        $id = $this->cartItemRepository->createCartItem($event->getId(), $ticketType->getId());
        return $this->getById($id);
    }

    public function updateCartItem(CartItem $cartItem): CartItem
    {
        $id = htmlspecialchars($cartItem->getId());
        $eventId = htmlspecialchars($cartItem->getEvent()->getId());
        $ticketTypeId = htmlspecialchars($cartItem->getTicketType()->getId());

        $eventService = new EventService();
        $eventService->editEvent($cartItem->getEvent());

        $this->cartItemRepository->updateCartItem($id, $eventId, $ticketTypeId);

        return $this->getById($id);
    }

    public function deleteCartItem(CartItem $cartItem): void
    {
        $eventService = new EventService();
        $eventService->deleteEvent($cartItem->getEvent());

        $id = htmlspecialchars($cartItem->getId());
        $this->cartItemRepository->deleteCartItem($id);
    }
}
