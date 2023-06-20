<?php

require_once("TicketLinkService.php");
require_once(__DIR__ . "/../repositories/HistoryTicketLinkRepository.php");
require_once("LocationService.php");

class HistoryTicketLinkService extends TicketLinkService
{
    private $locationService;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new HistoryTicketLinkRepository();
        $this->locationService = new LocationService();
    }

    public function getAll($sort = null, $filters = []): array
    {
        $links = $this->repo->getAll($sort, $filters);
        foreach ($links as $link) {
            $locationId = $this->repo->getLocationIdFromEventId($link->getEvent()->getId());
            $link->getEvent()->setLocation($this->locationService->getById($locationId));
        }
        return $links;
    }

    public function getById(int $id): TicketLink
    {
        $ticketLink = $this->repo->getById($id);
        $locationId = $this->repo->getLocationIdFromEventId($ticketLink->getEvent()->getId());
        $ticketLink->getEvent()->setLocation($this->locationService->getById($locationId));
        return $ticketLink;
    }

    public function getByEventId(int $id): TicketLink
    {
        $item = $this->repo->getByEventId($id);
        if ($item == null) {
            throw new Exception("TicketLink not found");
        }
        $locationId = $this->repo->getLocationIdFromEventId($item->getEvent()->getId());
        $item->getEvent()->setLocation($this->locationService->getById($locationId));
        return $item;
    }
}
