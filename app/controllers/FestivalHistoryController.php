<?php

require_once("../services/FestivalHistoryService.php");

class FestivalHistoryController
{
    public function loadHistoryStrollPage()
    {
        try {
            $festivalHistoryService = new FestivalHistoryService();

            $historyEvents = $festivalHistoryService->getAllHistoryEvents();
            $locations = $festivalHistoryService->getAllTourLocations();
            
            require("../views/festival/history-stroll.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}