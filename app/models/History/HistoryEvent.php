<?php

require_once("../models/Guide.php");
require_once("../models/Location.php");
require_once("../models/Event.php");

class HistoryEvent extends Event implements JsonSerializable {
    private Guide $guide;
    private Location $location;

    public function __construct($id, $name, DateTime $startTime, DateTime $endTime, $price, Guide $guide, Location $location) {
        $this->setId($id);
        $this->setName($name);
        $this->setStartTime($startTime);
        $this->setEndTime($endTime);
        $this->setPrice($price);
        $this->guide = $guide;
        $this->location = $location;
    }

    public function getGuide(): Guide {
        return $this->guide;
    }

    public function setGuide(Guide $value) {
        $this->guide = $value;
    }

    public function getLocation(): Location {
        return $this->location;
    }

    public function setLocation(Location $value) {
        $this->location = $value;
    }

    public function jsonSerialize(): mixed {
        return array_merge(parent::jsonSerialize(), [
            'guide' => $this->getGuide(),
            'location' => $this->getLocation()
        ]);
    }


}