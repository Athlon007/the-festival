<?php

require_once __DIR__ . '/../repositories/TicketRepository.php';
require_once __DIR__ . '/../models/Ticket/Ticket.php';
require_once(__DIR__ . '/../models/Exceptions/TicketNotFoundException.php');

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

    public function generateQRCode($ticket): string {
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
        $dompdf = new Dompdf([
            "chroot" => __DIR__,
            "isRemoteEnabled" => true,
            "isHtml5ParserEnabled" => true,
            "isPhpEnabled" => true,
            "isJavascriptEnabled" => true,
            "isFontSubsettingEnabled" => true,
            "isImageSubsettingEnabled" => true,
        ]);

        $html = require_once(__DIR__ . '/../views/generateTicketPDF.php');

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        $dompdf->addInfo('Title', 'The Festival Ticket');

        // $dompdf->stream("ticket.pdf", ["Attachment" => 0]);

        return $dompdf;
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

            $mail->Body = '<html>
                            <head>
                              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                              <title>Your Ticket for the Event: ' . $ticket->getEvent()->getName() . '</title>
                              <style type="text/css">
                                /* Add some styles for the email body */
                                body {
                                  font-family: Arial, sans-serif;
                                  font-size: 16px;
                                  line-height: 1.5;
                                  color: #333333;
                                  margin: 0;
                                  padding: 0;
                                }
                                h1 {
                                  font-size: 24px;
                                  font-weight: bold;
                                  color: #003399;
                                  margin: 0;
                                  padding: 0;
                                }
                                p {
                                  margin: 0 0 10px 0;
                                  padding: 0;
                                }
                              </style>
                            </head>
                            <body>
                              <p>Dear ' . $name . ',</p>
                              <p>Thank you for your purchase.</p>
                              <p>Here is your ticket for the event: <strong>' . $ticket->getEvent()->getName() . '</strong></p>
                              <p>Event Details:</p>
                              <ul>
                                <li>Date: ' . $ticket->getEvent()->getStartTime()->format('m/d/Y') . '</li>
                                <li>Time: ' . $ticket->getEvent()->getStartTime()->format('H:i') . ' - ' . $ticket->getEvent()->getEndTime()->format('H:i') . '</li>
                                <li>Location: ' . 'St. Bavo Church' . '</li>
                              </ul>
                              <p>Please print out the attached PDF or present it on your mobile device at the event.</p>
                              <p>Kind regards,</p>
                              <p>The Festival Team</p>
                            </body>
                          </html>';

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

}