<?php

class HistoryTicket extends Ticket implements JsonSerializable
{
    private Guide $guide;

    public function jsonSerialize(): mixed
    {
        return (parent::jsonSerialize() +  [
            'guide' => $this->guide
        ]);
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