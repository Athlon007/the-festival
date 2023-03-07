<?php
require_once(__DIR__ . '/../models/Address.php');

class AddressService{

    public function fetchAddressFromPostCodeAPI($data) : mixed{
        
        header("Authorization: Bearer 1b9faa1d-1521-43ca-af73-4caeb208222b");
        $url = "https://postcode.tech/api/v1/postcode?postcode=" . $data->postalCode . "&number=" . $data->houseNumber;
        $response = file_get_contents($url);
        $address = json_decode($response);

        if($address->message != null){
            throw new Exception("Invalid postal code or house number");
        }
        
        return $address;
    }
}