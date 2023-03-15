<?php
class JazzController
{
    public function manageJazz()
    {
        try{
            require_once("../services/JazzService.php");
            $jazzService = new JazzService();
            $jazz = $jazzService->getAllJazz();
            require("../views/admin/Jazz management/manageJazz.php");
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    public function addVenue(){
        try{
            require_once("../services/JazzService.php");
            $jazzService = new JazzService();
            $jazz = $jazzService->getAllJazz();
            require("../views/admin/Jazz management/Venue/addVenue.php");
        }
                catch (PDOException $e){
            echo $e->getMessage();
        }

    }
    public function updateVenue(){
        try{
            require_once("../services/JazzService.php");
            $jazzService = new JazzService();
            $jazz = $jazzService->getAllJazz();
            require("../views/admin/jazz management/Venue/updateVenue.php");
        }
                catch (PDOException $e){
            echo $e->getMessage();
        }

    }
    public function addArtist(){
        try{
            require_once("../services/JazzService.php");
            $jazzService = new JazzService();
            $jazz = $jazzService->getAllJazz();
            require("../views/admin/Jazz management/Artist/addArtist.php");
        }
                catch (PDOException $e){
            echo $e->getMessage();
        }

    }
    public function updateArtist(){
        try{
            require_once("../services/JazzService.php");
            $jazzService = new JazzService();
            $jazz = $jazzService->getAllJazz();
            require("../views/admin/Jazz management/Artist/updateArtist.php");
        }
                catch (PDOException $e){
            echo $e->getMessage();
        }

    }
    public function addEvent(){
        try{
            require_once("../services/JazzService.php");
            $jazzService = new JazzService();
            $jazz = $jazzService->getAllJazz();
            require("../views/admin/Jazz management/Event/addEvent.php");
        }
                catch (PDOException $e){
            echo $e->getMessage();
        }

    }
    public function updateEvent(){
        try{
            require_once("../services/JazzService.php");
            $jazzService = new JazzService();
            $jazz = $jazzService->getAllJazz();
            require("../views/admin/Jazz management/Event/updateEvent.php");
        }
                catch (PDOException $e){
            echo $e->getMessage();
        }

    }


}

?>