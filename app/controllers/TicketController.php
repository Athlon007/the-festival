<?php
require_once("../services/TicketService.php");

require_once(__DIR__ . '/../vendor/autoload.php');

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class TicketController
{
    public function buyTicket()
    {
        try {
            require("../views/buyTicket.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function generateAndSendTicket()
    {
        try {
            $ticketService = new TicketService();
            $ticketService->sendTicketPDF();
            require("../views/generateTicketPDF.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function qrCodeTest()
    {
        try {
            $writer = new PngWriter();

            // Create QR code
            $qrCode = QrCode::create('Life is too short to be generating QR codes')
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->setSize(300)
                ->setMargin(10)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));
    
    
            // Create generic label
            $label = Label::create('Label')
                ->setTextColor(new Color(255, 0, 0));
    
            $result = $writer->write($qrCode, null, $label);
    
            // Directly output the QR code
            header('Content-Type: ' . $result->getMimeType());
            echo $result->getString();
            require("../views/qrCodeTest.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}