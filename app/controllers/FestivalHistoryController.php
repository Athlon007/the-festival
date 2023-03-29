<?php

require_once("../services/CartItemService.php");

class FestivalHistoryController
{
    public function loadHistoryStrollPage()
    {
        try {
            $cartItemService = new CartItemService();
            $historyCartItems = $cartItemService->getAllHistory();

            require("../views/festival/history-stroll.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}