<?php
require_once(__DIR__ . "/../repositories/DanceTicketLinkRepository.php");
class DanceTicketLinkService extends TicketLinkService
{
    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new DanceTicketLinkRepository();
    }

    public function getAll($sort = null, $filters = []): array
    {
        return $this->repository->getAll($sort, $filters);
    }

    public function getById(int $id): ?TicketLink
    {
        return $this->repository->getById($id);
    }

    public function getByEventId(int $id): ?TicketLink
    {
        return $this->repository->getByEventId($id);
    }
}