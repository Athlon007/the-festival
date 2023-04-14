<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '../models/Customer.php');
require_once(__DIR__ . '../models/Invoice.php');
require_once(__DIR__ . '../models/Ticket.php');
require_once(__DIR__ . '../models/Order.php');

/**
 * @author: Joshua
 * Handels all email sending
 */
class MailService{

    private $mailer;
    
    function __construct(){
        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->isHTML(true);
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->SMTPSecure = "tls";
        $this->mailer->Port = 587;
        $this->mailer->Username = "infohaarlemfestival5@gmail.com";
        $this->mailer->Password = 'zznalnrljktsitri';
    }

    public function sendTicketEmail(){

    }

    public function sendInvoiceEmail(){

    }

    public function sendPasswordResetEmail(){

    }

    public function sendAccountUpdateEmail(){

    }

}
?>