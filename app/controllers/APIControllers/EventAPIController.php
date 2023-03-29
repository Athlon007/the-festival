<?php

require_once(__DIR__ . '/../../models/Event.php');
require_once(__DIR__ . '/../../models/Music/MusicEvent.php');
require_once(__DIR__ . '/../../services/EventService.php');
require_once(__DIR__ . '/../../services/CartItemService.php');
require_once("APIController.php");
require_once(__DIR__ . '/../../models/Types/TicketType.php');
require_once(__DIR__ . '/../../models/CartItem.php');

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
                //require_once(__DIR__ . "/../../services/FestivalHistoryService.php");
                //$strollService = new FestivalHistoryService();

                $cartItemService = new CartItemService();

                if (is_numeric(basename($uri))) {
                    $id = basename($uri);
                    echo json_encode($cartItemService->getById($id));
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
                echo json_encode($cartItemService->getAllHistory($sort, $filters));
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
            $ticketType = new TicketType(
                $data['ticketType']['id'],
                $data['ticketType']['name'],
                $data['ticketType']['price'],
                $data['ticketType']['maxTickets'],
            );

            $event = null;

            if (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
                require_once(__DIR__ . '/../../services/JazzArtistService.php');
                $artistService = new JazzArtistService();
                $artist = $artistService->getById($data['event']['artist']['id']);

                require_once(__DIR__ . '/../../services/LocationService.php');
                $locationService = new LocationService();
                $location = $locationService->getById($data['event']['location']['id']);

                $event = new MusicEvent(
                    $data['event']['id'],
                    $data['event']['name'],
                    new DateTime($data['event']['startTime']),
                    new DateTime($data['event']['endTime']),
                    $artist,
                    $location
                );
            } elseif (str_starts_with($uri, '/api/events/stroll')) {
            } else {
                $this->sendErrorMessage('Invalid request', 400);
                return;
            }

            $cartItem = new CartItem(0, $event, $ticketType);
            $cartItemService = new CartItemService();
            $cartItem = $cartItemService->add($cartItem);

            echo json_encode($cartItem);
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
            $editedCartItemID = basename($uri);
            $ticketType = new TicketType(
                $data['ticketType']['id'],
                $data['ticketType']['name'],
                $data['ticketType']['price'],
                $data['ticketType']['maxTickets'],
            );

            $event = null;

            if (str_starts_with($uri, '/api/events/jazz') || str_starts_with($uri, '/api/events/dance')) {
                require_once(__DIR__ . '/../../services/JazzArtistService.php');
                $artistService = new JazzArtistService();
                $artist = $artistService->getById($data['event']['artist']['id']);

                require_once(__DIR__ . '/../../services/LocationService.php');
                $locationService = new LocationService();
                $location = $locationService->getById($data['event']['location']['id']);

                $event = new MusicEvent(
                    $data['event']['id'],
                    $data['event']['name'],
                    new DateTime($data['event']['startTime']),
                    new DateTime($data['event']['endTime']),
                    $artist,
                    $location
                );
            } elseif (str_starts_with($uri, '/api/events/stroll')) {
            } else {
                $this->sendErrorMessage('Invalid request', 400);
                return;
            }

            $cartItem = new CartItem($editedCartItemID, $event, $ticketType);

            $cartItemService = new CartItemService();
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
        try {
            $deletedCartItemId = basename($uri);
            $cartItemService = new CartItemService();
            $ci = $cartItemService->getById($deletedCartItemId);
            $cartItemService->deleteCartItem($ci);

            $eventId = $ci->getEvent()->getId();

            $this->sendSuccessMessage("Cart Item with id $deletedCartItemId and event id $eventId deleted", 200);
        } catch (Throwable $e) {
            $this->sendErrorMessage("Unhandled exception", 500);
        }
    }
}
