<?php
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once(__DIR__ . '/../services/CustomerService.php');
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
    protected UserRepository $repository;
    private CustomerService $customerService;

    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->customerService = new CustomerService();
    }

    public function verifyUser($data): ?User
    {
        try {
            //Sanitise data
            $data->email = htmlspecialchars($data->email);
            $data->password = htmlspecialchars($data->password);

            $user = $this->repository->getByEmail($data->email);

            if (password_verify($data->password, $user->getHashPassword())) {

                if ($user->getUserType() == 3) {
                    $customer = $this->customerService->getCustomerByUser($user);
                    return $customer;
                }

                return $user;
            } else {
                throw new IncorrectPasswordException();
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function createNewUser(string $email, string $firstName, string $lastName, string $password, $usertype, DateTime $registrationDate): void
    {
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
        $this->repository->insertUser($user);
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
                $user = $this->repository->getByEmail($data->email);
                $user->setEmail($data->email);
                $hashedPassword = password_hash($data->newPassword, PASSWORD_DEFAULT);
                $user->setHashPassword($hashedPassword);
                $this->repository->updatePassword($user);
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function storeResetToken($email, $reset_token)
    {
        try {
            if ($this->repository->getByEmail($email) != null) {
                $this->repository->storeResetToken($email, $reset_token);
            } else {
                throw new UserNotFoundException();
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

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
            $result = $this->repository->verifyResetToken($email, $reset_token);

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
            return $this->repository->getAllUsers();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteUser($data): void
    {
        try {
            $this->repository->deleteUser($data->id);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getUserById($id): User
    {
        try {
            return $this->repository->getById($id);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updateUser($data): void
    {
        try {
            //Sanitise user data
            $data = $this->sanitiseUserData($data);

            $user = $this->repository->getById($data->id);
            $user->setFirstName(htmlspecialchars($data->firstName));
            $user->setLastName(htmlspecialchars($data->lastName));
            $user->setEmail(htmlspecialchars($data->email));

            if (htmlspecialchars($data->role == "admin")) {
                $user->setUserType(1);
            } else if (htmlspecialchars($data->role == "employee")) {
                $user->setUserType(2);
            } else {
                $user->setUserType(3);
            }

            $this->repository->updateUser($user);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getUserByEmail($email): User
    {
        try {
            return $this->repository->getByEmail($email);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function emailAlreadyExists($email): bool
    {
        try {
            return $this->repository->emailAlreadyExists($email);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function sanitiseUserData($data)
    {
        if (isset($data->email)) {
            $data->email = htmlspecialchars($data->email);
        }
        if (isset($data->password)) {
            $data->password = htmlspecialchars($data->password);
        }
        if (isset($data->firstName)) {
            $data->firstName = htmlspecialchars($data->firstName);
        }
        if (isset($data->lastName)) {
            $data->lastName = htmlspecialchars($data->lastName);
        }
        if (isset($data->userType)) {
            $data->userType = htmlspecialchars($data->userType);
        }

        return $data;
    }
}
