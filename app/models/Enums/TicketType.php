<?php
class TicketType{
    private $id;
    private $name;
    private $price;

    public function __construct($id, $name, $price){
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId(){
        return $this->id;
    }

    public function setId($value){
        $this->id = $value;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($value){
        $this->name = $value;
    }

    public function setPrice($value){
        $this->price = $value;
    }

    public function getPrice(){
        return $this->price;
    }

    public function jsonSerialize(){
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "vat" => $this->getPrice(),
        ];
    }
}