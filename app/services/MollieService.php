<?php
require_once __DIR__ . '/../vendor/autoload.php';

class MollieService{
    private $mollie;
    public function __construct(){
        require_once(__DIR__ . '/../Config.php');
        $this->mollie = new \Mollie\Api\MollieApiClient();
        $this->mollie->setApiKey("test_MVbzPEjp3tJW86EDNq2Dwzwbf3CKRa");
    }

    public function pay(float $totalPrice, int $orderId, int $userId){
        try{
            $payment = $this->mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $totalPrice
                ],
                "description" => "Haarlem Festival Order #{$orderId}",
                "redirectUrl" => "http://localhost:8080/order/{$orderId}/payment-success",
                "webhookUrl" => "https://c6a0-85-149-137-48.eu.ngrok.io ",
                "method" => \Mollie\Api\Types\PaymentMethod::IDEAL,
                "metadata" => [
                    "order_id" => $orderId,
                    "user_id" => $userId
                ]
            ]);

            header("Location: " . $payment->getCheckoutUrl(), true, 303);
        }catch(\Mollie\Api\Exceptions\ApiException $e){
            throw $e;
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