<?php
require_once(__DIR__ . '/../Event.php');
require_once('Artist.php');
require_once(__DIR__ . '/../Types/EventType.php');
require_once(__DIR__ . '/../Location.php');

/**
 * @author Konrad
 */
class MusicEvent extends Event implements JsonSerializable
{
    private Artist $artist;
    protected Location $location;

    public function __construct($id, $name, DateTime $startTime, DateTime $endTime, Artist $artist, Location $location, EventType $eventType, $availableTickets = null)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setStartTime($startTime);
        $this->setEndTime($endTime);
        $this->setArtist($artist);
        $this->setLocation($location);
        $this->setEventType($eventType);
        $this->setAvailableTickets($availableTickets);
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
