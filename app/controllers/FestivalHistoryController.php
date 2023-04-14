<?php

require_once("../services/TicketLinkService.php");

class FestivalHistoryController
{
    public function loadHistoryStrollPage()
    {
        try {
            $cartItemService = new TicketLinkService();
            $historyTicketLinks = $cartItemService->getAll();

            require("../views/festival/history-stroll.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
