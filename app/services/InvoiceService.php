<?php

require_once __DIR__ . '/../repositories/TicketRepository.php';
require_once __DIR__ . '/../models/Ticket/Ticket.php';
require_once(__DIR__ . '/../models/TicketLink.php');
require_once(__DIR__ . '/../models/Exceptions/TicketNotFoundException.php');
require_once(__DIR__ . '/../services/PDFService.php');
require_once(__DIR__ . "/../repositories/OrderRepository.php");
require_once(__DIR__ . '/../services/MailService.php');


require_once('../phpmailer/PHPMailer.php');
require_once('../phpmailer/SMTP.php');
require_once('../phpmailer/Exception.php');


/**
 * Class InvoiceService
 * This class is responsible for generating and sending invoices
 * @Author: Vedat
 */
class InvoiceService
{
  private PDFService $pdfService;
  private TicketRepository $ticketRepository;
  private OrderRepository $orderRepository;

  public function __construct()
  {
    $this->pdfService = new PDFService();
    $this->ticketRepository = new TicketRepository();
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
    $mailService = new MailService();
    $mailService->sendInvoiceByEmail($dompdf, $order);
  }

}
