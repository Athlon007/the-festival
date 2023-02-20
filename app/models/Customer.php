<?php

require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Address.php');

class Customer extends User{
    private DateTime $dateOfBirth;
    private string $phoneNumber;
    private Address $address;

    public function __construct(){
        $this->userType = 3;
    }

    public function jsonSerialize() : mixed
    {
        return [
            'userId' => $this->userId,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'hashPassword' => $this->hashPassword,
            'userType' => $this->userType,
            'dateOfBirth' => $this->dateOfBirth,
            'phoneNumber' => $this->phoneNumber,
            'address' => $this->address
        ];
    }

    public function getDateOfBirth() : DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(DateTime $dateOfBirth) : void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getPhoneNumber() : string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber) : void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getAddress() : Address
    {
        return $this->address;
    }

    public function setAddress(Address $address) : void
    {
        $this->address = $address;
    }
}

