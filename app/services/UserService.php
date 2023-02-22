<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once(__DIR__ . '/../services/CustomerService.php');
require_once __DIR__ . '/../models/User.php';
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');
require_once(__DIR__ . '/../models/Exceptions/IncorrectPasswordException.php');

class UserService{
    private UserRepository $repository;
    private CustomerService $customerService;

    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->customerService = new CustomerService();
    }
    
    public function verifyUser($data) : ?User
    {
        try 
        {
            //Sanitise data
            $data->email = htmlspecialchars($data->email);
            $data->password = htmlspecialchars($data->password);

            $user = $this->repository->getByEmail($data->email);

            if(password_verify($data->password, $user->getHashPassword())){
                
                if ($user->getUserType() == 3)
                {
                    $customer = $this->customerService->getCustomerByUserId($user);
                    return $customer;
                }
                return $user;
            }
            else{
                throw new IncorrectPasswordException("Incorrect combination of email and password");
            }

        }
        catch(Throwable $ex)
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