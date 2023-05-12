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
  protected TicketRepository $repository;

  public function __construct()
  {
    $this->repository = new TicketRepository();
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

  public function getAllHistoryTickets(Order $order) : array
  {
    try {
      $eventType = "history";
      $tickets = $this->repository->getAllTicketsByOrderIdAndEventType($order, $eventType);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getAllJazzTickets(Order $order) : array
  {
    try {
      $eventType = "jazz";
      $tickets = $this->repository->getAllTicketsByOrderIdAndEventType($order, $eventType);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getAllYummyTickets(Order $order) : array
  {
    try {
      $eventType = "yummy";
      $tickets = $this->repository->getAllTicketsByOrderIdAndEventType($order, $eventType);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function getAllDanceTickets(Order $order) : array
  {
    try {
      $eventType = "dance";
      $tickets = $this->repository->getAllTicketsByOrderIdAndEventType($order, $eventType);
      return $tickets;
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function generateQRCode($ticket): string
  {
    //Generate a QR code image with the ticket ID as data
    $qrCodeData = "http://localhost/ticket?ticketId=" . $ticket->getTicketId();

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

    foreach ($tickets as $ticket) {
      // buffer the following html with PHP so we can pass it to the PDF generator
      ob_start();
      $html = require_once(__DIR__ . '/../pdfs/ticket-pdf.php');
      // retrieve the HTML generated in our buffer and delete the buffer
      $html = ob_get_clean();

      $title = "The Festival Ticket";
      $filename = "ticket_" . $ticket->getTicketId() . ".pdf";

      $domPdf = $pdfService->generatePDF($html, $title, $filename); // Generate the PDF ticket and store it in the array
      //TODO: Uncomment the send ticket by email function when the payment funnel is finished
      $this->sendTicketByEmail($domPdf, $ticket, $order);
    }
    return $domPdf;
  }


  public function sendTicketByEmail(Dompdf $dompdf, Ticket $ticket, Order $order)
  {
    try {
      $pdfContents = $dompdf->output();

      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->isHTML(true);
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls";
      $mail->Port = 587;

      $mail->Username = "infohaarlemfestival5@gmail.com";
      $mail->Password = 'zznalnrljktsitri';
      $mail->Subject = 'Your Ticket for the Event: ' . $ticket->getEvent()->getName();

      $recipentEmail = $order->getCustomer()->getEmail();
      $name = $order->getCustomer()->getFullName();

      ob_start();
      require_once(__DIR__ . '/../emails/ticket-email.php');
      $mail->Body = ob_get_clean();

      // $mail->addAddress($order->getCustomer()->getEmail(), $name);
      $mail->addAddress("turkvedat0911@gmail.com", $name);
      $mail->addStringAttachment($pdfContents, 'ticket.pdf', 'base64', 'application/pdf');

      if ($mail->send()) {
        echo "Mail sent";
      } else {
        echo "Mail not sent";
      }
    } catch (Exception $ex) {
      throw ($ex);
    }
  }

  public function markTicketAsScanned(Ticket $ticket){
    $this->repository->markTicketAsScanned($ticket);
  }

  public function createTicketFromTicketLink(TicketLink $ticketLink)
  {
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