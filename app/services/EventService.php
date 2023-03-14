<?php

require_once(__DIR__ . "/../models/Event.php");
require_once(__DIR__ . "/../models/Music/MusicEvent.php");
require_once(__DIR__ . "/../repositories/EventRepository.php");

class EventService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new EventRepository();
    }

    public function getAllEvents()
    {
        return $this->repo->getAll();
    }

    public function getEventById($id)
    {
        // if is jazz event
        if ($this->repo->isInJazzEvents($id)) {
            return $this->repo->getJazzEventById($id);
        }

        return $this->repo->getEventById($id);
    }

    public function getJazzEvents(): array
    {
        return $this->repo->getAllJazzEvents();
    }

    public function getJazzEventById($id): MusicEvent
    {
        return $this->repo->getJazzEventById($id);
    }

    public function getJazzEventsByArtistId($artistId): array
    {
        return $this->repo->getJazzEventsForArtist($artistId);
    }

    public function addEvent($event): Event
    {
        $id = $this->repo->createEvent(
            $event->getName(),
            $event->getStartTime(),
            $event->getEndTime(),
            $event->getPrice()
        );

        // if event is type of jazzevent
        if ($event instanceof MusicEvent) {
            $this->repo->createJazzEvent(
                $id,
                $event->getArtist()->getId(),
                $event->getLocation()->getLocationId()
            );
        }

        return $this->repo->getJazzEventById($id);
    }
}
