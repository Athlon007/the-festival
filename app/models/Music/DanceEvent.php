<?php
    class DanceEvent extends MusicEvent implements JsonSerializable{
        private array $artists;

        public function __construct($id, $name, DateTime $startTime, DateTime $endTime, Artist $artist, Location $location, EventType $eventType, $availableTickets = null, array $artists)
        {
            parent::__construct($id, $name, $startTime, $endTime, $artist, $location, $eventType, $availableTickets);
            $this->setArtists($artists);
        }

    }
?>