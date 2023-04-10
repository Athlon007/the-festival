<?php

class Invoice implements JsonSerializable {
    
    private int $invoiceId;
    private array $invoiceItems;
    private DateTime $invoiceDate;
    private DateTime $invoiceDeadline;

    private bool $isPaid = false;

    public function jsonSerialize(){
        return [
            'invoiceId' => $this->invoiceId,
            'invoiceItems' => $this->invoiceItems,
            'invoiceDate' => $this->invoiceDate,
            'invoiceDeadline' => $this->invoiceDeadline,
            'basePrice' => $this->calculateBasePrice(),
            'vat9Amount' => $this->calculateVat9Amount(),
            'vat21Amount' => $this->calculateVat21Amount(),
            'totalPrice' => $this->calculateTotalPrice(),
            'isPaid' => $this->isPaid,
        ];
    }

    public function __construct()
    {
        $this->invoiceItems = [];
        $this->invoiceDate = new DateTime("now");
        $this->invoiceDeadline = new DateTime("now");
    }

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(int $invoiceId): void
    {
        $this->invoiceId = $invoiceId;
    }

    public function getInvoiceItems(): array
    {
        return $this->invoiceItems;
    }

    public function setInvoiceItems(array $invoiceItems): void
    {
        $this->invoiceItems = $invoiceItems;
    }

    public function addInvoiceItem(InvoiceItem $invoiceItem): void
    {
        $this->invoiceItems[] = $invoiceItem;
    }

    public function removeInvoiceItem(InvoiceItem $invoiceItem): void
    {
        $this->invoiceItems = array_filter($this->invoiceItems, function ($i) use ($invoiceItem) {
            return $i !== $invoiceItem;
        });
    }

    public function getInvoiceDate(): DateTime
    {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(DateTime $invoiceDate): void
    {
        $this->invoiceDate = $invoiceDate;
    }

    public function getInvoiceDeadline(): DateTime
    {
        return $this->invoiceDeadline;
    }

    public function setInvoiceDeadline(DateTime $invoiceDeadline): void
    {
        $this->invoiceDeadline = $invoiceDeadline;
    }

    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): void
    {
        $this->isPaid = $isPaid;
    }

    public function calculateBasePrice(): float
    {
        $basePrice = 0;
        foreach ($this->invoiceItems as $invoiceItem) {
            $basePrice += $invoiceItem->getBasePrice() * $invoiceItem->getQuantity();
        }

        return $basePrice;
    }

    public function calculateVat9Amount(): float
    {
        $vat9Amount = 0;
        foreach ($this->invoiceItems as $invoiceItem) {
            if ($invoiceItem->getVatPercentage() === 0.09) {
                $vat9Amount += $invoiceItem->getBasePrice() * $invoiceItem->getQuantity() * 0.09;
            }
        }

        return $vat9Amount;
    }

    public function calculateVat21Amount(): float
    {
        $vat21Amount = 0;
        foreach ($this->invoiceItems as $invoiceItem) {
            if ($invoiceItem->getVatPercentage() === 0.21) {
                $vat21Amount += $invoiceItem->getBasePrice() * $invoiceItem->getQuantity() * 0.21;
            }
        }

        return $vat21Amount;
    }

    public function calculateTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->invoiceItems as $invoiceItem) {
            $totalPrice += $invoiceItem->getBasePrice() * $invoiceItem->getQuantity() * (1 + $invoiceItem->getVatPercentage());
        }

        return $totalPrice;
    }
}