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

    public function getAllHistoryTicketByOrderId()
    {
        try {
            $order = new Order();
            $order->setOrderId(1);
            $tickets = $this->ticketService->getAllHistoryTicketByOrderId($order);

            $qrCodeImages = array();
            foreach ($tickets as $ticket) {
                $qrCodeImage = $this->ticketService->generateQRCode($ticket);
                $qrCodeImages[] = $qrCodeImage;
            }

            $this->ticketService->generatePDFTicket($tickets, $order, $qrCodeImages);

            return $tickets;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }


}
?>