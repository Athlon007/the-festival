<?php

class Ticket implements JsonSerializable
{
    protected $tickedId;
    protected $qr_code;
    protected Event $event;
    protected bool $isScanned = false;
    protected $basePrice;
    protected $vat;
    protected $fullPrice;

    public function jsonSerialize(): mixed
    {
        return [
            'ticketId' => $this->tickedId,
            'qr_code_data' => $this->qr_code,
            'event' => $this->event,
            'is_scanned' => $this->isScanned,
            'base_price' => $this->basePrice,
            'vat' => $this->vat,
            'full_price' => $this->fullPrice,
        ];
    }

    public function getTicketId(): int
    {
        return $this->tickedId;
    }

    public function setTicketId(int $ticketId): void
    {
        $this->tickedId = $ticketId;
    }

    public function getQrCodeData(): string
    {
        return $this->qr_code;
    }

    public function setQrCodeData(string $qr_code): void
    {
        $this->qr_code = $qr_code;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    public function isScanned(): bool
    {
        return $this->isScanned;
    }

    public function setIsScanned(bool $isScanned): void
    {
        $this->isScanned = $isScanned;
    }

    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    public function setBasePrice(float $basePrice): void
    {
        $this->basePrice = $basePrice;
    }

    public function getVat(): float
    {
        return $this->vat;
    }

    public function setVat(float $vat): void
    {
        $this->vat = $vat;
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