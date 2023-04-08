//Is ticket template for now, will change

<div class="container">
    <h2>Invoice</h2>
    <h3>Order number: <?php $order->getOrderId() ?></h3>

    <div>
        <h5>Invoice date:</h5>
        <p>
            <?= $order->getOrderDate()->format('l, m/d/Y') ?>
        </p>
    </div>
    
    <div>
        <h5>Customer:</h5>
        <p>
            <?php $order->getCustomer()->getFullName() ?><br>
            <?php $order->getCustomer()->getAddress()->getAddressLine1() ?><br>
            <?php $order->getCustomer()->getAddress()->getAddressLine2() ?><br>
            <?php $order->getCustomer()->getAddress()->getCountry() ?>
        </p>
    </div>

    <table border-width="1" cellpadding="1">
        <tbody>
            <tr>
                <th>Ticket Name</th>
                <th>Count</th>
                <th>Base Price</th>
                <th>VAT Percentage</th>
                <th>VAT Amount</th>
                <th>Full Price</th>
            </tr>
    
            <?php foreach($order->getTickets() as $ticket){ ?>
            <tr>
                <td><?php $ticket->getEvent()->getName() ?> </td>
                <td><?php $ticket->getEvent()->getName() ?> </td>
                <td><?php $ticket->getEvent()->getName() ?> </td>
                <td><?php $ticket->getEvent()->getName() ?> </td>
                <td><?php $ticket->getEvent()->getName() ?> </td>
            </tr>
            <?php 
            } ?>
        </tbody>
    </table>

    <table>
        <tbody>
            
        </tbody>
    </table>

    <div>
        <label>Event Date:</label>
        <p>
            <?= $ticket->getEvent()->getStartTime()->format('l, m/d/Y') ?>
        </p>
    </div>

    <div>
        <label>Event Time:</label>
        <p>
            <?= $ticket->getEvent()->getStartTime()->format('H:i') ?>
            <?= $ticket->getEvent()->getEndTime()->format('H:i') ?>
        </p>
    </div>

    <div>
        <label>Customer Name:</label>
        <p>
            <?= $ticket->getCustomer()->getFirstName() . ' ' . $ticket->getCustomer()->getLastName() ?>
        </p>
    </div>

    <div>
        <label>Event Location:</label>
        <p>St. Bavo Church</p>
    </div>

    <div>
        <label>Customer Email:</label>
        <p>
            <?= $ticket->getCustomer()->getEmail() ?>
        </p>
    </div>

    <div>
        <label>Price:</label>
        <p style="color: red"><strong>€
                <?= $ticket->getEvent()->getPrice() ?>
            </strong></p>
    </div>
    <br>
    <hr>
    <img src="<?= $qrCodeImage ?>" alt="Ticket QR Code" class="qr-code">
    <hr>
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