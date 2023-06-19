<?php

require_once("../services/InvoiceService.php");
require_once("../controllers/TicketController.php");
require_once("../services/MollieService.php");

class PaymentController
{
    public function showPaymentSuccessWindow(){
        require_once(__DIR__ . '../../views/payment-funnel/paymentSuccess.php');
    }
}