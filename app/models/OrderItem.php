<?php
require_once("TicketLink.php");

class OrderItem implements JsonSerializable { 

    private int $orderItemId;
    private TicketLink $ticketLink;
    private int $quantity;

    public function jsonSerialize(){
        return [
            "orderItemId" => $this->orderItemId,
            "ticketLink" => $this->ticketLink,
            "quantity" => $this->quantity,
            "totalBasePrice" => $this->getTotalBasePrice(),
            "bvatPercentage" => $this->getVatPercentage(),
            "totalVatAmount" => $this->getTotalVatAmount(),
            "totalFullPrice" => $this->getTotalFullPrice(),
        ];
    }

    public function __construct($id, TicketLink $ticketLink){
        $this->orderItemId = $id;
        $this->ticketLink = $ticketLink;
        $this->quantity = 1;
    }

    public function getOrderItemId(): int
    {
        return $this->orderItemId;
    }

    public function setOrderItemId(int $orderItemId): void
    {
        $this->orderItemId = $orderItemId;
    }

    public function getTicketLink(): TicketLink
    {
        return $this->ticketLink;
    }

    public function setTicketLink(TicketLink $ticketLink): void
    {
        $this->ticketLink = $ticketLink;
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
    public function getEventName(){
        return $this->ticketLink->getEvent()->getName();
    }

    public function getTicketTypeName(){
        return $this->ticketLink->getTicketType()->getName();
    }

    //Full price incl VAT for one ticket, retrieved from ticketlink
    public function getTicketFullPrice(): float
    {
        return $this->ticketLink->getTicketType()->getPrice();
    }

    //VAT percentage retrieved from the event type as a float e.g. "0.21"
    public function getVatPercentage(): float
    {
        return $this->ticketLink->getEvent()->getEventType()->getVat();
    }

    //Base price excl VAT for one ticket multiplied by quantity
    public function getTotalBasePrice(): float
    {
        return $this->ticketLink->getTicketType()->getPrice() * $this->quantity;
    }

    //VAT value that is multiplied by quantity
    public function getTotalVatAmount(): float
    {
        return $this->ticketLink->getEvent()->getEventType()->getVat() * $this->getBasePrice() * $this->quantity;
    }
    
    //Full price that is multiplied by quantity
    public function getTotalFullPrice(): float
    {
        return $this->getTicketFullPrice() * $this->quantity;
    }

}