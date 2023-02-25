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
        $userService = new UserService();

        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            try {
                $user = $userService->getUserById($userId);
                require("../views/admin/updateUser.php");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        if (isset($_POST['updateUserButton'])) {
            $userId = htmlspecialchars($_POST['userID']);
            $user = $userService->getUserByID($userId);

            $user->setFirstName(htmlspecialchars($_POST['firstName']));
            $user->setLastName(htmlspecialchars($_POST['lastName']));
            $user->setEmail(htmlspecialchars($_POST['username']));

            $userService->updateUser($user);

            $url = "manageUsers";
            header("Location:$url");
            exit();
        }
    }
}