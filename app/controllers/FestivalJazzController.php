<?php

class FestivalJazzController
{
    const JAZZ_ARTIST_PAGE = "/../views/festival/jazzartist.php";
    const JAZZ_EVENT_PAGE = "/../views/festival/jazzevent.php";

    public function loadArtistPage($uri)
    {
        require_once(__DIR__ . "/../services/JazzArtistService.php");
        require_once(__DIR__ . "/../services/EventService.php");

        $artistService = new JazzArtistService();
        $artist = $artistService->getById(basename($uri));

        $eventService = new EventService();
        $events = $eventService->getJazzEventsByArtistId($artist->getId());


        require(__DIR__ . self::JAZZ_ARTIST_PAGE);
    }

    public function loadEventPage($uri)
    {
        require_once(__DIR__ . "/../services/EventService.php");

        $eventService = new EventService();
        $event = $eventService->getEventById(basename($uri));

        // if event is of jazzevent type
        if (!($event instanceof MusicEvent)) {
            // redirect to 404
            return;
        }

        $afterThat = $eventService->getJazzEvents("", [
            "day" => $event->getStartTime()->format('d'),
            "time_from" => $event->getEndTime()->format('H:i'),
            "location" => $event->getLocation()->getLocationId()
        ]);

        require(__DIR__ . self::JAZZ_EVENT_PAGE);
    }
}
