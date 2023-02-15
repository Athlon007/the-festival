<?php

require_once(__DIR__ . '/../repositories/UserRepository.php');
require_once(__DIR__ . '/../repositories/CustomerRepository.php');
require_once(__DIR__ . '/../repositories/AddressRepository.php');
require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');

class CustomerService{

    private $customerRepository;
    private $userRepository;
    private $addressRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
        $this->customerRepository = new CustomerRepository();
        $this->addressRepository = new AddressRepository();
    }
    
    public function registerCustomer($data){
        try{
            //Create user object
            $customer = new Customer();
            
            //Set customer properties
            $customer->setEmail($data->email);
            $customer->setFirstName($data->firstName);
            $customer->setLastName($data->lastName);
            $customer->setUserType(3);
            $customer->setDateOfBirth($data->dateOfBirth);
            $customer->setAddress($data->address);

            //Hash password
            $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
            $customer->setHashPassword($hashedPassword);

            //Insert customer address into address table and retrieve the new addressId
            $this->addressRepository->insertAddress($customer->getAddress());
            $customer->getAddress()->setAddressId($this->addressRepository->connection->lastInsertId());

            //Insert customer into user table (inheritance parent) and retrieve the new userId
            $this->userRepository->insertUser($customer);
            $customer->setUserId($this->userRepository->connection->lastInsertId());
            
            //Insert customer into customer table (inheritance child) with the retrieved foreign keys
            $this->customerRepository->insertCustomer($customer);
        }
        catch(Exception $ex){
            throw ($ex);
        }
    }
}
?>
