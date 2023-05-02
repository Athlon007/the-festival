<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../repositories/OrderRepository.php');
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../models/Exceptions/OrderNotFoundException.php');
require_once(__DIR__ . '/../repositories/TicketLinkRepository.php');
require_once(__DIR__ . '/../models/TicketLink.php');
require_once(__DIR__ . '/../repositories/TicketRepository.php');
require_once(__DIR__ . '/../services/TicketService.php');
require_once(__DIR__ . '/../services/InvoiceService.php');
require_once(__DIR__ . '/../services/PDFService.php');

class OrderService
{
    private $orderRepository;
    private $ticketLinkRepository;
    private $ticketRepository;
    private $ticketService;
    private $invoiceService;
    private $pdfService;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->ticketLinkRepository = new TicketLinkRepository();
        $this->ticketRepository = new TicketRepository();
        $this->ticketService = new TicketService();
        $this->invoiceService = new InvoiceService();
        $this->pdfService = new PDFService();
    }

    public function getOrderById($id)
    {
        return $this->orderRepository->getOrderById($id);
    }

    public function getOrderHistory($customerId)
    {
        return $this->orderRepository->getOrderHistory($customerId);
    }

    public function getUnpaidOrder($customerId)
    {
        return $this->orderRepository->getUnpaidOrder($customerId);
    }

    //To be called after payment (can't be implemented yet)
    public function createOrder($customer, $ticketLinkIds)
    {
    }

    public function sendInvoiceAndTicketsByEmail($order)
    {
        //Generate and email the tickets
        foreach ($order->getTickets() as $ticket) {
            //Generate a PDF for the ticket and send it by email.
            $qrCode = $this->ticketService->generateQRCode($ticket);
            $dompdf = $this->ticketService->generatePDFTicket($ticket, $qrCode, $order);
            $this->ticketService->sendTicketByEmail($dompdf, $ticket, $order);
        }
        
        //Generate and email the invoice
    }
}
