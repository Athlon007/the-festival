<?php
require_once(__DIR__ . "/../repositories/FestivalHistoryRepository.php");

class FestivalHistoryService
{
    private $festivalHistoryRep;

    public function __construct()
    {
        $this->festivalHistoryRep = new FestivalHistoryRepository();
    }

    public function getAllHistoryEvents()
    {
        return $this->festivalHistoryRep->getAllHistoryEvents();
    }

}