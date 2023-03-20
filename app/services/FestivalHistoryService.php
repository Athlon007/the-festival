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

    public function getAllTourLocations()
    {
        try{
            // Call location repository
            require_once("../repositories/LocationRepository.php");
            $locationRepository = new LocationRepository();
            $locations = $locationRepository->getAllHistoryLocations();

            return $locations;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}