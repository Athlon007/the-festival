<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../models/Ticket/Ticket.php');
require_once(__DIR__ . '/../models/Order.php');

/**
 * Handels all email sending
 * @author: Joshua
 */
class MailService{

    private $mailer;

    const CUSTOMER_CHANGES_EMAIL = "/../emails/customer-changes-email.php";
    const TICKET_EMAIL = "/../emails/ticket-email.php";
    const INVOICE_EMAIL = "/../emails/invoice-email.php";
    const PASSWORD_RESET_EMAIL = "";

    
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

    public function sendInvoiceEmail($order, $invoicepdf){

    }

    /**
     * @throws Exception
     */
    public function sendTicketEmail($customer, $pdf){
        $receiverEmail = $customer->getEmail();
        $receiverName = $customer->getFullName();
        $subject = "Your tickets for Haarlem Festival.";
        $message = "Thank you for buying a ticket. You can find your tickets in the attachment.";

        $this->mailer->addAttachment($pdf);

        $this->mailer->addAddress($receiverEmail, $receiverName);
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $message;

        if (!$this->mailer->send()) {
            throw new Exception();
        }
    }

    public function sendAccountUpdateEmail($customer){
        //Create email by loading customer data into HTML template
        ob_start();
        require_once(self::CUSTOMER_CHANGES_EMAIL);
        $this->mailer->Body = ob_get_clean();
        
        //Add subject
        $this->mailer->Subject = 'Changes to your account ';
        
        //Add recipient
        $this->mailer->addAddress($customer->getEmail(), $customer->getFullName());
        
        //Send email, throw exception if something goes wrong.
        if (!$this->mailer->send()) {
            throw new Exception("Error while sending message.");
        }
    }
}
?>