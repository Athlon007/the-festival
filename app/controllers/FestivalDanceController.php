<?php
require_once(__DIR__ . "/../services/DanceTicketLinkService.php");

class FestivalDanceController
{
    const DANCE_ARTIST_PAGE = "/../views/festival/danceartist.php";
    const DANCE_EVENT_PAGE = "/../views/festival/danceevent.php";

    private $ticketLinkService;

    public function __construct()
    {
        $this->ticketLinkService = new DanceTicketLinkService();
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

            require(__DIR__ . self::DANCE_ARTIST_PAGE);
        } catch (Throwable $e) {
            // redirect to 404
            Logger::write($e);
            header("Location: /404");
            return;
        }
    }

    public function loadEventPage($uri)
    {
        try {
            $ticketlink = $this->ticketLinkService->getByEventId(basename($uri));
            $event = $ticketlink->getEvent();

            // if event is not of dance event type
            if (!($event instanceof DanceEvent)) {
                // redirect to 404
                header("Location: /404");
                return;
            }

            require(__DIR__ . self::DANCE_EVENT_PAGE);
        } catch (Throwable $e) {
            // redirect to 404
            Logger::write($e);
            header("Location: /404");
            return;
        }
    }
}
