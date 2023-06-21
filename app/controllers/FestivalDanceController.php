<?php

require_once(__DIR__ . "/../services/DanceTicketLinkService.php");

/**
 * @author: Joshua
 */
class FestivalDanceController
{

    const DANCE_ARTIST_PAGE = "/../views/festival/danceartist.php";
    const DANCE_EVENT_PAGE = "/../views/festival/danceevent.php";

    private $ciService;

    public function __construct()
    {
        $this->ciService = new DanceTicketLinkService();
    }

    public function loadArtistPage($uri)
    {
        require_once(__DIR__ . "/../services/ArtistService.php");

        try {
            $artistService = new ArtistService();
            $artist = $artistService->getById(basename($uri));

            if ($artist === null) {
                // redirect to 404
                header("Location: /404");
                return;
            }

            $events = $this->ciService->getAll("time", ["artist" => $artist->getId()]);

            require(__DIR__ . self::DANCE_ARTIST_PAGE);
        } catch (Exception $e) {
            // redirect to 404
            Logger::write($e);
            header("Location: /404");
            return;
        }
    }

    public function loadEventPage($uri)
    {
        try {
            $cartItem = $this->ciService->getByEventId(basename($uri));
            $event = $cartItem->getEvent();

            // if event is of jazzevent type
            if (!($event instanceof DanceEvent)) {
                // redirect to 404
                return;
            }


            $afterThat = $this->ciService->getAll("", [
                "day" => $event->getStartTime()->format('d'),
                "time_from" => $event->getEndTime()->format('H:i'),
                "location" => $event->getLocation()->getLocationId()
            ]);

            require(__DIR__ . self::DANCE_EVENT_PAGE);
        } catch (Exception $e) {
            // redirect to 404
            Logger::write($e);
            header("Location: /404");
            return;
        }
    }
}
