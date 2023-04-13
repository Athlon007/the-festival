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
    private $eventService;
    private $ticketTypeService;
    private $eventTypeService;
    private $cartItemService;
    private $locationService;

    // Jazz Services
    private $jazzArtistService;

    public const URI_JAZZ = "/api/events/jazz";
    public const URI_DANCE = "/api/events/dance";

    public function __construct()
    {
        $this->eventService = new EventService();
        $this->ticketTypeService = new TicketTypeService();
        $this->eventTypeService = new EventTypeService();
        $this->cartItemService = new CartItemService();

        $request = $_SERVER['REQUEST_URI'];

        if (
            str_starts_with($request, EventAPIController::URI_JAZZ)
            || str_starts_with($request, EventAPIController::URI_DANCE)
        ) {
            $this->cartItemService = new JazzCartItemService();

            require_once(__DIR__ . '/../../services/JazzArtistService.php');
            $this->jazzArtistService = new JazzArtistService();

            require_once(__DIR__ . '/../../services/LocationService.php');
            $this->locationService = new LocationService();
        } elseif (str_starts_with($request, "/api/events/stroll")) {
            $this->cartItemService = new HistoryCartItemService();
        } elseif (str_starts_with($request, "/api/events/passes")) {
            $this->cartItemService = new PassCartItemService();
        }
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

        try {
            if (str_starts_with($uri, '/api/events/dates')) {
                $dates = $this->eventService->getFestivalDates();
                echo json_encode($dates);
                return;
            } elseif (
                str_starts_with($uri, EventAPIController::URI_JAZZ)
                || str_starts_with($uri, EventAPIController::URI_DANCE)
            ) {
                if (isset($_GET['artist'])) {
                    $artistId = $_GET['artist'];
                    echo json_encode($this->eventService->getJazzEventsByArtistId($artistId));
                    return;
                }

                // Get the appropriate kind, or all artists if none is specified.
                if (str_starts_with($uri, EventAPIController::URI_JAZZ)) {
                    $filters['artist_kind'] = '1';
                } elseif (str_starts_with($uri, EventAPIController::URI_DANCE)) {
                    $filters['artist_kind'] = '2';
                }
            }

            if (is_numeric(basename($uri))) {
                echo json_encode($this->cartItemService->getByEventId(basename($uri)));
                return;
            }
            echo json_encode($this->cartItemService->getAll($sort, $filters));
        } catch (ObjectNotFoundException $e) {
            $this->sendErrorMessage("Event with given ID not found.", 404);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to retrieve events.", 500);
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

            if (str_starts_with($uri, EventAPIController::URI_JAZZ) || str_starts_with($uri, '/api/events/dance')) {
                $artist = $this->jazzArtistService->getById($data['event']['artist']['id']);
                $location = $this->locationService->getById($data['event']['location']['id']);

                // In terms of music events, the capacity is the number of available seats.
                $availableSeats = $location->getCapacity();

                $eventType = $this->eventTypeService->getById($data['event']['eventType']['id']);

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
                $this->sendErrorMessage('Invalid request', 400);
                return;
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

            $cartItem = $this->cartItemService->add($cartItem);

            echo json_encode($cartItem);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to retrive event(s).", 500);
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

            if (
                str_starts_with($uri, EventAPIController::URI_JAZZ)
                || str_starts_with($uri, EventAPIController::URI_DANCE)
            ) {
                $artist = $this->jazzArtistService->getById($data['event']['artist']['id']);
                $location = $this->locationService->getById($data['event']['location']['id']);

                $availableSeats = null;
                if (isset($data['event']['availableSeats'])) {
                    $availableSeats = $data['event']['availableSeats'];
                }

                $eventType = $this->eventTypeService->getById($data['event']['eventType']['id']);

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
                $this->sendErrorMessage('Invalid request', 400);
                return;
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

            $cartItem = new CartItem($editedCartItemID, $event, $ticketType);
            $cartItem = $this->cartItemService->updateCartItem($cartItem);

            echo json_encode($cartItem);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to edit event.", 500);
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
            $ci = $this->cartItemService->getByEventId($deleteEventId);
            $this->cartItemService->deleteCartItem($ci);

            $ciId = $ci->getId();
            $eventId = $ci->getEvent()->getId();

            $this->sendSuccessMessage("Cart Item $ciId and event $eventId deleted.", 200);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to delete the event.", 500);
        }
    }
}
