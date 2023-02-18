<?php
class AuthController
{
    public function resetPassword(): void
    {        //checking the form has been submitted
        if (isset($_POST['submitEmail'])){
            $reset_token = bin2hex(random_bytes(16));
            $email = $_POST['email'];
            $sendTime = time();
            // here insert the email, reset token, and timestamp into the database (timestamp will be 24 hours from now
            require("../repositories/AuthRepository.php");
            $authRepository = new AuthRepository();
            $authRepository->storeResetToken($email, $reset_token, $sendTime);

            //send the reset token to the user's email
            $to = $email;
            $subject = "Password Reset Request";
            $message = "To reset your password, please visit this link:\n\n"
            . "https://example.com/reset-password.php?token=$reset_token\n\n"
            . "This link will only be valid for 24 hours.";

            //$headers = "From: {email address of the sender}\r\n";
            mail($to, $subject, $message, $headers);

            echo "A password reset link has been sent to your email address.";
        }
        else{
            echo "Please enter your email address.";
            // require(path to the reset password form);
        }
        require("../views/auth/reset-password.php");
    }
}