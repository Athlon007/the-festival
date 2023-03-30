<?php

require_once(__DIR__ . "/../models/Event.php");
require_once(__DIR__ . "/../models/Music/MusicEvent.php");
require_once(__DIR__ . "/../repositories/EventRepository.php");
require_once(__DIR__ . "/../models/Exceptions/InvalidVariableException.php");
require_once('EventTypeService.php');

class EventService
{
    private $repo;
    private $eventTypeService;

    public function __construct()
    {
        $this->repo = new EventRepository();
        $this->eventTypeService = new EventTypeService();
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

        // if is history event
        if ($this->repo->isInHistoryEvents($id)) {
            return $this->repo->getHistoryEventById($id);
        }

        return $this->repo->getEventById($id);
    }

    public function getJazzEvents($sort, $filters): array
    {
        $sort = htmlspecialchars($sort);
        $filters = array_map('htmlspecialchars', $filters);

        return $this->repo->getAllJazzEvents($sort, $filters);
    }

    public function getJazzEventById($id): MusicEvent
    {
        $id = htmlspecialchars($id);
        return $this->repo->getJazzEventById($id);
    }

    public function getJazzEventsByArtistId($artistId): array
    {
        $artistId = htmlspecialchars($artistId);
        return $this->repo->getJazzEventsForArtist($artistId);
    }

    public function addEvent($event): Event
    {
        $event->setName(htmlspecialchars($event->getName()));

        if ($event->getStartTime() > $event->getEndTime()) {
            throw new InvalidVariableException("Start time cannot be after end time");
        }

        // get id of event type
        $eventTypeId = $event->getEventType()->getId();

        $id = $this->repo->createEvent(
            $event->getName(),
            $event->getStartTime(),
            $event->getEndTime(),
            $eventTypeId
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

    public function editEvent($event): Event
    {
        $event->setName(htmlspecialchars($event->getName()));

        if ($event->getStartTime() > $event->getEndTime()) {
            throw new InvalidVariableException("Start time cannot be after end time");
        }

        $eventTypeId = $event->getEventType()->getId();

        $this->repo->updateEvent(
            $event->getId(),
            $event->getName(),
            $event->getStartTime(),
            $event->getEndTime(),
            $eventTypeId
        );

        // if event is type of jazzevent
        if ($event instanceof MusicEvent) {
            $this->repo->updateJazzEvent(
                $event->getId(),
                $event->getArtist()->getId(),
                $event->getLocation()->getLocationId()
            );
        }

        return $this->repo->getEventById($event->getId());
    }

    public function deleteEvent($id)
    {
        $id = htmlspecialchars($id);
        $this->repo->deleteById($id);
    }

    public function getFestivalDates()
    {
        return $this->repo->getFestivalDates();
    }
}
