<?php
require_once("Customer.php");
require_once("OrderItem.php");

class Order implements JsonSerializable
{
    private int $orderId;
    private array $orderItems;
    private Customer $customer;
    private DateTime $orderDate;
    private bool $isPaid;

    public function jsonSerialize(): mixed
    {
        return [
            'orderId' => $this->orderId,
            'orderItems' => $this->orderItems,
            'customer' => $this->customer,
            'orderDate' => $this->orderDate,
            'isPaid' => $this->isPaid
        ];
    }

    public function __construct()
    {
        $this->orderItems = [];
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

    public function getTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->tickets as $ticket) {
            $totalPrice += $ticket->getFullPrice();
        }
        return $totalPrice;
    }
}
