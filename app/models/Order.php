<?php

class Order implements JsonSerializable
{
    private int $orderId;
    private array $tickets;

    private float $totalFullPrice;
    private Customer $customer;
    private DateTime $orderDate;

    public function jsonSerialize(): mixed
    {
        return [
            'orderId' => $this->orderId,
            'tickets' => $this->tickets,
            'customer' => $this->customer,
            'orderDate' => $this->orderDate,
            'totalFullPrice' => $this->totalFullPrice,
        ];
    }

    public function __construct()
    {
        $this->tickets = [];
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

    public function getOrderDate(): DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate(DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    public function getTotalFullPrice(): float
    {
        return $this->totalFullPrice;
    }

    public function setTotalFullPrice(float $totalFullPrice): void
    {
        $this->totalFullPrice = $totalFullPrice;
    }
}
