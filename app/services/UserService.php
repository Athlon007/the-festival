<?php
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once('CustomerService.php');
require_once __DIR__ . '/../models/User.php';
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');
require_once(__DIR__ . '/../models/Exceptions/IncorrectPasswordException.php');

require_once('../phpmailer/PHPMailer.php');
require_once('../phpmailer/SMTP.php');
require_once('../phpmailer/Exception.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UserService
{
    protected $userRepository;
    protected $customerService;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->customerService = new CustomerService();
    }

    public function verifyUser($data): ?User
    {
        //Sanitise data
        $data->email = htmlspecialchars($data->email);
        $data->password = htmlspecialchars($data->password);

        $user = $this->userRepository->getByEmail($data->email);

        if (!password_verify(htmlspecialchars($data->password), $user->getHashPassword())) {
            throw new IncorrectPasswordException();
        }

        //Nullify password, don't send that back to client.
        //$user->setHashPassword(null);

        //If the user is a customer, return a customer object instead of a user object.
        if ($user->getUserType() == 3) {
            $customer = $this->customerService->getCustomerById($user->getUserId());
            return $customer;
        }

        return $user;
    }

    public function createNewUser(string $email, string $firstName, string $lastName, string $password, $usertype, DateTime $registrationDate): void
    {
        if($this->emailAlreadyExists($email))
            throw new Exception("Email already exists.", 409);
        
        //Create user object
        $user = new User();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        // if usertype is string
        if (is_string($usertype)) {
            $user->setUserTypeByString($usertype);
        } elseif (is_int($usertype)) {
            $user->setUserType($usertype);
        } else {
            throw new Exception('Invalid data type for usertype.');
        }
        $user->setRegistrationDate($registrationDate);

        //Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user->setHashPassword($hashedPassword);

        //Pass to repository
        $this->userRepository->insertUser($user);
    }
    public function updateUserPassword($data)
    {
        try {
            $this->verifyResetToken(htmlspecialchars($data->email), htmlspecialchars($data->token));
            $newPassword = htmlspecialchars($data->newPassword);
            $confirmPassword = htmlspecialchars($data->confirmPassword);

            if ($newPassword != $confirmPassword) {
                throw new Exception("New password and confirm password do not match.");
            } else {
                $user = $this->userRepository->getByEmail($data->email);
                $user->setEmail($data->email);
                $hashedPassword = password_hash($data->newPassword, PASSWORD_DEFAULT);
                $user->setHashPassword($hashedPassword);
                $this->userRepository->updatePassword($user);
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function storeResetToken($email, $reset_token)
    {
        try {
            if ($this->userRepository->getByEmail($email) != null) {
                $this->userRepository->storeResetToken($email, $reset_token);
            } else {
                throw new UserNotFoundException();
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
    //TODO: move this function to the mailservice 
    public function sendResetTokenToUser($email, $reset_token)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = "true";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->isHTML(true);

            $mail->Username = "infohaarlemfestival5@gmail.com";
            $mail->Password = 'zznalnrljktsitri';
            $mail->Subject = "Password Reset Request";

            $user = $this->getUserByEmail($email);
            $name = $user->getFirstName();

            $mail->Body = "
                <html>
                <head>
                <title>Reset Your Password</title>
                <style>
                    body {
                    font-family: Arial, sans-serif;
                    font-size: 16px;
                    line-height: 1.5;
                    color: #333333;
                    background-color: #f7f7f7;
                    }
                    .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #ffffff;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    }
                    h1 {
                    font-size: 24px;
                    font-weight: bold;
                    margin-top: 0;
                    margin-bottom: 20px;
                    }
                    p {
                    margin-top: 0;
                    margin-bottom: 20px;
                    }
                    a.button {
                    color: #ffffff;
                    text-decoration: none;
                    background-color: #007bff;
                    padding: 10px 20px;
                    border-radius: 5px;
                    display: inline-block;
                    }
                    a.button:hover {
                    background-color: #0069d9;
                    }
                    .email {
                    color: #333333;
                    font-weight: bold;
                    }
                </style>
                </head>
                <body>
                <div class=\"container\">
                    <h1>Reset Your Password</h1>
                    <p>Dear $name,</p>
                    <p>We received a request to reset your password for The Festival website. If you did not initiate this request, please disregard this message.</p>
                    <p>If you did request a password reset, please click the link below to reset your password. This link will expire in 24 hours, so please act promptly.</p>
                </div>
                <div class=\"container\" style=\"margin-top: 20px;\">
                    <p>For security reasons, please do not share this link with anyone else. If you have any questions or concerns, please contact our support team at <span class=\"email\">infohaarlemfestival5@gmail.com</span></p>
                    <a href=\"http://localhost/updatePassword?token=$reset_token&email=$email\" class=\"button\">Reset Your Password</a>
                </div>
                <div class=\"container\" style=\"margin-top: 20px;\">
                    <p>Thank you,<br>The Festival Website Team</p>
                </div>
                </body>
                </html>
                ";

            $mail->setFrom("infohaarlemfestival5@gmail.com");
            $mail->addAddress($email);
            $mail->send();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function verifyResetToken($email, $reset_token)
    {
        try {
            $result = $this->userRepository->verifyResetToken($email, $reset_token);

            if ($result === null) {
                // reset token not found or expired
                throw new Exception('Reset token not found or expired, please request a new one.');
            }

            // check if reset token is still valid based on sendTime column
            $sendTime = strtotime($result['sendTime']);
            $currentTime = time();
            $validTime = 24 * 60 * 60; // 24 hours in seconds

            if (($currentTime - $sendTime) > $validTime) {
                // reset token has expired
                throw new Exception('Reset token expired, please request a new one.');
            }

            // reset token is still valid
            return $result;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getAllUsers(): array
    {
        try {
            return $this->userRepository->getAllUsers();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteUser($data): void
    {
        try {
            $this->userRepository->deleteUser($data->id);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getUserById($id): User
    {
        try {
            return $this->userRepository->getById($id);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updateUser($data): void
    {
        try {
            //Fetch user from db
            $user = $this->userRepository->getById($data->id);
            
            //Update user data
            $user->setFirstName($data->firstName);
            $user->setLastName($data->lastName);
            $user->setEmail($data->email);

            if ($data->role == "admin") {
                $user->setUserType(1);
            } else if ($data->role == "employee") {
                $user->setUserType(2);
            } else {
                $user->setUserType(3);
            }

            $this->userRepository->updateUser($user);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getUserByEmail($email): User
    {
        try {
            return $this->userRepository->getByEmail($email);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function emailAlreadyExists($email): bool
    {
        try {
            return $this->userRepository->emailAlreadyExists($email);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

}
