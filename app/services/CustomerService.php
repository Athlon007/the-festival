<?php
require_once(__DIR__ . '/../repositories/AddressRepository.php');
require_once(__DIR__ . '/../services/MailService.php');
require_once(__DIR__ . '/../models/Customer.php');

class CustomerService extends UserService{
    private $addressRepository;
    private $mailService;

    public function __construct(){
        $this->addressRepository = new AddressRepository();
        $this->mailService = new MailService();
    }

    public function registerCustomer($data)
    {
        //Sanitise data
        $data->userType = 3;
        $data = $this->sanitiseCustomerData($data);

        //Convert address data to address object
        $streetname = $data->address->streetName;
        $housenumber = $data->address->houseNumber;
        $postalcode = $data->address->postalCode;
        $city = $data->address->city;
        $country = $data->address->country;
        $address = new Address(-1, $streetname, $housenumber, $postalcode, $city, $country);

        //Create customer object
        $customer = new Customer();
        $customer->setEmail($data->email);
        $customer->setFirstName($data->firstName);
        $customer->setLastName($data->lastName);
        $customer->setDateOfBirth(new DateTime($data->dateOfBirth));
        $customer->setPhoneNumber($data->phoneNumber);
        $customer->setAddress($address);

        //Hash password
        $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
        $customer->setHashPassword($hashedPassword);

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
        //Sanitise data
        $data = $this->sanitiseCustomerData($data);

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
            if (parent::emailAlreadyExists($data->email))
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

    private function sanitiseCustomerData($data){

        $data = parent::sanitiseUserData($data);
        $data->dateOfBirth = htmlspecialchars($data->dateOfBirth);
        $data->phoneNumber = htmlspecialchars($data->phoneNumber);
        $data->address->streetName = htmlspecialchars($data->address->streetName);
        $data->address->houseNumber = htmlspecialchars($data->address->houseNumber);
        $data->address->postalCode = htmlspecialchars($data->address->postalCode);
        $data->address->city = htmlspecialchars($data->address->city);
        $data->address->country = htmlspecialchars($data->address->country);

        return $data;
    }
}
