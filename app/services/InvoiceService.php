<?php
require_once(__DIR__ . "/../repositories/InvoiceRepository.php");
require_once(__DIR__ . "/../models/Invoice.php");
require_once(__DIR__ . "/PDFService.php");

class InvoiceService{
    private $pdfService;

    public function __construct(){
        $this->pdfService = new PDFService();
    }

    public function getById($invoiceId){

    }
    
    public function getInvoiceByOrderId($orderId){

    }

    public function getUnpaidInvoicesByCustomerId($customerId){

    }

    public function generateInvoiceAsPDF($order){
        
    }
}

?>