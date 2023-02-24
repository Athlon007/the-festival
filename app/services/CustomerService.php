<?php

require_once(__DIR__ . '/../repositories/UserRepository.php');
require_once(__DIR__ . '/../repositories/CustomerRepository.php');
require_once(__DIR__ . '/../repositories/AddressRepository.php');
require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../models/User.php');

class CustomerService extends UserService{

    private $customerRepository;
    private $userRepository;
    private $addressRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
        $this->customerRepository = new CustomerRepository();
        $this->addressRepository = new AddressRepository();
    }
    
    public function registerCustomer($data)
    {
        try{
            //Sanitise data
            $data = $this->sanitiseRegisterData($data);

            //Create customer object
            $customer = new Customer();
            
            //Convert data to appropriate datatypes
            $dateOfBirth = new DateTime($data->dateOfBirth);
            $address = new Address();
            $address->setStreetName($data->address->streetName);
            $address->setHouseNumber($data->address->houseNumber);
            $address->setPostalCode($data->address->postalCode);
            $address->setCity($data->address->city);
            $address->setCountry($data->address->country);

            //Set customer properties
            $customer->setEmail($data->email);
            $customer->setFirstName($data->firstName);
            $customer->setLastName($data->lastName);
            $customer->setDateOfBirth($dateOfBirth);
            $customer->setPhoneNumber($data->phoneNumber);
            $customer->setAddress($address);

            //Hash password
            $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
            $customer->setHashPassword($hashedPassword);

            //Insert customer
            $this->customerRepository->insertCustomer($customer);
        }
        catch(Exception $ex){
            throw ($ex);
        }
    }

    public function getCustomerByUserId($id) : Customer
    {
        try
        {
            $customer = $this->customerRepository->getCustomerByUserId($id);
            return $customer;
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }

    private function sanitiseRegisterData($data){
        $data->firstName = htmlspecialchars($data->firstName);
        $data->lastName = htmlspecialchars($data->lastName);
        $data->email = htmlspecialchars($data->email);
        $data->password = htmlspecialchars($data->password);
        $data->dateOfBirth = htmlspecialchars($data->dateOfBirth);
        $data->phoneNumber = htmlspecialchars($data->phoneNumber);
        $data->address->streetName = htmlspecialchars($data->address->streetName);
        $data->address->houseNumber = htmlspecialchars($data->address->houseNumber);
        $data->address->postalCode = htmlspecialchars($data->address->postalCode);
        $data->address->city = htmlspecialchars($data->address->city);
        $data->address->country = htmlspecialchars($data->address->country);

        return $data;
    }

    public function updateCustomer(){
        
    }
}
?>
