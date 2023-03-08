<?php
class JazzController
{
    public function manageJazz()
    {
        try{
            require_once("../services/JazzService.php");
            $jazzService = new JazzService();
            $jazz = $jazzService->getAllJazz();
            require("../views/admin/manageJazz.php");
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}

?>