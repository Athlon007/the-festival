<?php

require_once("../services/TicketLinkService.php");
require_once("../services/FestivalHistoryService.php");

class FestivalHistoryController
{
    private $festivalHistoryService;

    public function __construct()
    {
        $this->festivalHistoryService = new FestivalHistoryService();
    }
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

    public function getAllHistoryEvents()
    {
        try {
            $historyEvents = $this->festivalHistoryService->getAllHistoryEvents();
            require("../views/admin/History Management/manageHistory.php");

            return $historyEvents;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function addTour()
    {
        try {
            require("../views/admin/History Management/addTour.php");
        } catch (PDOException $e) {

        }
    }
}