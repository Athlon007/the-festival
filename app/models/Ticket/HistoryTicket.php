<?php

class HistoryTicket extends Ticket implements JsonSerializable
{
    protected Guide $guide;

    public function jsonSerialize(): mixed
    {
        return [
            'ticketId' => $this->tickedId,
            'qr_code_data' => $this->qr_code,
            'event' => $this->event,
            'customer' => $this->customer,
            'is_scanned' => $this->isScanned,
            'order_id' => $this->orderId,
            'ticket_type' => $this->ticket_type,
            'guide' => $this->guide
        ];
    }

    public function getGuide(): Guide
    {
        return $this->guide;
    }

    public function setGuide(Guide $guide): void
    {
        $this->guide = $guide;
    }
}