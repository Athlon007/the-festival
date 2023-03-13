<?php
require_once(__DIR__ . '/../Event.php');
require_once('JazzArtist.php');
require_once(__DIR__ . '/../Location.php');

class JazzEvent extends Event implements JsonSerializable
{
    private JazzArtist $artist;
    private Location $location;

    public function __construct($id, $name, DateTime $startTime, DateTime $endTime, $price, JazzArtist $artist, Location $location)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setStartTime($startTime);
        $this->setEndTime($endTime);
        $this->setPrice($price);
        $this->artist = $artist;
        $this->location = $location;
    }

    public function getArtist(): JazzArtist
    {
        return $this->artist;
    }

    public function setArtist(JazzArtist $value)
    {
        $this->artist = $value;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $value)
    {
        $this->location = $value;
    }

    public function jsonSerialize(): mixed
    {
        return array_merge(parent::jsonSerialize(), [
            'artist' => $this->getArtist(),
            'location' => $this->getLocation()
        ]);
    }
}
