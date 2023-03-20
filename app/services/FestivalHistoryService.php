<?php

class FestivalHistoryService
{
    public function getAllHistoryEvents()
    {
        try{
            require_once("../repositories/FestivalHistoryRepository.php");
            $festivalHistoryRepository = new FestivalHistoryRepository();
            $historyEvents = $festivalHistoryRepository->getAllHistoryEvents();

            return $historyEvents;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}