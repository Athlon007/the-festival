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
}