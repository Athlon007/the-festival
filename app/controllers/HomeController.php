<?php
require_once(__DIR__ . "/../models/Customer.php");
class HomeController
{
    public function index(): void
    {
        require("../views/home/index.php");
    }

    public function account() : void
    {
        session_start();
        //Load login screen if user is not logged in, else load account management screen
        if (!isset($_SESSION['user'])) {
            require("../views/account/login.php");
        }
        else {
            $user = $_SESSION['user'];
            if ($user->getUserType() == 3)
            {
                require("../views/account/customerAccount.php");
            }
            else
            {
                require("../views/account/employeeAccount.php");
            }
        }
    }

    public function register(): void
    {
        require("../views/account/register.php");
    }
}
