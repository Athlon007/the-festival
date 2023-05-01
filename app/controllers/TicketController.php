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

    public function getAllHistoryTicket()
    {
        try {
            $order = new Order();
            $order->setOrderId(1);
            $tickets = $this->ticketService->getAllHistoryTickets($order);

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

    public function getAllJazzTickets()
    {
        try {
            $order = new Order();
            $order->setOrderId(2);
            $tickets = $this->ticketService->getAllJazzTickets($order);

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

    public function markTicketAsScanned()
    {
        try {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['user'])) {
                header("Location: /");
            }

            $user = unserialize($_SESSION['user']);
            if ($user->getUserTypeAsString() != "Employee") {
                header("Location: /");
                return;
            }

            if (isset($_SESSION['user'])) {
                $ticketId = $_GET['ticketId'];
                $ticket = $this->ticketService->getTicketByID($ticketId);

                $this->ticketService->markTicketAsScanned($ticket);
                require_once("../views/employee/ticketScan.php");

                if ($ticket->getIsScanned() == 1) {
                    echo "<script>alert('Ticket is already scanned!')</script>";
                } else {
                    echo "<script>alert('Ticket is scanned!')</script>";
                }
                return $ticket;
            } else {
                header("Location: /");
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}
?>