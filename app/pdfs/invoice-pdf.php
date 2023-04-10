<!--Invoice template by Joshua-->

<div class="container">
    <h2>Invoice</h2>
    <br>
    <br>
    <h3>Invoice Number: <?= $order->getInvoice()->getInvoiceId() ?></h3>
    <br>
    <h3>Order Number: <?= $order->getOrderId() ?></h3>
    <br>
    <br>
    <div>
        <h5>Invoice date:</h5>
        <p>
            <?= $order->getInvoice()->GetInvoiceDate()->format('d/m/Y') ?>
        </p>
    </div>
    <br>
    <br>
    <div>
        <h5>Customer:</h5>
        <br>
        <p>
            <?php $order->getCustomer()->getFullName() ?><br>
            <?php $order->getCustomer()->getAddress()->getAddressLine1() ?><br>
            <?php $order->getCustomer()->getAddress()->getAddressLine2() ?><br>
            <?php $order->getCustomer()->getAddress()->getCountry() ?>
        </p>
    </div>
    <br>
    <br>
    <table border-width="1" cellpadding="1">
        <thead>
            <tr>
                <th>Quantity</th>
                <th>Event</th>
                <th>Ticket Type</th>
                <th>Base Price</th>
                <th>VAT Percentage</th>
                <th>VAT Amount</th>
                <th>Full Price</th>
            </tr>
        </thead>
        <tbody><y>
    
            <?php foreach($order->getInvoice()->getInvoiceItems as $invoiceItem){ ?>
            <tr>
                <td><?= $invoiceItem->getQuantity() ?> </td>
                <td><?= $invoiceItem->getEventName() ?> </td>
                <td><?= $invoiceItem->getTicketTypeName() ?> </td>
                <td>&euro; <?= $invoiceItem->getBasePrice() ?> </td>
                <td><?= ($invoiceItem->getVatPercentage() * 100) . "%" ?> </td>
                <td>&euro; <?= $invoiceItem->getVatAmount() ?> </td>
                <td>&euro; <?= $invoiceItem->getFullPrice() ?> </td>
                <td>&euro; <?= $invoiceItem->getTotalPrice() ?> </td>
            </tr>
            <?php 
            } ?>
        </tbody>
    </table>
    <br>
    <br>
    <div>
        <h5>Total Base Price:</h5>
        <p>
            &euro; <?= $order->getInvoice()->calculateBasePrice() ?>
        </p>
    </div>
    <div>
        <h5>Total VAT 9%:</h5>
        <p>
            &euro; <?= $order->getInvoice()->calculateVat9Amount() ?>
        </p>
    </div>
    <div>
        <h5>Total VAT 21%:</h5>
        <p>
            &euro; <?= $order->getInvoice()->calculateVat21Amount() ?>
        </p>
    </div>
    <div>
        <h5>Total Price:</h5>
        <p>
            &euro; <?= $order->getInvoice()->calculateTotalPrice() ?>
        </p>
    </div>
</div>

<style>
    body {
        background-color: #f2f2f2;
        font-family: Arial, sans-serif;
        font-size: 16px;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        margin: 30px auto;
        padding: 30px;
        max-width: 500px;
    }
</style>