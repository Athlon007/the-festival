<?php
class OrderController
{
    public function showOrderCart(){
        session_start();
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = array();
        }
        require('app/views/order/cart.php');
    }

    public function showOrderHistory(){

    }

    public function generateInvoice(){
        
    }
}