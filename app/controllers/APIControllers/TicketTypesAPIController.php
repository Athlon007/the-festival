<?php

require_once('APIController.php');
require_once(__DIR__ . '/../../services/TicketTypeService.php');

class TicketTypesAPIController extends APIController
{
    private $ttService;

    public function __construct()
    {
        $this->ttService = new TicketTypeService();
    }

    public function handleGetRequest($uri)
    {
        if (is_numeric(basename($uri))) {
            $id = basename($uri);
            $ticketType = $this->ttService->getById($id);
            echo json_encode($ticketType);
        } else {
            $ticketTypes = $this->ttService->getAll();
            echo json_encode($ticketTypes);
        }
    }

    public function handlePostRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $ticketType = new TicketType(0, $data['name'], $data['price'], $data['nrOfPeople']);
        $ticketType = $this->ttService->create($ticketType);
        echo json_encode($ticketType);
    }

    public function handlePutRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $ticketType = new TicketType(basename($uri), $data['name'], $data['price'], $data['nrOfPeople']);
        $ticketType = $this->ttService->update($ticketType);
        echo json_encode($ticketType);
    }

    public function handleDeleteRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }
        $this->ttService->delete(basename($uri));
        $this->sendSuccessMessage('Ticket Type Removed.');
    }
}
