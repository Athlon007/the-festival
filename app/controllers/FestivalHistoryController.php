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

            $uniqueDates = array_unique(array_map(function ($event) {
                return $event->getStartTime()->format('D d/m/Y');
            }, $historyEvents));

            $uniqueTimes = array_unique(array_map(function ($event) {
                return $event->getStartTime()->format('H:i');
            }, $historyEvents));

            $languages = array_unique(array_map(function ($event) {
                return $event->getGuide()->getLanguage();
            }, $historyEvents));

            $uniquePrices = array_unique(array_map(function ($event) {
               return $event->getPrice();
            }, $historyEvents));

            require("../views/festival/history-stroll.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}