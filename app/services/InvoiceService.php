<?php

require_once __DIR__ . '/../repositories/TicketRepository.php';
require_once __DIR__ . '/../models/Ticket/Ticket.php';
require_once(__DIR__ . '/../models/TicketLink.php');
require_once(__DIR__ . '/../models/Exceptions/TicketNotFoundException.php');
require_once(__DIR__ . '/../services/PDFService.php');
require_once(__DIR__ . "/../repositories/OrderRepository.php");

use Dompdf\Dompdf;

require_once('../phpmailer/PHPMailer.php');
require_once('../phpmailer/SMTP.php');
require_once('../phpmailer/Exception.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Class InvoiceService
 * This class is responsible for generating and sending invoices
 * @Author: Vedat
 */
class InvoiceService
{
  private PDFService $pdfService;
  private OrderRepository $orderRepository;

  public function __construct()
  {
    $this->pdfService = new PDFService();
    $this->orderRepository = new OrderRepository();
  }

  public function sendInvoiceEmail(Order $order)
  {
    $order = $this->orderRepository->getOrderForInvoice($order->getOrderId());

    if ($order == null) {
      echo "No orders found";
      exit;
    }

    // buffer the following html into a variable
    ob_start();
    $html = require_once(__DIR__ . '/../pdfs/invoice-pdf.php');
    $html = ob_get_clean();

    $title = "Invoice";
    $filename = "invoice_" . date('Y-m-d') . ".pdf";

    $dompdf = $this->pdfService->generatePDF($html, $title, $filename);
    $this->sendInvoiceByEmail($dompdf, $order);
  }


  public function sendInvoiceByEmail(Dompdf $dompdf, Order $order)
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
      $mail->Subject = 'Your Invoice for the The Festival';

      $recipentEmail = $order->getCustomer()->getEmail();
      $name = $order->getCustomer()->getFullName();

      ob_start();
      require_once(__DIR__ . '/../emails/invoice-email.php');
      $mail->Body = ob_get_clean();

      $mail->addAddress($order->getCustomer()->getEmail(), $name);
      //Debugging
      //$mail->addAddress("aathlon@outlook.com", $name);
      $mail->addStringAttachment($pdfContents, 'invoice.pdf', 'base64', 'application/pdf');

      if (!$mail->send()) {
        throw new Exception("Email could not be sent");
      }
    } catch (Exception $ex) {
      throw ($ex);
    }
  }
}
