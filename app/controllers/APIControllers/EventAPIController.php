<?php

use function PHPSTORM_META\map;

require_once(__DIR__ . '/../../models/Event.php');
require_once(__DIR__ . '/../../models/Music/MusicEvent.php');
require_once(__DIR__ . '/../../services/EventService.php');
require_once(__DIR__ . '/../../services/EventTypeService.php');
require_once(__DIR__ . '/../../services/TicketTypeService.php');
require_once("APIController.php");
require_once(__DIR__ . '/../../models/Types/TicketType.php');
require_once(__DIR__ . '/../../models/CartItem.php');

require_once(__DIR__ . '/../../services/CartItemService.php');
require_once(__DIR__ . '/../../services/JazzCartItemService.php');
require_once(__DIR__ . '/../../services/HistoryCartItemService.php');
require_once(__DIR__ . '/../../services/PassCartItemService.php');

class EventAPIController extends APIController
{
    private $service;
    private $ticketTypeService;
    private $eventTypeService;

    public function __construct()
    {
        $this->service = new EventService();
        $this->ticketTypeService = new TicketTypeService();
        $this->eventTypeService = new EventTypeService();
    }

    public function handleGetRequest($uri)
    {
        $sort = $_GET['sort'] ?? 'time';
        $filters = isset($_GET) ? $_GET : [];

        // remove the 'sort' from filters
        unset($filters['sort']);

        // htmlspecialchars all the things
        $sort = htmlspecialchars($sort);
        $filters = array_map('htmlspecialchars', $filters);

        $cartItemService = new CartItemService();

        try {
            if (str_starts_with($uri, '/api/events/dates')) {
                $eventService = new EventService();
                $dates = $eventService->getFestivalDates();
                echo json_encode($dates);
            } elseif (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
                if (isset($_GET['artist'])) {
                    $artistId = $_GET['artist'];
                    echo json_encode($this->service->getJazzEventsByArtistId($artistId));
                    return;
                }

                $cartItemService = new JazzCartItemService();

                if (is_numeric(basename($uri))) {
                    echo json_encode($cartItemService->getByEventId(basename($uri)));
                    return;
                }

                // Get the appropriate kind, or all artists if none is specified.
                if (str_starts_with($uri, '/api/events/jazz')) {
                    $filters['artist_kind'] = '1';
                } elseif (str_starts_with($uri, '/api/events/dance')) {
                    $filters['artist_kind'] = '2';
                }

                echo json_encode($cartItemService->getAll($sort, $filters));
            } elseif (str_starts_with($uri, '/api/events/stroll')) {
                $cartItemService = new HistoryCartItemService();

                if (is_numeric(basename($uri))) {
                    $id = basename($uri);
                    echo json_encode($cartItemService->getById($id));
                    return;
                }

                echo json_encode($cartItemService->getAll($filters));
            } elseif (str_starts_with($uri, '/api/events/passes')) {
                $cartItemService = new PassCartItemService();
                if (is_numeric(basename($uri))) {
                    echo json_encode($cartItemService->getById(basename($uri)));
                    return;
                }
                echo json_encode($cartItemService->getAll($filters));
            } else {
                if (is_numeric(basename($uri))) {
                    echo json_encode($cartItemService->getByEventId(basename($uri)));
                    return;
                }
                echo json_encode($cartItemService->getAll());
            }
        } catch (TypeError $e) {
            $this->sendErrorMessage("Event not found. " . $e->getMessage(), 404);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled exception: " . $e->getMessage() . "\r\n" . $e->getTraceAsString(), 500);
        }
    }

    public function handlePostRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $ticketType = $this->ticketTypeService->getById($data['ticketType']['id']);

            $event = null;
            $cartItemService = new CartItemService();

