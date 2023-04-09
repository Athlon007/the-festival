<?php

class Invoice implements JsonSerializable {
    
    private array $invoiceItems;

    public function jsonSerialize(){
        return [
            'invoiceItems' => $this->invoiceItems,
        ];
    }

}