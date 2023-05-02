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
    private float $totalBasePrice;
    private float $totalVat9Amount;
    private float $totalVat21Amount;
    private float $totalPrice;

    public function jsonSerialize(): mixed
    {
        return [
            "orderId" => $this->orderId,
            "orderItems" => $this->orderItems,
            "customer" => $this->customer,
            "orderDate" => $this->orderDate,
            "isPaid" => $this->isPaid,
            "totalBasePrice" => $this->totalBasePrice,
            "totalVat9Amount" => $this->totalVat9Amount,
            "totalVat21Amount" => $this->totalVat21Amount,
            "totalPrice" => $this->totalPrice
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
        return $this->totalBasePrice;
    }

    public function setTotalBasePrice(float $totalBasePrice): void
    {
        $this->totalBasePrice = $totalBasePrice;
    }

    public function getTotalVat9Amount(): float
    {
        return $this->totalVat9Amount;
    }

    public function setTotalVat9Amount(float $totalVat9Amount): void
    {
        $this->totalVat9Amount = $totalVat9Amount;
    }

    public function getTotalVat21Amount(): float
    {
        return $this->totalVat21Amount;
    }

    public function setTotalVat21Amount(float $totalVat21Amount): void
    {
        $this->totalVat21Amount = $totalVat21Amount;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }
}
