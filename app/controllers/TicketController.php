<?php
require_once("../services/TicketService.php");

require_once(__DIR__ . '/../vendor/autoload.php');


class TicketController
{
    public function buyTicket()
    {
        try {
            require("../views/buyTicket.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function generateAndSendTicket()
    {
        try {
            $ticketService = new TicketService();
            $ticket = $ticketService->getTicketByID(1);
            $qrCodeImage = $ticketService->generateQRCode($ticket);
            $dompdf = $ticketService->generatePDFTicket($ticket, $qrCodeImage);
            //$ticketService->sendTicketByEmail($dompdf, $ticket);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}