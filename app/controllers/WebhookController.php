<?php
    require_once __DIR__ . '/../services/MollieService.php';
    require_once __DIR__ . '/../services/OrderService.php';
    require_once __DIR__ . '/../services/TicketService.php';
    require_once __DIR__ . '/../services/PDFService.php';
    require_once __DIR__ . '/../services/UserService.php';
    require_once __DIR__ . '/../services/MailService.php';

class WebhookController{

    public function webhook(){
       try{
            $mollieService = new MollieService();
            $payment = $mollieService->getPayment($_POST["id"]);
            $order_id = $payment->metadata->order_id;
            $user_id = $payment->metadata->user_id;
            $tickets = $payment->metadata->tickets;
    
            $orderService = new OrderService();
            //update order status?????
    
            if($payment->isPaid()){
                //TODO: make a reservation if it is yummy ticket
                $ticketService = new TicketService();
    
                //checking every ticket booked
                foreach($tickets as $ticket){
    
                    $ticketService->addTicketToOrder($order_id, $ticket->getId());
                    
                    //if the ticket is yummy ticket, make a reservation
                }
    
                //generate pdf
                $pdfService = new PDFService();
                $pdf = $pdfService->generatePDF($order_id, $user_id, $tickets);
    
                //get the user data
                $userService = new UserService();
                $user = $userService->getUserById($user_id);
    
                //send email
                $mailService = new MailService();
                $mailService->sendTicketEmail($user->getEmail(), $pdf);
                unlink($pdf);
            }
            }catch(\Mollie\Api\Exceptions\ApiException $e){
                echo "API call failed: " . htmlspecialchars($e->getMessage());
            }
        
    }
}

?>