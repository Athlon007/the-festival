//Is ticket template for now, will change

<div class="container">
    <h2>Invoice</h2>
    <h3>Invoice number: <?php $order->getOrderId() ?></h3>

    <div>
        <label>Invoice date:</label>
        <p>
            <?= $order->getOrderDate()->format('l, m/d/Y') ?>
        </p>
    </div>
    
    <div class="customer">
        <label>Customer:</label>
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

    <div class="ticket-info">
        <label>Event Date:</label>
        <p>
            <?= $ticket->getEvent()->getStartTime()->format('l, m/d/Y') ?>
        </p>
    </div>

    <div class="ticket-info">
        <label>Event Time:</label>
        <p>
            <?= $ticket->getEvent()->getStartTime()->format('H:i') ?>
            <?= $ticket->getEvent()->getEndTime()->format('H:i') ?>
        </p>
    </div>

    <div class="ticket-info">
        <label>Customer Name:</label>
        <p>
            <?= $ticket->getCustomer()->getFirstName() . ' ' . $ticket->getCustomer()->getLastName() ?>
        </p>
    </div>

    <div class="ticket-info">
        <label>Event Location:</label>
        <p>St. Bavo Church</p>
    </div>

    <div class="ticket-info">
        <label>Customer Email:</label>
        <p>
            <?= $ticket->getCustomer()->getEmail() ?>
        </p>
    </div>

    <div class="ticket-info">
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

    h1 {
        color: brown;
        font-size: 24px;
        font-weight: bold;
        margin: 0 0 20px;
        text-align: center;
        text-transform: uppercase;
    }

    .ticket-information {
        font-style: italic;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        margin: 30px auto;
        padding: 30px;
        max-width: 500px;
    }

    .ticket-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .ticket-info label {
        display: inline-block;
        font-weight: bold;
        margin-right: 10px;
        width: 140px;
    }

    .ticket-info p {
        display: block;
        margin: 0;
        padding: 0;
    }

    .qr-code {
        max-width: 150px;
    }
</style>