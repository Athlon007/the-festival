<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../models/Ticket/Ticket.php');
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../services/UserService.php');
use Dompdf\Dompdf;


/**
 * Handels all email sending
 * @author: Joshua
 */
class MailService
{

    private $mailer;

    const CUSTOMER_CHANGES_EMAIL = __DIR__ . "/../emails/customer-changes-email.php";
    const TICKET_EMAIL = __DIR__ . "/../emails/ticket-email.php";
    const INVOICE_EMAIL = __DIR__ . "/../emails/invoice-email.php";
    const PASSWORD_RESET_EMAIL = __DIR__ . "";


    function __construct()
    {
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

    /**
     * @throws Exception
     */
    public function sendTicketEmail($customer, $pdf)
    {
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

    public function sendResetTokenToUser($email, $reset_token, $user)
    {
        try {
            $userService = new UserService();
            $user = $userService->getUserByEmail($email);

            $this->mailer->Subject = 'Reset Your Password';

            ob_start();
            require_once(__DIR__ . '/../emails/resetPassword.php');
            $this->mailer->Body = ob_get_clean();

            $this->mailer->addAddress($email);
            $this->mailer->send();
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function sendInvoiceByEmail(Dompdf $dompdf, Order $order)
    {
        try {
            $pdfContents = $dompdf->output();

            $recipentEmail = $order->getCustomer()->getEmail();
            $name = $order->getCustomer()->getFullName();

            $this->mailer->Subject = 'Your Invoice for the The Festival';

            ob_start();
            require_once(__DIR__ . '/../emails/invoice-email.php');
            $this->mailer->Body = ob_get_clean();

            $this->mailer->addAddress($recipentEmail, $name);
            $this->mailer->addStringAttachment($pdfContents, 'invoice.pdf', 'base64', 'application/pdf');

            if (!$this->mailer->send()) {
                throw new Exception("Email could not be sent");
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function sendTicketByEmail(Dompdf $dompdf, Order $order)
    {
        try {
            $this->mailer->Subject = 'Your Ticket for the The Festival';

            $recipentEmail = $order->getCustomer()->getEmail();
            $name = $order->getCustomer()->getFullName();

            ob_start();
            require_once(__DIR__ . '/../emails/ticket-email.php');
            $this->mailer->Body = ob_get_clean();

            $this->mailer->addAddress($recipentEmail, $name);
            // add pdf to email for each ticket
            foreach ($order->getTickets() as $ticket) {
                $pdfContents = $dompdf->output();
                $this->mailer->addStringAttachment($pdfContents, 'ticket.pdf', 'base64', 'application/pdf');
            }

            if (!$this->mailer->send()) {
                throw new Exception("Email could not be sent");
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function sendAccountUpdateEmail($customer)
    {
        //Create email by loading customer data into HTML template
        ob_start();
        require_once(__DIR__ . '/../emails/customer-changes-email.php');
        $this->mailer->Body = ob_get_clean();

        //Add subject
        $this->mailer->Subject = 'Changes to your account';

        //Add recipient
        $this->mailer->addAddress($customer->getEmail(), $customer->getFullName());

        //Send email, throw exception if something goes wrong.

        if (!$this->mailer->send()){
            throw new Exception("Email could not be sent!");
        }
    }
}