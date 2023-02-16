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

            if(password_verify($password, $user->getHashPassword())){
                return $user;
            }

            return null;
        }
        catch(Exception $ex){
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
            $user->setHashPassword($hashedPassword);

            //Pass to repository
            $this->repository->insertUser($user);
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }
}