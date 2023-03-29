<?php

require_once(__DIR__ . '/../repositories/TicketTypeRepository.php');
require_once(__DIR__ . '/../models/Types/TicketType.php');

class TicketTypeService
{
    private $ticketTypeRepository;

    public function __construct()
    {
        $this->ticketTypeRepository = new TicketTypeRepository();
    }

    public function getAll(): array
    {
        return $this->ticketTypeRepository->getAll();
    }

    public function getById($id): TicketType
    {
        return $this->ticketTypeRepository->getById($id);
    }

    public function create(TicketType $ticketType): TicketType
    {
        $name = htmlspecialchars($ticketType->getName());
        $price = htmlspecialchars($ticketType->getPrice());
        $nrOfPeople = htmlspecialchars($ticketType->getNrOfPeople());

        $id = $this->ticketTypeRepository->createTicketType($name, $price, $nrOfPeople);
        return $this->getById($id);
    }

    public function update(TicketType $ticketType): TicketType
    {
        $id = htmlspecialchars($ticketType->getId());
        $name = htmlspecialchars($ticketType->getName());
        $price = htmlspecialchars($ticketType->getPrice());
        $nrOfPeople = htmlspecialchars($ticketType->getNrOfPeople());

        $this->ticketTypeRepository->updateTicketType($id, $name, $price, $nrOfPeople);
        return $this->getById($id);
    }

    public function delete($id)
    {
        $this->ticketTypeRepository->deleteById($id);
    }
}
