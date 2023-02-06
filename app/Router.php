<?php

class Router
{
    public function route($request): void
    {
        // TODO: Add routing :)
        try {
            require_once("controllers/HomeController.php");
            $controller = new HomeController();
            $controller->index();
        } catch (Throwable $ex) {
            require_once("views/404.php");
        }
    }
}
