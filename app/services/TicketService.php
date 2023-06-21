<?php

require_once __DIR__ . '/../repositories/TicketRepository.php';
require_once __DIR__ . '/../models/Ticket/Ticket.php';
require_once(__DIR__ . '/../models/TicketLink.php');
require_once(__DIR__ . '/../models/Exceptions/TicketNotFoundException.php');
require_once(__DIR__ . '/../services/PDFService.php');

require_once(__DIR__ . '../../vendor/autoload.php');

use Dompdf\Dompdf;

require_once('../phpmailer/PHPMailer.php');
require_once('../phpmailer/SMTP.php');
require_once('../phpmailer/Exception.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Writer\PngWriter;


class TicketService
{
  private TicketRepository $repository;

  public function __construct()
  {
    $this->repository = new TicketRepository();
  }

  public function insertTicket($orderId, OrderItem $orderItem, Event $event, $ticketTypeId): Ticket
  {
    try {
      $ticket = $this->repository->insertTicket($orderId, $orderItem, $event, $ticketTypeId);
      return $ticket;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getTicketByID($ticketID): Ticket
  {
    try {
      $ticket = $this->repository->getTicketByID($ticketID);
      return $ticket;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getAllHistoryTickets(Order $order): array
  {
    try {
      $eventType = "history";
      $tickets = $this->repository->getAllTicketsByOrderIdAndEventType($order, $eventType);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getAllJazzTickets(Order $order): array
  {
    try {
      $eventType = "jazz";
      $tickets = $this->repository->getAllTicketsByOrderIdAndEventType($order, $eventType);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getAllYummyTickets(Order $order): array
  {
    try {
      $eventType = "yummy";
      $tickets = $this->repository->getAllTicketsByOrderIdAndEventType($order, $eventType);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getAllDanceTickets(Order $order): array
  {
    try {
      $eventType = "dance";
      $tickets = $this->repository->getAllTicketsByOrderIdAndEventType($order, $eventType);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getAllPasses(Order $order): array
  {
    try {
      $tickets = $this->repository->getAllDayTicketsForPasses($order);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function generateQRCode($ticket): string
  {
    //Generate a QR code image with the ticket ID as data
    require("../Config.php");
    $qrCodeData = $hostname . "/ticket?ticketId=" . $ticket->getTicketId();

    $qrCode = new QrCode($qrCodeData);
    $qrCode->setSize(150);
    $qrCode->setMargin(10);

    $label = Label::create('Ticket QR Code')
      ->setTextColor(new Color(0, 0, 0));

    $writer = new PngWriter();

    $qrCodeImage = 'data:image/png;base64,' . base64_encode($writer->write($qrCode, null, $label)->getString());
    return $qrCodeImage;
  }

  public function generatePDFTicket($tickets, $order, $qrCodeImages): Dompdf
  {
    $pdfService = new PDFService();
    ob_start();
    $html = require_once(__DIR__ . '/../pdfs/ticket-pdf.php');
    $html = ob_get_clean();
    $title = "The Festival Ticket";
    $filename = "ticket_" . $ticket->getTicketId() . ".pdf";

    foreach ($tickets as $ticket) {
      $domPdf = $pdfService->generatePDF($html, $title, $filename);
    }
    return $domPdf;
  }


  public function getAllTicketsAndSend(Order $order)
  {
    try {
      // get all tickets from order
      $tickets = array_merge(
        $this->getAllHistoryTickets($order),
        $this->getAllJazzTickets($order),
        $this->getAllDanceTickets($order),
        $this->getAllPasses($order)
      );

      $qrCodeImages = array();
      foreach ($tickets as $ticket) {
        $qrCodeImage = $this->generateQRCode($ticket);
        $qrCodeImages[] = $qrCodeImage;
      }

      $dompdf = $this->generatePDFTicket($tickets, $order, $qrCodeImages);
      $order->setTickets($tickets);
      $this->sendTicketByEmail($dompdf, $order);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function sendTicketByEmail(Dompdf $dompdf, Order $order)
  {
    try {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->isHTML(true);
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls";
      $mail->Port = 587;

      $mail->Username = "infohaarlemfestival5@gmail.com";
      $mail->Password = 'zznalnrljktsitri';
      $mail->Subject = 'Your Ticket for the The Festival';

      $recipentEmail = $order->getCustomer()->getEmail();
      $name = $order->getCustomer()->getFullName();

      ob_start();
      require_once(__DIR__ . '/../emails/ticket-email.php');
      $mail->Body = ob_get_clean();

      $mail->addAddress($order->getCustomer()->getEmail(), $name);
      // attach pdf to email for each ticket
      foreach ($order->getTickets() as $ticket) {
        $pdfContents = $dompdf->output();
        $mail->addStringAttachment($pdfContents, 'ticket.pdf', 'base64', 'application/pdf');
      }

      if (!$mail->send()) {
        throw new Exception("Email could not be sent");
      }
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function markTicketAsScanned(Ticket $ticket)
  {
    $this->repository->markTicketAsScanned($ticket);
  }


  //TODO: check if obsolete after payment funnel is finished
  public function addTicketToOrder($orderId, $ticketId)
  {

    return $this->repository->addTicketToOrder($orderId, $ticketId);
  }

  //TODO: check if obsolete after payment funnel is finished
  public function removeTicketFromOrder($orderId, $ticketId)
  {

    return $this->repository->removeTicketFromOrder($orderId, $ticketId);
  }
}
