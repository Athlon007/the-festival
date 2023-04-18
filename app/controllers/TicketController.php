<?php
require_once("../services/TicketService.php");
/**
 * @author Vedat
 */

class TicketController
{
    private $ticketService;

    public function __construct()
    {
        $this->ticketService = new TicketService();
    }

    public function getAllHistoryTicketByOrderId(){
        try {
            $order = new Order();
            $order->setOrderId(1);
            $tickets = $this->ticketService->getAllHistoryTicketByOrderId($order);
            foreach ($tickets as $ticket) {
                $qrCodeImage = $this->ticketService->generateQRCode($ticket);
                $domPdf = $this->ticketService->generatePDFTicket($ticket, $qrCodeImage,$order);
                $this->ticketService->sendTicketByEmail($domPdf, $ticket, $order);
            }
            return $tickets;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}
?>