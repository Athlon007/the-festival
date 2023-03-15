<?php
class UserController
{
    public function manageUsers()
    {
        try{
            require_once("../services/UserService.php");
            $userService = new UserService();
            $users = $userService->getAllUsers();
            require("../views/admin/User management/manageUsers.php");
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function deleteUser()
    {
        try{
            if (isset($_POST["delete_user"])){
                require_once("../services/UserService.php");
                $userService = new UserService();
    
                $userId =htmlspecialchars($_POST['delete_user']);
    
                try {
                    $userService->deleteUser($userId);
                    // $_SESSION['message'] = "Deleted successfully";
                }catch (PDOException $e){
                    echo $e->getMessage();
                }
    
                $users = $userService->getAllUsers();
                header("Location: /manageUsers");
            }
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function updateUser(){
        require_once("../services/UserService.php");
        $userService = new UserService();

        if (isset($_GET['id'])){
            $userId =$_GET['id'];
            try {
                $user = $userService->getUserById($userId);
                require ("../views/admin/updateUser.php");
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }

        if (isset($_POST['updateUserButton'])){
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