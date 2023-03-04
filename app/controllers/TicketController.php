<?php
require_once("../services/TicketService.php");

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
            $ticketService->sendTicketPDF();

            require("../views/generateTicketPDF.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}