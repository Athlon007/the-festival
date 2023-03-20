<?php

require_once("Address.php");

class Location implements JsonSerializable
{
    private int $locationId;
    private string $name;
    private Address $address;
    private int $locationType;
    private ?int $capacity;
    private $lon;
    private $lat;

    public function __construct($locationId, $name, Address $address, $locationType, $lon, $lat, $capacity)
    {
        $this->locationId = $locationId;
        $this->name = $name;
        $this->address = $address;
        $this->locationType = $locationType;
        $this->lon = $lon;
        $this->lat = $lat;
        $this->capacity = $capacity;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    public function getLocationId()
    {
        return $this->locationId;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setLocationType($locationType)
    {
        $this->locationType = $locationType;
    }

    public function getLocationType()
    {
        return $this->locationType;
    }

    public function getLocationTypeAsString()
    {
        switch ($this->locationType) {
            case 1:
                return "Jazz";
            case 2:
                return "Restaurant";
            case 3:
                return "History";
            default:
                return "Unknown";
        }
    }

    public function setLon($lon)
    {
        $this->lon = $lon;
    }

    public function getLon()
    {
        return $this->lon;
    }

    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getLocationId(),
            'name' => $this->getName(),
            'address' => $this->getAddress(),
            'locationType' => $this->getLocationType(),
            'locationTypeFriendly' => $this->getLocationTypeAsString(),
            'capacity' => $this->getCapacity(),
            'lon' => $this->getLon(),
            'lat' => $this->getLat()
        ];
    }
}