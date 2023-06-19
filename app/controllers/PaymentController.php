<?php

require_once("../services/InvoiceService.php");
require_once("../controllers/TicketController.php");
require_once("../services/MollieService.php");

class PaymentController
{
    private $mollie;
    public function __construct()
    {
        $this->mollie = new MollieService();
    }

    //TODO: see if this is still needed because it doesn't work anymore
    public function submitPaymentToMollie(){
        //retrieve the order from the session
        //session_start();
        $order = serialize($_SESSION['order']);


        //go to payment page
        $mollie = new MollieService();
        $mollie->pay($order);
        //$mollie->pay($totalPrice, $orderId, $userId, $paymentMethod);

        // Get all tickets and send them to the user
        $this->ticketController->getAllTicketsAndSend($order);

        require_once(__DIR__ . '../../views/payment-funnel/paymentSuccess.php');
    }
}