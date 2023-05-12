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

class InvoiceService
{
    private OrderRepository $orderRepository;

    private PDFService $pdfService;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->pdfService = new PDFService();
    }

    public function sendInvoiceEmail(){
        $orderID = 1;
        $order = $this->orderRepository->getOrderForInvoice($orderID);

        if ($order == null) {
            echo "No orders found";
            exit;
        }

        // buffer the following html into a variable
        ob_start();
        $html = require_once(__DIR__ . '/../pdfs/invoice2-pdf.php');
        $html = ob_get_clean();

        $title = "Invoice";
        $filename = "invoice_" . date('Y-m-d') . ".pdf";

        $dompdf = $this->pdfService->generatePDF($html, $title, $filename);
    }
}