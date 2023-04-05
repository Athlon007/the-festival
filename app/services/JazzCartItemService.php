<?php

require_once("CartItemService.php");
require_once(__DIR__ . "/../repositories/JazzCartItemRepository.php");

class JazzCartItemService extends CartItemService
{
    public function __construct()
    {
        $this->repo = new JazzCartItemRepository();
    }
}
