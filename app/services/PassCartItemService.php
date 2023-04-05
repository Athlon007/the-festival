<?php

require_once("CartItemService.php");
require_once(__DIR__ . "/../repositories/PassCartItemRepository.php");

class PassCartItemService extends CartItemService
{
    public function __construct()
    {
        $this->repo = new PassCartItemRepository();
    }
}
