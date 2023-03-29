<?php

class Order implements JsonSerializable
{
    private int $orderId;
    private array $tickets;
    private Customer $customer;
    private DateTime $orderDate;
    private bool $isPaid;
    private float $totalBasePrice;
    private float $totalVat9;
    private float $totalVat21;
    private float $totalPrice;
   
    public function jsonSerialize(){
    return [
        'orderId' => $this->orderId,
        'tickets' => $this->tickets,
        'customer' => $this->customer,
        'orderDate' => $this->orderDate,
        'isPaid' => $this->isPaid
    ];
    }

    public function __construct(){
        $this->tickets = [];	
        $this->orderDate = new DateTime();
        $this->isPaid = false;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }

    public function setTickets(array $tickets): void
    {
        $this->tickets = $tickets;
    }

    public function addTicket(int $ticket): void
    {
        $this->tickets[] = $ticket;
    }

    public function removeTicket(int $ticket): void
    {
        $this->tickets = array_filter($this->tickets, function ($t) use ($ticket) {
            return $t !== $ticket;
        });
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getOrderDate(): ?DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate(?DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): void
    {
        $this->isPaid = $isPaid;
    }

    public function getTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->tickets as $ticket) {
            $totalPrice += $ticket->getPrice();
        }
        return $totalPrice;
    }


}