<?php

    class Address{
        
        private $streetName;
        private $houseNumber;
        private $postalCode;
        private $city;
        private $country;

        public function setStreetName($streetName){
            $this->streetName = $streetName;
        }

        public function getStreetName(){
            return $this->streetName;
        }

        public function setHouseNumber($houseNumber){
            $this->houseNumber = $houseNumber;
        }

        public function getHouseNumber(){
            return $this->houseNumber;
        }

        public function setPostalCode($postalCode){
            $this->postalCode = $postalCode;
        }

        public function getPostalCode(){
            return $this->postalCode;
        }

        public function setCity($city){
            $this->city = $city;
        }

        public function getCity(){
            return $this->city;
        }

        public function setCountry($country){
            $this->country = $country;
        }

        public function getCountry(){
            return $this->country;
        }
    }
?>