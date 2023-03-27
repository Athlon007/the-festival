<?php

class Ticket implements JsonSerializable
{
    protected $tickedId;
    protected $qr_code;
    protected Event $event;
    protected $ticket_type;
    protected bool $isScanned;
    protected $basePrice;
    protected $fullPrice;

    public function jsonSerialize(): mixed
    {
        return [
            'ticketId' => $this->tickedId,
            'qr_code_data' => $this->qr_code,
            'event' => $this->event,
            'ticket_type' => $this->ticket_type,
            'isScanned' => $this->isScanned,
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

    public function getBasePrice()
    {
        return $this->basePrice;
    }

    public function setBasePrice($value)
    {
        $this->basePrice = $value;
    }

    public function getFullPrice()
    {
        return $this->basePrice + ($this->basePrice * $this->event->getVat());
    }

    public function setFullPrice($value)
    {
        $this->fullPrice = $value;
    }
}