<?php
require_once(__DIR__ . '/Repository.php');
require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../repositories/AddressRepository.php');
require_once(__DIR__ . '/../repositories/UserRepository.php');

class CustomerRepository extends Repository{

    private $addressRepository;
    private $userRepository;
    
    public function __construct()
    {
        parent::__construct();
        $this->addressRepository = new AddressRepository();
        $this->userRepository = new UserRepository();
    }
    
    public function getCustomerByUser(User $user) : Customer
    {
        try{
            $query = "SELECT dateOfBirth, phoneNumber, addressId FROM customers WHERE userId = :userId";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":userId", $user->getUserId());
            $stmt->execute();
            $result = $stmt->fetchAll();

            if (is_bool($result)){
                require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');
                throw new UserNotFoundException("User ID not found");
            }

            $result = $result[0];

            //Create customer from the user object and the result from the query
            $customer = new Customer();
            $customer->setUserId($user->getUserId());
            $customer->setFirstName($user->getFirstName());
            $customer->setLastName($user->getLastName());
            $customer->setEmail($user->getEmail());
            $customer->setHashPassword($user->getHashPassword());
            $customer->setUserType(3);
            $customer->setDateOfBirth(new DateTime($result['dateOfBirth']));
            $customer->setPhoneNumber($result['phoneNumber']);
            $customer->setAddress($this->addressRepository->getAddressById($result['addressId']));

            return $customer;
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }        
    }
    
    public function insertCustomer(Customer $customer) : void
    {
        try{
            //Throw error if email already exists
            if($this->userRepository->emailAlreadyExists($customer->getEmail()))
            {
                require_once(__DIR__ . '/../models/Exceptions/EmailAlreadyExistsException.php');
                throw new EmailAlreadyExistsException();
            }

            //Insert customer address into address table and retrieve the new addressId
            $this->addressRepository->insertAddress($customer->getAddress());
            $customer->getAddress()->setAddressId($this->addressRepository->connection->lastInsertId());

            //Insert customer into user table (inheritance parent) and retrieve the new userId
            $this->userRepository->insertUser($customer);
            $customer->setUserId($this->userRepository->connection->lastInsertId());
            
            $query = "INSERT INTO customers (dateOfBirth, phoneNumber, addressId, userId) " .
                        "VALUES (:dateOfBirth, :phoneNumber, :addressId, :userId)";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":dateOfBirth", $customer->getDateOfBirthAsString());
            $stmt->bindValue(":phoneNumber", $customer->getPhoneNumber());
            $stmt->bindValue(":addressId", $customer->getAddress()->getAddressId());
            $stmt->bindValue(":userId", $customer->getUserId());
            
            $stmt->execute();
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }

    public function updateCustomer(Customer $customer) : void
    {
        try{
            //Update customer address
            $this->addressRepository->updateAddress($customer->getAddress());

            //Update customer in user table (inheritance parent)
            $this->userRepository->updateUser($customer);
            
            $query =    "UPDATE customers SET dateOfBirth = :dateOfBirth, phoneNumber = :phoneNumber, addressId = :addressId " .
                        "WHERE userId = :userId";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":dateOfBirth", $customer->getDateOfBirthAsString());
            $stmt->bindValue(":phoneNumber", $customer->getPhoneNumber());
            $stmt->bindValue(":addressId", $customer->getAddress()->getAddressId());
            $stmt->bindValue(":userId", $customer->getUserId());
            
            $stmt->execute();
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }
}
?>