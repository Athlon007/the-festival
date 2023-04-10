<?php
require_once(__DIR__ . "/../repositories/Repository.php");
require_once(__DIR__ . "/../models/Invoice.php");
require_once(__DIR__ . "/../models/InvoiceItem.php");

class InvoiceRepository extends Repository{

    private function buildInvoice($row) : Invoice{
        
    }

    private function buildInvoiceItem($row) : InvoiceItem{
        $invoiceItem = new InvoiceItem();
        $invoiceItem->setEventName($row['name']);
        $invoiceItem->setTicketTypeName($row['ticketTypeName']);
        $invoiceItem->setBasePrice($row['basePrice']);
        $invoiceItem->setVatPercentage($row['vatPercentage']);
        $invoiceItem->setVatAmount($row['vatAmount']);
        $invoiceItem->setFullPrice($row['fullPrice']);
        $invoiceItem->setQuantity($row['quantity']);
        return $invoiceItem;
    }
    
    public function getById($invoiceId) : Invoice{
        $sql = "select * from invoices where invoiceId = :invoiceId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(":invoiceId", $invoiceId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $this->buildInvoice($result);
    }

    public function getInvoiceItemsByOrderId($orderId) : array{
        try{
            $sql = "select e.name as eventName, ti.ticketTypeName as ticketTypeName, t.basePrice as basePrice, f.VAT as vatPercentage, t.vat as vatAmount, t.fullPrice as fullPrice, count(t.eventId) as quantity " +
            "from tickets t " +
            "join tickettypes ti on t.ticketTypeId = ti.ticketTypeId " +
            "join events e on e.eventId = t.eventId " +
            "join festivaleventtypes f on e.festivalEventType = f.eventTypeId " +
            "where t.orderId = :orderId " +
            "group by e.name, ti.ticketTypeName, e.startTime, t.basePrice, f.VAT, t.vat, t.fullPrice";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(":orderId", $orderId);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $invoiceItems = array();
            foreach($result as $row){
                $invoiceItem = $this->buildInvoiceItem($row);
                array_push($invoiceItems, $invoiceItem);
            }

            return $invoiceItems;
        }
        catch(Exception $e){
            throw new Exception("Error while getting invoice items: " . $e->getMessage());
        }
    }

    public function update($invoiceId, $invoice){

    }


}