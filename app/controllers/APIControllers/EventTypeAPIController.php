<?php

require_once('APIController.php');
require_once(__DIR__ . '/../../services/EventTypeService.php');

class EventTypeAPIController extends APIController
{
    private $eventTypeService;

    public function __construct()
    {
        $this->eventTypeService = new EventTypeService();
    }

    public function handleGetRequest($uri)
    {
        $id = basename($uri);
        if (is_numeric($id)) {
            $eventType = $this->eventTypeService->getById($id);
            if ($eventType) {
                echo json_encode($eventType);
            } else {
                $this->sendErrorMessage("Not found", 404);
            }
        } else {
            $eventTypes = $this->eventTypeService->getAll();
            echo json_encode($eventTypes);
        }
    }
}
