<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../models/User.php';
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');

class UserService{
    
    private UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }
    
    public function verifyUser($email, $password) : ?User
    {
        try {
            $user = $this->repository->getByEmail($email);

            if($user == null){
                throw new UserNotFoundException("This email is not registered. Make an account by clicking 'Register now'.");
            }

            if(password_verify($password, $user->getHash())){
                return $user;
            }

            return null;
        }
        catch(Exception $ex){
            throw ($ex);
        }
    }
    
    public function registerNewCustomer($data)
    {
        try
        {
            $this->createNewUser($data->email, $data->firstName, $data->lastName, $data->password, 3);
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }

    public function createNewUser(string $email, string $firstName, string $lastName, string $password, int $usertype) : void
    {
        try
        {
            //Create user object
            $user = new User();
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setUserType($usertype);

            //Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setHash($hashedPassword);

            //Pass to repository
            $this->repository->insertUser($user);
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }

    public function storeResetToken($email, $reset_token, $sendTime){
        try{
            $this->repository->storeResetToken($email, $reset_token, $sendTime);
        }
        catch(Exception $ex){
            throw ($ex);
        }
    }

    public function sendResetTokenToUser($email, $reset_token)
    {
        try {
            $to = $email;
            $subject = "Password Reset Request";
            $message = "To reset your password, please visit this link:\n\n"
                . "https://example.com/reset-password.php?token=$reset_token\n\n"
                . "This link will only be valid for 24 hours.";

            $headers = "From: {turkvedat0911@gmail.com}\r\n";
            mail($to, $subject, $message, $headers);
            echo "A password reset link has been sent to your email address.";
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function checkResetToken($email, $reset_token){
        try{
            $this->repository->checkResetToken($email, $reset_token);
        }
        catch(Exception $ex){
            throw ($ex);
        }
    }

    public function updateUserPassword(User $user){
        try{
            $this->repository->updatePassword($user);
        }
        catch(Exception $ex){
            throw ($ex);
        }
    }

    public function getAllUsers() : array
    {
        try
        {
            return $this->repository->getAllUsers();
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }

    public function deleteUser($id) : void
    {
        try
        {
            $this->repository->deleteUser($id);
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }

    public function updateUser($data) : void
    {
        try
        {
            $user = new User();
            $user->setEmail($data->email);
            $user->setFirstName($data->firstName);
            $user->setLastName($data->lastName);
            $user->setUserType($data->userType);

            $this->repository->updateUser($user);
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }
}