//Is ticket template for now, will change

<div class="container">
    <h3>Invoice number: <?php ?></h3>

    <div class="ticket-info">
        <label>Event Name:</label>
        <p>
            <?= $ticket->getEvent()->getName() ?>
        </p>
    </div>

    <div class="ticket-info">
        <label>Event Date:</label>
        <p>
            <?= $ticket->getEvent()->getStartTime()->format('l, m/d/Y') ?>
        </p>
    </div>

    <div class="ticket-info">
        <label>Event Time:</label>
        <p>
            <?= $ticket->getEvent()->getStartTime()->format('H:i') ?> -
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