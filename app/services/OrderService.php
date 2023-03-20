<?php
class OrderService{
    private $repository;

    public function __construct()
    {
        $this->repository = new OrderRepository();
    }

    public function getOrderById($id)
    {
        return $this->repository->getOrderById($id);
    }

    public function getOrderHistory($customerId)
    {
        return $this->repository->getOrderHistory($customerId);
    }

    public function getUnpaidOrder($customerId)
    {
        return $this->repository->getUnpaidOrder($customerId);
    }

    public function addTicketToOrder($orderId, $ticketId)
    {
        return $this->repository->addTicketToOrder($orderId, $ticketId);
    }

    public function removeTicketFromOrder($orderId, $ticketId)
    {
        return $this->repository->removeTicketFromOrder($orderId, $ticketId);
    }

    public function generateInvoice($orderId)
    {

    }

}
?>