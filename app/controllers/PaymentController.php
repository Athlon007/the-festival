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
        $order = serialize($_SESSION['orderItems']);

        //go to payment page
        $this->mollie->pay($order);

        //unset the order from the session
        unset($_SESSION['orderItems']);
    }
}