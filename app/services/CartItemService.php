<?php

require_once(__DIR__ . "/../repositories/CartItemRepository.php");
require_once("EventService.php");
require_once("TicketTypeService.php");
require_once(__DIR__ . "/../models/Exceptions/ObjectNotFoundException.php");

class CartItemService
{
    protected CartItemRepository $repo;

    public function __construct()
    {
        $this->repo = new CartItemRepository();
    }

    public function getAll($sort = null, $filters = []): array
    {
        return $this->repo->getAll($sort, $filters);
    }

    public function getById(int $id): CartItem
    {
        return $this->repo->getById($id);
    }

    public function getByEventId(int $id): CartItem
    {
        $item = $this->repo->getByEventId($id);
        if ($item == null) {
            throw new ObjectNotFoundException("CartItem not found");
        }
        return $item;
    }

    public function add(CartItem $cartItem): CartItem
    {
        $eventService = new EventService();
        $ticketTypeService = new TicketTypeService();

        $ticketType = $ticketTypeService->getById($cartItem->getTicketType()->getId());
        $event = $eventService->addEvent($cartItem->getEvent());

        $id = $this->repo->createCartItem($event->getId(), $ticketType->getId());
        return $this->getById($id);
    }

    public function updateCartItem(CartItem $cartItem): CartItem
    {
        $id = htmlspecialchars($cartItem->getId());
        $eventId = htmlspecialchars($cartItem->getEvent()->getId());
        $ticketTypeId = htmlspecialchars($cartItem->getTicketType()->getId());

        $eventService = new EventService();
        $eventService->editEvent($cartItem->getEvent());

        $this->repo->updateCartItem($id, $eventId, $ticketTypeId);

        return $this->getById($id);
    }

    public function deleteCartItem(CartItem $cartItem): void
    {
        $eventService = new EventService();
        $eventService->deleteEvent($cartItem->getEvent());

        $id = htmlspecialchars($cartItem->getId());
        $this->repo->deleteCartItem($id);
    }
}