            if (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
                $cartItemService = new JazzCartItemService();
                require_once(__DIR__ . '/../../services/JazzArtistService.php');
                $artistService = new JazzArtistService();
                $artist = $artistService->getById($data['event']['artist']['id']);

                require_once(__DIR__ . '/../../services/LocationService.php');
                $locationService = new LocationService();
                $location = $locationService->getById($data['event']['location']['id']);

                // In terms of music events, the capacity is the number of available seats.
                $availableSeats = $location->getCapacity();

                require_once(__DIR__ . '/../../services/EventTypeService.php');
                $eventTypeService = new EventTypeService();
                $eventType = $eventTypeService->getById($data['event']['eventType']['id']);

                $event = new MusicEvent(
                    $data['event']['id'],
                    $data['event']['name'],
                    new DateTime($data['event']['startTime']),
                    new DateTime($data['event']['endTime']),
                    $artist,
                    $location,
                    $eventType,
                    $availableSeats,
                );
            } elseif (str_starts_with($uri, '/api/events/stroll')) {
            } else {
                // if availableTickets is not set, it is a pass.
                if (isset($data['event']['availableTickets'])) {
                    $this->sendErrorMessage('Invalid request', 400);
                    return;
                }

                $event = new Event();
                $event->setId($data['event']['id']);
                $event->setName($data['event']['name']);
                $event->setStartTime(new DateTime($data['event']['startTime']));
                $event->setEndTime(new DateTime($data['event']['endTime']));

                $eventType = null;
                if (isset($data['event']['eventType'])) {
                    $eventType = $this->eventTypeService->getById($data['event']['eventType']['id']);
                }

                $event->setEventType($eventType);
            }

            $cartItem = new CartItem(0, $event, $ticketType);

            $cartItem = $cartItemService->add($cartItem);

            echo json_encode($cartItem);
        } catch (InvalidVariableException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled exception. " . $e->getMessage() . "\r\n\r\n" . $e->getTraceAsString(), 500);
        }
    }

    public function handlePutRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $editedCartItemID = basename($uri);
            $ticketType = $this->ticketTypeService->getById($data['ticketType']['id']);

            $event = null;

            $cartItemService = new CartItemService();

            if (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
                $cartItemService = new JazzCartItemService();
                require_once(__DIR__ . '/../../services/JazzArtistService.php');
                $artistService = new JazzArtistService();
                $artist = $artistService->getById($data['event']['artist']['id']);

                require_once(__DIR__ . '/../../services/LocationService.php');
                $locationService = new LocationService();
                $location = $locationService->getById($data['event']['location']['id']);

                $availableSeats = null;
                if (isset($data['event']['availableSeats'])) {
                    $availableSeats = $data['event']['availableSeats'];
                }

                require_once(__DIR__ . '/../../services/EventTypeService.php');
                $eventTypeService = new EventTypeService();
                $eventType = $eventTypeService->getById($data['event']['eventType']['id']);

                $event = new MusicEvent(
                    basename($uri),
                    $data['event']['name'],
                    new DateTime($data['event']['startTime']),
                    new DateTime($data['event']['endTime']),
                    $artist,
                    $location,
                    $eventType,
                    $availableSeats
                );
            } elseif (str_starts_with($uri, '/api/events/stroll')) {
            } else {
                // if availableTickets is not set, it is a pass.
                if (isset($data['event']['availableTickets'])) {
                    $this->sendErrorMessage('Invalid request', 400);
                    return;
                }

                $event = new Event();
                $event->setId(basename($uri));
                $event->setName($data['event']['name']);
                $event->setStartTime(new DateTime($data['event']['startTime']));
                $event->setEndTime(new DateTime($data['event']['endTime']));

                $eventType = null;
                if (isset($data['event']['eventType'])) {
                    $eventType = new EventType(
                        $data['event']['eventType']['id'],
                        $data['event']['eventType']['name'],
                        $data['event']['eventType']['vat']
                    );
                }

                $event->setEventType($eventType);
            }

            $cartItem = new CartItem($data["id"], $event, $ticketType);

            $cartItem = $cartItemService->updateCartItem($cartItem);

            echo json_encode($cartItem);
        } catch (InvalidVariableException $e) {
            $this->sendErrorMessage($e->getMessage(), 400);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled Exception. " . $e->getMessage(), 500);
        }
    }

    public function handleDeleteRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }

        try {
            $deleteEventId = basename($uri);
            $cartItemService = new CartItemService();
            $ci = $cartItemService->getByEventId($deleteEventId);
            $cartItemService->deleteCartItem($ci);

            $ciId = $ci->getId();
            $eventId = $ci->getEvent()->getId();

            $this->sendSuccessMessage("Cart Item $ciId and event $eventId deleted.", 200);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled exception. " . $e->getMessage() . " " . $e->getTraceAsString(), 500);
        }
    }
}
