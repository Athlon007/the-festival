<?php

class OrderItem implements JsonSerializable { 

    private string $eventName;
    private string $ticketTypeName;
    private int $quantity;
    private float $basePrice;
    private float $vatPercentage;
    private float $vatAmount;
    private float $fullPrice;

    public function jsonSerialize(){
        return [
            "eventName" => $this->eventName,
            "ticketTypeName" => $this->ticketTypeName,
            "quantity" => $this->quantity,
            "basePrice" => $this->basePrice,
            "vatPercentage" => $this->vatPercentage,
            "vatAmount" => $this->vatAmount,
            "fullPrice" => $this->fullPrice
        ];
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
        return $this->basePrice * $this->vatPercentage;
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