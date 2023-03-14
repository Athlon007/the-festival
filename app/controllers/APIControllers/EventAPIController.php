<?php

require_once(__DIR__ . '/../../models/Event.php');
require_once(__DIR__ . '/../../models/Music/MusicEvent.php');
require_once(__DIR__ . '/../../services/EventService.php');
require_once("APIController.php");

class EventAPIController extends APIController
{
    private $service;

    public function __construct()
    {
        $this->service = new EventService();
    }

    public function handleGetRequest($uri)
    {
        $sort = $_GET['sort'] ?? 'time';
        $filters = [];

        if (isset($_GET['time_from'])) {
            $filters['time_from'] = $_GET['time_from'];
        }
        if (isset($_GET['time_to'])) {
            $filters['time_to'] = $_GET['time_to'];
        }

        if (isset($_GET['price_from'])) {
            $filters['price_from'] = $_GET['price_from'];
        }
        if (isset($_GET['price_to'])) {
            $filters['price_to'] = $_GET['price_to'];
        }

        if (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
            if (isset($_GET['artist'])) {
                $artistId = $_GET['artist'];
                echo json_encode($this->service->getJazzEventsByArtistId($artistId));
                return;
            }

            if (is_numeric(basename($uri))) {
                $id = basename($uri);
                $event = $this->service->getJazzEventById($id);
                echo json_encode($event);
                return;
            }

            if (isset($_GET['hide_no_seats'])) {
                $filters['hide_no_seats'] = $_GET['hide_no_seats'];
            }

            // Get the appropriate kind, or all artists if none is specified.
            if (str_starts_with($uri, '/api/events/jazz')) {
                $filters['artist_kind'] = 'jazz';
            } elseif (str_starts_with($uri, '/api/events/dance')) {
                $filters['artist_kind'] = 'dance';
            }

            echo json_encode($this->service->getJazzEvents($sort, $filters));
        } else {
            if (is_numeric(basename($uri))) {
                $id = basename($uri);
                $event = $this->service->getEventById($id);
                echo json_encode($event);
                return;
            }

            echo json_encode($this->service->getAllEvents());
        }
    }

    public function handlePostRequest($uri)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (str_starts_with($uri, '/api/events/jazz')) {
            $artistId = basename($uri);
            require_once(__DIR__ . '/../../services/JazzArtistService.php');
            $artistService = new JazzArtistService();
            $artist = $artistService->getById($artistId);

            require_once(__DIR__ . '/../../services/LocationService.php');
            $locationService = new LocationService();
            $location = $locationService->getById($data['location']['locationId']);

            $event = new MusicEvent(
                null,
                $data['name'],
                new DateTime($data['startTime']),
                new DateTime($data['endTime']),
                $data['price'],
                $artist,
                $location
            );

            $event = $this->service->addEvent($event);

            echo json_encode($event);
        } else {
            $this->sendErrorMessage('Invalid request', 400);
        }
    }
}
