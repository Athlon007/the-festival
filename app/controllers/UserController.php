<?php
require_once("../services/UserService.php");

class UserController
{
    public function manageUsers()
    {
        try {
            $userService = new UserService();
            $users = $userService->getAllUsers();
            require("../views/admin/manageUsers.php");
        } catch (PDOException $e) {
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
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}