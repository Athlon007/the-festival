<?php
require_once("../services/UserService.php");

class UserController
{
    public function manageUsers()
    {
        try {
            session_start();

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
}