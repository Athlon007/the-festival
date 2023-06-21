<!--Ticket template by Vedat /Edited by Joshua-->

<?php
foreach ($tickets as $index => $ticket) {
    $qrCodeImage = $qrCodeImages[$index];
?>
    <div class="container">
        <h1>The Festival Ticket</h1>

        <p class="ticket-information">* Please have ready on your device to present for scanning.</p>

        <div class="ticket-info">
            <label>Ticket ID:</label>
            <p>
                <?= $ticket->getTicketId() ?>
            </p>
        </div>

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
                <?= $ticket->getEvent()->getStartTime()->format('H:i') ?>
                <?= $ticket->getEvent()->getEndTime()->format('H:i') ?>
            </p>
        </div>

        <div class="ticket-info">
            <label>Customer Name:</label>
            <p>
                <?= $order->getCustomer()->getFirstName() . ' ' . $order->getCustomer()->getLastName() ?>
            </p>
        </div>

        <?php if (method_exists($ticket->getEvent(), 'getLocation')) { ?>
            <div class="ticket-info">
                <label>Event Location:</label>
                <p>
                    <?= $ticket->getEvent()->getLocation()->getName() ?>
                </p>
            </div>
        <?php } ?>

        <div class="ticket-info">
            <label>Customer Email:</label>
            <p>
                <?= $order->getCustomer()->getEmail() ?>
            </p>
        </div>

        <div class="ticket-info">
            <label>Price:</label>
            <p style="color: red"><strong>€
                    <?= $ticket->getFullPrice() ?>
                </strong></p>
        </div>
        <br>
        <hr>
        <img src="<?= $qrCodeImage ?>" alt="Ticket QR Code" class="qr-code">
        <hr>
    </div>
    <?php
    if ($index < count($tickets) - 1) {
    ?>
        <div class="page-break"></div>
    <?php
    }
    ?>
<?php
}
?>

<style>
    .page-break {
        page-break-after: always;
    }

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