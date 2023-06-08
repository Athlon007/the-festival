<?php

require_once("../services/InvoiceService.php");
require_once("../controllers/TicketController.php");
require_once("../services/MollieService.php");

class PaymentController
{
    private $invoiceService;
    private $ticketController;

    public function __construct()
    {
        $this->invoiceService = new InvoiceService();
        $this->ticketController = new TicketController();
    }

    public function sendTicketsAndInvoice()
    {
        $order = new Order();
        $order->setOrderId(1);

        //Send invoice via email
        $this->invoiceService->sendInvoiceEmail($order);

        // Get all tickets and send them to the user
        $this->ticketController->getAllTickets($order);

        require_once(__DIR__ . '../../views/payment-funnel/paymentSuccess.php');
    }

    public function submitPaymentToMollie(){
        //retrieve the order from the session
        //session_start();
        $order = serialize($_SESSION['orderItems']);

        //go to payment page
        $mollie = new MollieService();
        $mollie->pay($order);

        //unset the order from the session
        unset($_SESSION['orderItems']);

    }
}