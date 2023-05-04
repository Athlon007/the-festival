<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../repositories/OrderRepository.php');
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../models/Exceptions/OrderNotFoundException.php');
require_once(__DIR__ . '/../repositories/TicketLinkRepository.php');
require_once(__DIR__ . '/../models/TicketLink.php');
require_once(__DIR__ . '/../repositories/TicketRepository.php');
require_once(__DIR__ . '/../services/TicketService.php');
require_once(__DIR__ . '/../services/PDFService.php');

class OrderService
{
    private $orderRepository;
    private $ticketLinkRepository;
    private $ticketRepository;
    private $ticketService;
    private $pdfService;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->ticketLinkRepository = new TicketLinkRepository();
        $this->ticketRepository = new TicketRepository();
        $this->ticketService = new TicketService();
        $this->pdfService = new PDFService();
    }

    public function getOrderById($id)
    {
        return $this->orderRepository->getOrderById($id);
    }

    public function getOrderHistory($customerId)
    {
        return $this->orderRepository->getOrderHistory($customerId);
    }

    public function getOrdersToExport()
    {
        return $this->orderRepository->getOrdersToExport();
    }

    public function downloadOrders()
    {
        $orders = $this->getOrdersToExport();

        if ($orders == null) {
            echo "No orders found";
            exit;
        }

        $fileName = "orders-data_" . date('Y-m-d') . ".xls";
        $fields = array('ID', 'ORDER DATE', 'CUSTOMER NAME', 'CUSTOMER EMAIL', 'EVENT NAME', 'PRICE', 'QUANTITY', 'TOTAL PRICE');
        $excelData = implode("\t", $fields) . "\n";

        foreach ($orders as $order) {
            foreach ($order->getOrderItems() as $orderItem) {
                $lineData = array(
                    $order->getOrderId(),
                    date_format($order->getOrderDate(), 'd/m/Y'),
                    $order->getCustomer()->getFirstName() . " " . $order->getCustomer()->getLastName(),
                    $order->getCustomer()->getEmail(),
                    $orderItem->getEventName(),
                    iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "€ " . $orderItem->getFullPrice()),
                    $orderItem->getQuantity(),
                    iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "€ " . $orderItem->getQuantity() * $orderItem->getFullPrice())
                );
                array_walk($lineData, array($this, 'filterData'));
                $excelData .= implode("\t", $lineData) . "\n";
            }
        }

        // Send HTTP headers
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Cache-Control: max-age=0");

        // Output the Excel data to the output buffer and exit
        echo $excelData;
        exit;
    }

    private function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"'))
            $str = '"' . str_replace('"', '""', $str) . '"';
    }


    // public function downloadOrders(){
    //     $orders = $this->getOrdersToExport();

    //     $fileName = "orders-data_" . date('Y-m-d') . ".csv";

    //     $fields = array('ID', 'ORDER DATE', 'CUSTOMER NAME', 'CUSTOMER EMAIL', 'EVENT NAME', 'PRICE', 'QUANTITY', 'TOTAL PRICE');

    //     $excelData = implode("\t", array_values($fields)) . "\n";

    //     if ($orders == null) {
    //         $excelData .= 'No orders found' . "\n";
    //     }

    //     foreach($orders as $order){
    //         foreach($order->getOrderItems() as $orderItem){
    //             $lineData = array($order->getOrderId(), date_format($order->getOrderDate(), 'd/m/Y'), $order->getCustomer()->getFirstName() . " " . $order->getCustomer()->getLastName(), $order->getCustomer()->getEmail(), $orderItem->getEventName(), "€ " . $orderItem->getFullPrice(), $orderItem->getQuantity(), "€ " . $orderItem->getQuantity() * $orderItem->getFullPrice());
    //             array_walk($lineData, array($this, 'filterData'));
    //             $excelData .= implode("\t", array_values($lineData)) . "\n";
    //         }
    //     }

    //     header("Content-type: application/vnd.ms-excel");
    //     header("Content-Disposition: attachment; filename=\"$fileName\"");
    // }

    // private function filterData(&$str){
    //     $str = preg_replace("/\t/", "\\t", $str);
    //     $str = preg_replace("/\r?\n/", "\\n", $str);
    //     if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    // }

    public function getUnpaidOrder($customerId)
    {
        return $this->orderRepository->getUnpaidOrder($customerId);
    }

    //To be called after payment (can't be implemented yet)
    public function createOrder($customer, $ticketLinkIds)
    {
    }

    public function sendInvoiceAndTicketsByEmail($order)
    {
        //Generate and email the tickets
        foreach ($order->getTickets() as $ticket) {
            //Generate a PDF for the ticket and send it by email.
            $qrCode = $this->ticketService->generateQRCode($ticket);
            $dompdf = $this->ticketService->generatePDFTicket($ticket, $qrCode, $order);
            $this->ticketService->sendTicketByEmail($dompdf, $ticket, $order);
        }

        //Generate and email the invoice
    }
}