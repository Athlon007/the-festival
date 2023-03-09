<?php

class FestivalJazzController
{
    const JAZZ_ARTIST_PAGE = "/../views/festival/jazzartist.php";

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
}
