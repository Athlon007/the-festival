<?php

require_once("../services/TicketLinkService.php");
require_once("../services/FestivalHistoryService.php");
require_once("../services/LocationService.php");

class FestivalHistoryController
{
    private $festivalHistoryService;
    private $locationService;

    public function __construct()
    {
        $this->festivalHistoryService = new FestivalHistoryService();
        $this->locationService = new LocationService();
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
            $guides = $this->festivalHistoryService->getAllGuides();
            $locations = $this->locationService->getAll();
            require("../views/admin/History Management/addTour.php");



            return $guides
                && $locations;
        } catch (PDOException $e) {

        }
    }
}