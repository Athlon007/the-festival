<?php

require_once __DIR__ . '/../repositories/TicketRepository.php';
require_once __DIR__ . '/../models/Ticket/Ticket.php';
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
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class TicketService
{
  protected TicketRepository $repository;

  public function __construct()
  {
    $this->repository = new TicketRepository();
  }

  public function generateQRCode($ticket): string
  {
    //Generate a QR code image with the ticket ID as data
    $qrCodeData = $ticket->getQrCodeData();
    $qrCode = new QrCode($qrCodeData);
    $qrCode->setSize(150);
    $qrCode->setMargin(10);

    $label = Label::create('Ticket QR Code')
      ->setTextColor(new Color(0, 0, 0));

    $writer = new PngWriter();

    $qrCodeImage = 'data:image/png;base64,' . base64_encode($writer->write($qrCode, null, $label)->getString());
    return $qrCodeImage;
  }

  public function generatePDFTicket($ticket,$qrCodeImage): Dompdf
  {
      $pdfService = new PDFService();  

      // buffer the following html with PHP so we can pass it to the PDF generator
      ob_start();
      $html = require_once(__DIR__ . '/../pdfs/generateTicketPDF.php');
      // retrieve the HTML generated in our buffer and delete the buffer
      $html = ob_get_clean();

      $title = "The Festival Ticket";
      $filename = "ticket.pdf";

      return $pdfService->generatePDF($html, $title, $filename);
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

  public function sendTicketByEmail(Dompdf $dompdf, Ticket $ticket)
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

      $recipentEmail = $ticket->getCustomer()->getEmail();
      $name = $ticket->getCustomer()->getFirstName() . ' ' . $ticket->getCustomer()->getLastName();

      ob_start();
      require_once(__DIR__ . '/../views/ticket/generateEmailBody.php');
      $mail->Body = ob_get_clean();

      $mail->addAddress('turkvedat0911@gmail.com', $name);
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

  public function addTicketToOrder($orderId, $ticketId)
  {
      return $this->repository->addTicketToOrder($orderId, $ticketId);
  }

  public function removeTicketFromOrder($orderId, $ticketId)
  {
      return $this->repository->removeTicketFromOrder($orderId, $ticketId);
  }

}