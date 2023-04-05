<?php

require_once("CartItemService.php");
require_once(__DIR__ . "/../repositories/HistoryCartItemRepository.php");

class HistoryCartItemService extends CartItemService
{
    public function __construct()
    {
        $this->repo = new HistoryCartItemRepository();
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
            throw new Exception("CartItem not found");
        }
        return $item;
    }
}
