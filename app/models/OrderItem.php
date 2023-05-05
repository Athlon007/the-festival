<?php
require_once("TicketLink.php");

class OrderItem implements JsonSerializable { 

    private int $orderItemId;
    private int $ticketLinkId;
    private string $eventName;
    private string $ticketName;
    private string $vatPercentage;
    private float $fullTicketPrice;
    private int $quantity;

    public function jsonSerialize(){
        return [
            "orderItemId" => $this->getOrderItemId(),
            "ticketLinkId" => $this->getTicketLinkId(),
            "eventName" => $this->getEventName(),
            "ticketName" => $this->getTicketName(),
            "vatPercentage" => $this->getVatPercentage(),
            "fullTicketPrice" => $this->getFullTicketPrice(),
            "quantity" => $this->getQuantity(),
            "totalBasePrice" => $this->getTotalBasePrice(),
            "bvatPercentage" => $this->getVatPercentage(),
            "totalVatAmount" => $this->getTotalVatAmount(),
            "totalFullPrice" => $this->getTotalFullPrice(),
        ];
    }

    public function getOrderItemId(): int
    {
        return $this->orderItemId;
    }

    public function setOrderItemId(int $orderItemId): void
    {
        $this->orderItemId = $orderItemId;
    }

    public function getTicketLinkId(): int
    {
        return $this->ticketLinkId;
    }

    public function setTicketLinkId(int $ticketLinkId): void
    {
        $this->ticketLinkId = $ticketLinkId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    //
    //Calculated getters and getter-shortcuts from ticket link
    //

    //Base price excl VAT for one ticket multiplied by the quantity
    public function getTotalBasePrice(): float
    {
        return $this->ticketLink->getTicketType()->getPrice() * $this->quantity;
    }

    //VAT value that is multiplied by the quantity
    public function getTotalVatAmount(): float
    {
        return $this->ticketLink->getEvent()->getEventType()->getVat() * $this->getBasePrice() * $this->quantity;
    }
    
    //Full price that is multiplied by the quantity
    public function getTotalFullPrice(): float
    {
        return $this->getTicketFullPrice() * $this->quantity;
    }

}