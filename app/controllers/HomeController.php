<?php
class HomeController
{
    public function index(): void
    {
        require("../views/home/index.php");
    }

    public function account() : void
    {
        //Load login screen if user is not logged in, else load account management screen
        if (!isset($_SESSION['user'])) {
            require("../views/home/login.php");
        }
        else {
            $user = $_SESSION['user'];
            require("../views/home/account.php");
        }
    }

    public function register(): void
    {
        require("../views/home/register.php");
    }
}
