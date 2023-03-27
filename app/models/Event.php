<?php

class Event implements JsonSerializable
{
    private $id;
    private $name;
    private DateTime $startTime;
    private DateTime $endTime;
    private $vat;
    private int $availableTickets;
    
    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "startTime" => $this->getStartTime(),
            "endTime" => $this->getEndTime(),
            "vat" => $this->getVat(),
            "availableTickets" => $this->getAvailableTickets(),
        ];
    }

    public function setId($value)
    {
        $this->id = $value;
    }

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
    
    public function getVat()
    {
        return $this->vat;
    }

    public function setVat($value)
    {
        $this->vat = $value;
    }

    public function getAvailableTickets()
    {
        return $this->availableTickets;
    }

    public function setAvailableTickets($value)
    {
        $this->availableTickets = $value;
    }
}
