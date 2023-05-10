<?php
require_once("Customer.php");
require_once("OrderItem.php");

class Order implements JsonSerializable
{
    private int $orderId;
    private array $orderItems;
    private array $tickets;
    private Customer $customer;
    private DateTime $orderDate;
    private bool $isPaid;

    public function jsonSerialize(): mixed
    {
        return [
            "orderId" => $this->orderId,
            "orderItems" => $this->orderItems,
            "tickets" => $this->tickets,
            "customer" => $this->customer,
            "orderDate" => $this->orderDate,
            "isPaid" => $this->isPaid,
        ];
    }

    public function __construct()
    {
        $this->orderItems = [];
        $this->tickets = [];
        $this->orderDate = new DateTime("now");
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getOrderItems(): array
    {
        return $this->orderItems;
    }

    public function setOrderItems(array $orderItems): void
    {
        $this->orderItems = $orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): void
    {
        $this->orderItems[] = $orderItem;
    }

    public function removeOrderItem(OrderItem $orderItem): void
    {
        $index = array_search($orderItem, $this->orderItems);
        if ($index !== false) {
            unset($this->orderItems[$index]);
        }
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }

    public function setTickets(array $tickets): void
    {
        $this->tickets = $tickets;
    }

    public function addTicket(Ticket $ticket): void
    {
        $this->tickets[] = $ticket;
    }

    public function removeTicket(Ticket $ticket): void
    {
        $index = array_search($ticket, $this->tickets);
        if ($index !== false) {
            unset($this->tickets[$index]);
        }
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

    public function getTotalBasePrice(): float
    {
        $totalBasePrice = 0;
        foreach ($this->orderItems as $orderItem) {
            $totalBasePrice += $orderItem->getBasePrice();
        }
        return $totalBasePrice;
    }

    public function getTotalVat9Amount(): float
    {
        $totalVat9Amount = 0;
        foreach ($this->orderItems as $orderItem) {
            if ($orderItem->getVatPercentage() == 0.09) {
                $totalVat9Amount += $orderItem->getVatAmount();
            }
        }
        return $totalVat9Amount;
    }

    public function getTotalVat21Amount(): float
    {
        $totalVat21Amount = 0;
        foreach ($this->orderItems as $orderItem) {
            if ($orderItem->getVatPercentage() == 0.21) {
                $totalVat9Amount += $orderItem->getVatAmount();
            }
        }
        return $totalVat21Amount;
    }

    public function getTotalPrice(): float
    {
        $totalVatTotalPrice = 0;
        foreach ($this->orderItems as $orderItem) {
            $totalVatTotalPrice += $orderItem->getFullPrice();
        }

        return $totalVatTotalPrice;
    }

    public function getTotalItemCount(){
        $totalItemCount = 0;
        foreach ($this->orderItems as $orderItem) {
            $totalItemCount += $orderItem->getQuantity();
        }
        return $totalItemCount;
    }
}
