<?php

class FestivalJazzController
{
    const JAZZ_ARTIST_PAGE = "/../views/festival/jazzartist.php";
    const JAZZ_EVENT_PAGE = "/../views/festival/jazzevent.php";

    public function loadArtistPage($uri)
    {
        require_once(__DIR__ . "/../services/JazzArtistService.php");

        $artistService = new JazzArtistService();
        $artist = $artistService->getById(basename($uri));

        if ($artist === null) {
            // redirect to 404
            header("Location: /404");
            return;
        }

        require_once(__DIR__ . "/../services/CartItemService.php");
        $ciService = new CartItemService();
        $events = $ciService->getAllJazz("time", ["artist" => $artist->getId()]);


        require(__DIR__ . self::JAZZ_ARTIST_PAGE);
    }

    public function loadEventPage($uri)
    {
        require_once(__DIR__ . "/../services/CartItemService.php");

        $eventService = new CartItemService();
        $cartItem = $eventService->getByEventId(basename($uri));
        $event = $cartItem->getEvent();

        // if event is of jazzevent type
        if (!($event instanceof MusicEvent)) {
            // redirect to 404
            return;
        }


        $afterThat = $eventService->getAllJazz("", [
            "day" => $event->getStartTime()->format('d'),
            "time_from" => $event->getEndTime()->format('H:i'),
            "location" => $event->getLocation()->getLocationId()
        ]);

        require(__DIR__ . self::JAZZ_EVENT_PAGE);
    }
}
