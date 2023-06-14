<?php
require_once __DIR__ . '/../vendor/autoload.php';

class MollieService{
    private $mollie;
    public function __construct(){
        require_once(__DIR__ . '/../Config.php');
        $this->mollie = new \Mollie\Api\MollieApiClient();
        $this->mollie->setApiKey("test_MVbzPEjp3tJW86EDNq2Dwzwbf3CKRa");
    }

    public function pay($order){
        try{
            $order = unserialize($order);
            $order_id = [];
            $user_id = [];
            $total_price = 0;

            //not a good way of doing this, but works, please FIX!!!
            foreach($order as $item){
                $total_price += $item->getTotalFullPrice();
                array_push($order_id, $item->getOrderItemId());
                array_push($user_id, $item->getTicketLinkId());
            }


            $payment = $this->mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $total_price . ".00"
                ],
                "description" => "Haarlem Festival Order #{$order_id[0]}",
                "redirectUrl" => "http://localhost:8080/order/{$order_id[0]}/payment-success",
                "webhookUrl" => "https://c6a0-85-149-137-48.eu.ngrok.io ",
                "method" => \Mollie\Api\Types\PaymentMethod::IDEAL,
                "metadata" => [
                    "order_id" => $order_id,
                    "user_id" => $user_id
                ]
            ]);

            header("Location: " . $payment->getCheckoutUrl(), true, 303);
        }catch(\Mollie\Api\Exceptions\ApiException $e){
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
    }

    public function getPayment($payment_id){
        try{
            $payment = $this->mollie->payments->get($payment_id);
            return $payment;
        }catch(\Mollie\Api\Exceptions\ApiException $e){
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>