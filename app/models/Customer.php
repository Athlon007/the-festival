<?php

require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/Address.php');

class Customer extends User{
    private $dateOfBirth;
    private $address;

}