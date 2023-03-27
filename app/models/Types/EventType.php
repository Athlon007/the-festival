<?php
class EventType{
    private $id;
    private $name;
    private $vat;

    public function __construct($id, $name, $vat){
        $this->id = $id;
        $this->name = $name;
        $this->vat = $vat;
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

    public function setVat($value){
        $this->vat = $value;
    }

    public function getVat(){
        return $this->vat;
    }

    public function jsonSerialize(){
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "vat" => $this->getVat(),
        ];
    }
}