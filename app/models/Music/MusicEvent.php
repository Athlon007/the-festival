<?php
require_once(__DIR__ . '/../Event.php');
require_once('Artist.php');
require_once(__DIR__ . '/../Location.php');

class MusicEvent extends Event implements JsonSerializable
{
    private Artist $artist;
    private Location $location;

    public function __construct($id, $name, DateTime $startTime, DateTime $endTime, $price, Artist $artist, Location $location)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setStartTime($startTime);
        $this->setEndTime($endTime);
        $this->setPrice($price);
        $this->artist = $artist;
        $this->location = $location;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }

    public function setArtist(Artist $value)
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
