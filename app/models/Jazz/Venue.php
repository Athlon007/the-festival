<?php

require_once("../Address.php");

class Venue
{
    private $id;
    private Address $address;
    private int $capacity;

    public function __construct($id, $address, $capacity)
    {
        $this->id = $id;
        $this->address = $address;
        $this->capacity = $capacity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($value)
    {
        $this->address = $value;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($value)
    {
        $this->capacity = $value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'address' => $this->getAddress(),
            'capacity' => $this->getCapacity()
        ];
    }
}
