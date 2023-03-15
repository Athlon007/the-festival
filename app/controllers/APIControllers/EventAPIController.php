<?php

require_once(__DIR__ . '/../../models/Event.php');
require_once(__DIR__ . '/../../models/Jazz/JazzEvent.php');
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
        if (str_starts_with($uri, '/api/events/jazz')) {
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

            echo json_encode($this->service->getJazzEvents());
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

            $event = new JazzEvent(
                null,
                $data['name'],
                new DateTime($data['startTime']),
                new DateTime($data['endTime']),
                $data['price'],
                $artist,
                $location
            );

            $this->service->addEvent($event);
        } else {
            $this->sendErrorMessage('Invalid request', 400);
        }
    }
}
