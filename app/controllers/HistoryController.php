<?php
class HistoryController
{
    public function manageHistory()
    {
        try{
            require_once("../services/HistoryService.php");
            $HistoryService = new HistoryService();
            $History = $HistoryService->getAllTours();
            require_once("../views/admin/History management/manageHistory.php");
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}

?>
