<?php

require_once(__DIR__ . '/../../models/Event.php');
require_once(__DIR__ . '/../../models/Music/MusicEvent.php');
require_once(__DIR__ . '/../../services/EventService.php');
require_once(__DIR__ . '/../../services/EventTypeService.php');
require_once(__DIR__ . '/../../services/TicketTypeService.php');
require_once(__DIR__ . '/../../services/FestivalHistoryService.php');
require_once('APIController.php');
require_once(__DIR__ . '/../../models/Types/TicketType.php');
require_once(__DIR__ . '/../../models/TicketLink.php');

require_once(__DIR__ . '/../../services/TicketLinkService.php');
require_once(__DIR__ . '/../../services/JazzTicketLinkService.php');
require_once(__DIR__ . '/../../services/HistoryTicketLinkService.php');
require_once(__DIR__ . '/../../services/PassTicketLinkService.php');

/**
 * @author Konrad
 */
class EventAPIController extends APIController
{
    private $eventService;
    private $ticketTypeService;
    private $eventTypeService;
    private $ticketLinkService;
    private $locationService;

    private $festivalHistoryservice;

    // Music services
    private $artistService;

    public const URI_JAZZ = "/api/events/jazz";
    public const URI_DANCE = "/api/events/dance";
    public const URI_STROLL = "/api/events/stroll";
    public const URI_YUMMY = "/api/events/yummy";
    public const URI_PASSES = "/api/events/passes";

    public function __construct()
    {
        $this->eventService = new EventService();
        $this->ticketTypeService = new TicketTypeService();
        $this->eventTypeService = new EventTypeService();
        $this->festivalHistoryservice = new FestivalHistoryService();

        // Load appropriate TicketLinkService.
        $request = $_SERVER['REQUEST_URI'];
        if (
            str_starts_with($request, EventAPIController::URI_JAZZ)
            || str_starts_with($request, EventAPIController::URI_DANCE)
        ) {
            $this->ticketLinkService = new JazzTicketLinkService();

            // Music Services
            require_once(__DIR__ . '/../../services/ArtistService.php');
            $this->artistService = new ArtistService();

            require_once(__DIR__ . '/../../services/LocationService.php');
            $this->locationService = new LocationService();
        } elseif (str_starts_with($request, EventAPIController::URI_STROLL)) {
            $this->ticketLinkService = new HistoryTicketLinkService();
        } elseif (str_starts_with($request, EventAPIController::URI_PASSES)) {
            $this->ticketLinkService = new PassTicketLinkService();
        } else {
            // Load the generic TicketLinkService.
            $this->ticketLinkService = new TicketLinkService();
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
                echo json_encode($this->ticketLinkService->getByEventId(basename($uri)));
                return;
            }
            echo json_encode($this->ticketLinkService->getAll($sort, $filters));
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

            if (
                str_starts_with($uri, EventAPIController::URI_JAZZ)
                || str_starts_with($uri, EventAPIController::URI_DANCE)
            ) {
                $artist = $this->artistService->getById($data['event']['artist']['id']);
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
            } elseif (str_starts_with($uri, EventAPIController::URI_STROLL)) {
                $guide = $this->festivalHistoryservice->getGuideById($data['guide']);
                $location = $this->locationService->getById($data['location']);
                $availableTickets = $data['available-tickets'];

                $eventType = $this->eventTypeService->getById(3);

                $event = new HistoryEvent(
                    $data['event']['id'],
                    $data['name'],
                    $availableTickets,
                    new DateTime($data['startTime']),
                    new DateTime($data['endTime']),
                    $guide,
                    $location,
                    $eventType
                );
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

                $eventType = $this->eventTypeService->getById($data['event']['eventType']['id']);
                $event->setEventType($eventType);
            }

            $ticketLink = new TicketLink(0, $event, $ticketType);

            $ticketLink = $this->ticketLinkService->add($ticketLink);

            echo json_encode($ticketLink);
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to post event(s).", 500);
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
            $editedTicketLinkID = basename($uri);
            $ticketType = $this->ticketTypeService->getById($data['ticketType']['id']);

            $event = null;

            if (
                str_starts_with($uri, EventAPIController::URI_JAZZ)
                || str_starts_with($uri, EventAPIController::URI_DANCE)
            ) {
                $artist = $this->artistService->getById($data['event']['artist']['id']);
                $location = $this->locationService->getById($data['event']['location']['id']);

                $availableSeats = $location->getCapacity();

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
            } elseif (str_starts_with($uri, EventAPIController::URI_STROLL)) {
                $this->sendErrorMessage('Invalid request', 400);
                return;
            } else {
                // if availableTickets is not set, it is an all access pass.
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

            $ticketLink = new TicketLink($editedTicketLinkID, $event, $ticketType);
            $ticketLink = $this->ticketLinkService->update($ticketLink);

            echo json_encode($ticketLink);
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
            $ci = $this->ticketLinkService->getByEventId($deleteEventId);
            $this->ticketLinkService->delete($ci);

            $ciId = $ci->getId();
            $eventId = $ci->getEvent()->getId();

            $this->sendSuccessMessage("Cart Item $ciId and event $eventId deleted.");
        } catch (Throwable $e) {
            Logger::write($e);
            $this->sendErrorMessage("Unable to delete the event.", 500);
        }
    }
}