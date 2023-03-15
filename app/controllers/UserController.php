<?php
require_once("../services/UserService.php");

class UserController
{
    public function manageUsers()
    {
        try {
            session_start();
            
            if (!isset($_SESSION['user'])) {
                header("Location: /");
            }

            $user = $_SESSION['user'];
            if ($user->getUserTypeAsString() != "Admin") {
                header("Location: /");
            }

            $userService = new UserService();
            $users = $userService->getAllUsers();
            require("../views/admin/manageUsers.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateUser()
    {
        try{
            $userService = new UserService();
            $user = $userService->getUserById($_GET['id']);
            require("../views/admin/updateUser.php");
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function addUser()
    {
        try{
            $userService = new UserService();
            require("../views/admin/addUser.php");
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}