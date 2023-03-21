<?php
class OrderController
{
    public function showOrderCart(){
        session_start();
        if(!isset($_SESSION['order'])){
            $_SESSION['order'] = new Order();
        }
        require('app/views/order/cart.php');
    }

    public function showOrderHistory(){

    }
}