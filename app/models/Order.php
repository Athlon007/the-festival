<?php

class Order implements JsonSerializable
{
    private int $orderId;
    private array $tickets;
    private Customer $customer;
    private DateTime $orderDate;
    private bool $isPaid = false;
    private $totalBasePrice;
    private $totalVat9;
    private $totalVat21;
    private $totalFullPrice;

    public function jsonSerialize(): mixed
    {
        return [
            'orderId' => $this->orderId,
            'tickets' => $this->tickets,
            'customer' => $this->customer,
            'orderDate' => $this->orderDate,
            'isPaid' => $this->isPaid,
            'totalBasePrice' => $this->totalBasePrice,
            'totalVat9' => $this->totalVat9,
            'totalVat21' => $this->totalVat21,
            'totalFullPrice' => $this->totalFullPrice,
        ];
    }

    public function __construct()
    {
        $this->tickets = [];
        $this->orderDate = new DateTime("now");
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

    public function getOrderDate(): DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate(DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    public function getIsPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): void
    {
        $this->isPaid = $isPaid;
    }

    public function getTotalBasePrice()
    {
        $totalBasePrice = 0;
        foreach ($this->tickets as $ticket) {
            $totalBasePrice += $ticket->getBasePrice();
        }
        return $totalBasePrice;
    }

    public function getTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->tickets as $ticket) {
            $totalPrice += $ticket->getFullPrice();
        }
        return $totalPrice;
    }
}
