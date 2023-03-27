<?php

class Ticket implements JsonSerializable
{
    protected $tickedId;
    protected $qr_code;
    protected Event $event;
    protected bool $isScanned = false;
    protected $ticket_type;
    protected $basePrice;
    protected $fullPrice;

    public function jsonSerialize(): mixed
    {
        return [
            'ticketId' => $this->tickedId,
            'qr_code_data' => $this->qr_code,
            'event' => $this->event,
            'is_scanned' => $this->isScanned,
            'ticket_type' => $this->ticket_type
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

    public function getTicketType(): string
    {
        return $this->ticket_type;
    }

    public function setTicketType(string $ticket_type): void
    {
        $this->ticket_type = $ticket_type;
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