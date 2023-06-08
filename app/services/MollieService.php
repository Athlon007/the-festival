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
            $order_id = $order[0]->getOrderItemId();
            $user_id = $order->getUserId();

            $payment = $this->mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $order->getTotalPrice()
                ],
                "description" => "Haarlem Festival Order #{$order_id}",
                "redirectUrl" => "http://localhost:8080/order/{$order_id}/payment-success",
                "webhookUrl" => "here goes the ngrok url webhook example(https://e6f2-85-149-137-48.eu.ngrok.io)",
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