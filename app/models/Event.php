<?php

class Event implements JsonSerializable
{
    private $id;
    private $name;
    private DateTime $startTime;
    private DateTime $endTime;
    private $price;

    // public function __construct($id, $name, DateTime $startTime, DateTime $endTime, $price)
    // {
    //     $this->id = $id;
    //     $this->name = $name;
    //     $this->startTime = $startTime;
    //     $this->endTime = $endTime;
    //     $this->price = $price;
    // }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(DateTime $value)
    {
        $this->startTime = $value;
    }

    public function getEndTime(): DateTime
    {
        return $this->endTime;
    }

    public function setEndTime(DateTime $value)
    {
        $this->endTime = $value;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($value)
    {
        $this->price = $value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "startTime" => $this->getStartTime(),
            "endTime" => $this->getEndTime(),
            "price" => $this->getPrice(),
        ];
    }
}
