<?php
require_once(__DIR__ . '/../services/MailService.php');
require_once(__DIR__ . '/../repositories/CustomerRepository.php');
require_once(__DIR__ . '/../repositories/AddressRepository.php');
require_once(__DIR__ . '/../repositories/UserRepository.php');
require_once(__DIR__ . '/../models/Customer.php');

/**
 * Service for the Customer API endpoint.
 * @author Joshua
 */
class CustomerService{
    private $mailService;
    private $customerRepository;
    private $addressRepository;
    private $userRepository;

    public function __construct(){
        $this->customerRepository = new CustomerRepository();
        $this->addressRepository = new AddressRepository();
        $this->userRepository = new UserRepository();
        $this->mailService = new MailService();
    }

    public function registerCustomer($customer)
    {
        //Hash password
        $hashedPassword = password_hash($customer->getHashPassword(), PASSWORD_DEFAULT);
        $customer->setHashPassword($hashedPassword);

        //Insert customer as user, then complete the customer object with the new userId
        $user = $this->userRepository->insertUser($customer);
        $customer->setUserId($user->getUserId());
        
        //Insert customer address, then complete the customer object with the new addressId
        $address = $this->addressRepository->insertAddress($customer->getAddress());
        $customer->setAddress($address);
        //Insert customer
        $this->customerRepository->insertCustomer($customer);
    }

    public function getCustomerByUser(User $user) : Customer
    {
        $customer = $this->customerRepository->getCustomerByUser($user);
        return $customer;
    }

    public function updateCustomer($customer, $data)
    {

        //If a new password was set, the confirm password must match the password currently in DB
        if (isset($data->password) && isset($data->confirmPassword))
        {
            $data->confirmPassword = htmlspecialchars($data->confirmPassword);
            password_verify($data->confirmPassword, $customer->getHashPassword());

            if (!password_verify($data->confirmPassword, $customer->getHashPassword()))
                throw new IncorrectPasswordException();

            //Hash the new password and update it
            $customer->setHashPassword(password_hash($data->password, PASSWORD_DEFAULT));
        }
        
        //Send a confirmation email to the customer's current (non-updated) email address.
        $this->mailService->sendAccountUpdateEmail($customer);

        //If the email has been updated, make sure it's not a duplicate in db, then update
        if ($customer->getEmail() != $data->email)
        {
            if ($this->userRepository->emailAlreadyExists($data->email))
                throw new EmailAlreadyExistsException();

            $customer->setEmail($data->email);
        }

        //Update everything else
        $customer->setFirstName($data->firstName);
        $customer->setLastName($data->lastName);
        $customer->setDateOfBirth(new DateTime($data->dateOfBirth));
        $customer->setPhoneNumber($data->phoneNumber);
        $customer->getAddress()->setStreetName($data->address->streetName);
        $customer->getAddress()->setHouseNumber($data->address->houseNumber);
        $customer->getAddress()->setPostalCode($data->address->postalCode);
        $customer->getAddress()->setCity($data->address->city);
        $customer->getAddress()->setCountry($data->address->country);

        $this->customerRepository->updateCustomer($customer);
    }
}
