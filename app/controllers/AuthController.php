<?php
class AuthController
{
    public function provideEmail(): void
    {
        require("../views/auth/provideEmail.php");
    }
    public function sendEmail(): void
    {
        require_once("../services/UserService.php");
        if (isset($_POST["submitEmail"])) {
            $email = htmlspecialchars($_POST["emailField"]);
            $reset_token = bin2hex(random_bytes(16));

            $userService = new UserService();
            $userService->storeResetToken($email, $reset_token);

            $userService->sendResetTokenToUser($email, $reset_token);
        }
    }


    public function updatePassword(): void
    {
        require_once("../services/UserService.php");
        $userService = new UserService();

        try {
            if (isset($_GET['token']) && isset($_GET['email'])) {
                $reset_token = $_GET['token'];
                $email = $_GET['email'];

                $userService->checkResetToken($email, $reset_token);
                $user = $userService->getUserByEmail($email);

                require_once('../views/auth/updatePassword.php');

                if (isset($_POST['resetPasswordButton'])) {
                    $password = htmlspecialchars($_POST['newPassword']);
                    $password_confirm = htmlspecialchars($_POST['confirmPassword']);
                    if ($password === $password_confirm) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $user->setHashPassword($hashedPassword);
                        $userService->updateUserPassword($user);

                        header("Location: /");
                        exit();
                    } else {
                        $e = new Exception("Passwords do not match");
                    }
                }
            } else {
                // If the reset token is not provided in the URL, redirect the user to the homepage or display an error message
                require_once('../views/home/index.php');
                exit();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}