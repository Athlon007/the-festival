<?php
class OrderController
{
    public function showOrderCart(){
        session_start();
        if(!isset($_SESSION['order'])){
            $_SESSION['order'] = new Order();
        }
        
    }

    public function showOrderHistory(){

    }
}