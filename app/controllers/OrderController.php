<?php
class OrderController
{
    public function showShoppingCart(){
        if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
            $_SESSION['cart'] = array();
        }
        require('app/views/payment-funnel/cart.php');
    }

    public function showOrderHistory(){

    }

    public function generateInvoice(){
        
    }

    public function createOrder(){
        try{
            if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
                throw new Exception("Cart is empty");
            }
            if(!isset($_SESSION['user'])){
                throw new Exception("User is not logged in");
            }

            $orderService = new OrderService();
            $order = $orderService->createOrder($_SESSION['user']->getCustomerId(), $_SESSION['cart']);
        }
        catch(Exception $e){
            echo $e->getMessage();
            return;
        }
        

    }

    
}