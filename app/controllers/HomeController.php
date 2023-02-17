<?php
class HomeController
{
    public function index(): void
    {
        require("../views/home/index.php");
    }

    public function login(): void
    {
        require("../views/home/login.php");
    }

    public function register(): void
    {
        require("../views/home/register.php");
    }
}
