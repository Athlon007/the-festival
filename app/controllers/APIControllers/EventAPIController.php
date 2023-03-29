<?php

require_once(__DIR__ . '/../../models/Event.php');
require_once(__DIR__ . '/../../models/Music/MusicEvent.php');
require_once(__DIR__ . '/../../services/EventService.php');
require_once(__DIR__ . '/../../services/CartItemService.php');
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
        $filters = $_GET['filters'] ?? [];
        // htmlspecialchars all the things
        $sort = htmlspecialchars($sort);
        $filters = array_map('htmlspecialchars', $filters);

        $cartItemService = new CartItemService();

        try {
            if (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
                if (isset($_GET['artist'])) {
                    $artistId = $_GET['artist'];
                    echo json_encode($this->service->getJazzEventsByArtistId($artistId));
                    return;
                }

                if (is_numeric(basename($uri))) {
                    $id = basename($uri);
                    $event = $cartItemService->getByEventId($id);
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

                $cartItemService = new CartItemService();

                echo json_encode($cartItemService->getAllJazz($sort, $filters));
            } elseif (str_starts_with($uri, '/api/events/stroll')) {
                require_once(__DIR__ . "/../../services/FestivalHistoryService.php");
                $strollService = new FestivalHistoryService();

                if (is_numeric(basename($uri))) {
                    $id = basename($uri);
                    echo json_encode($event);
                    return;
                }

                if (isset($_GET['date'])) {
                    $filters['date'] = $_GET['date'];
                }

                if (isset($_GET['time'])) {
                    $filters['time'] = $_GET['time'];
                }

                if (isset($_GET['language'])) {
                    $filters['language'] = $_GET['language'];
                }

                if (isset($_GET['ticket_type'])) {
                    $filters['ticket_type'] = $_GET['ticket_type'];
                }
                echo json_encode($strollService->getAllHistoryEvents());
            } else {
                if (is_numeric(basename($uri))) {
                    $id = basename($uri);
                    $event = $cartItemService->getByEventId($id);
                    if ($event == null) {
                        $this->sendErrorMessage("Event with id $id not found", 404);
                        return;
                    }
                    echo json_encode($event);
                    return;
                }

                echo json_encode($cartItemService->getAll());
            }
        } catch (TypeError $e) {
            $this->sendErrorMessage("Event not found", 404);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled exception: " . $e->getMessage(), 500);
        }
    }

    public function handlePostRequest($uri)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            if (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
                require_once(__DIR__ . '/../../services/JazzArtistService.php');
                $artistService = new JazzArtistService();
                $artist = $artistService->getById($data['artist']['artistId']);

                require_once(__DIR__ . '/../../services/LocationService.php');
                $locationService = new LocationService();
                $location = $locationService->getById($data['location']['locationId']);

                $event = new MusicEvent(
                    null,
                    $data['name'],
                    new DateTime($data['startTime']),
                    new DateTime($data['endTime']),
                    $artist,
                    $location
                );

                try {
                    $event = $this->service->addEvent($event);

                    echo json_encode($event);
                } catch (Exception $e) {
                    $this->sendErrorMessage($e->getMessage());
                }
            } elseif (str_starts_with($uri, '/api/events/stroll')) {
            } else {
                $this->sendErrorMessage('Invalid request', 400);
            }
        } catch (InvalidVariableException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled exception", 500);
        }
    }

    public function handlePutRequest($uri)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $editedEventId = basename($uri);

            if (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
                require_once(__DIR__ . '/../../services/JazzArtistService.php');
                $artistService = new JazzArtistService();
                $artist = $artistService->getById($data['artist']['artistId']);

                require_once(__DIR__ . '/../../services/LocationService.php');
                $locationService = new LocationService();
                $location = $locationService->getById($data['location']['locationId']);

                $event = new MusicEvent(
                    $editedEventId,
                    $data['name'],
                    new DateTime($data['startTime']),
                    new DateTime($data['endTime']),
                    $artist,
                    $location
                );

                $event = $this->service->editEvent($event);
                echo json_encode($event);
            } elseif (str_starts_with($uri, '/api/events/stroll')) {
            } else {
                $this->sendErrorMessage('Invalid request', 400);
            }
        } catch (InvalidVariableException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled Exception", 500);
        }
    }

    public function handleDeleteRequest($uri)
    {
        try {
            $deletedEventId = basename($uri);

            $this->service->deleteEvent($deletedEventId);

            $this->sendSuccessMessage("Event with id $deletedEventId deleted", 200);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled exception", 500);
        }
    }
}
