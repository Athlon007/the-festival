<?php

class OrderItem implements JsonSerializable { 

    private $eventName;
    private $ticketTypeName;
    private $quantity;
    private $basePrice;
    private $vatPercentage;
    private $vatAmount;
    private $fullPrice;

    public function jsonSerialize(){
        return [];
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
    }

    public function getTicketTypeName(): string
    {
        return $this->ticketTypeName;
    }

    public function setTicketTypeName(string $ticketTypeName): void
    {
        $this->ticketTypeName = $ticketTypeName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    public function setBasePrice(float $basePrice): void
    {
        $this->basePrice = $basePrice;
    }

    public function getVatPercentage(): float
    {
        return $this->vatPercentage;
    }

    public function setVatPercentage(float $vatPercentage): void
    {
        $this->vatPercentage = $vatPercentage;
    }

    public function getVatAmount(): float
    {
        return $this->vatAmount;
    }

    public function setVatAmount(float $vatAmount): void
    {
        $this->vatAmount = $vatAmount;
    }

    public function getFullPrice(): float
    {
        return $this->fullPrice;
    }

    public function setFullPrice(float $fullPrice): void
    {
        $this->fullPrice = $fullPrice;
    }
}