<?php
require_once('../Event.php');
require_once('JazzArtist.php');
require_once('Venue.php');

class JazzEvent extends Event implements JsonSerializable
{
    private JazzArtist $artist;
    private Venue $venue;

    public function __construct($id, $name, DateTime $startTime, DateTime $endTime, $price, $artist, $venue)
    {
        //parent::__construct($id, $name, $startTime, $endTime, $price);
        $this->artist = $artist;
        $this->venue = $venue;
    }

    public function getArtist(): JazzArtist
    {
        return $this->artist;
    }

    public function setArtist(JazzArtist $value)
    {
        $this->artist = $value;
    }

    public function getVenue(): Venue
    {
        return $this->venue;
    }

    public function setVenue(Venue $value)
    {
        $this->venue = $value;
    }

    public function jsonSerialize(): mixed
    {
        return array_merge(parent::jsonSerialize(), [
            'artist' => $this->getArtist(),
            'venue' => $this->getVenue()
        ]);
    }
}
