<?php
// require_once(__DIR__ . '/../vendor/autoload.php');

// use Endroid\QrCode\QrCode;
// use Endroid\QrCode\Label\Label;
// use Endroid\QrCode\Writer\PngWriter;
// use Endroid\QrCode\Color\Color;

// $qrCodeData = $ticket->getQrCodeData();
// $qrCode = new QrCode($qrCodeData);
// $qrCode->setSize(150);
// $qrCode->setMargin(10);

// $label = Label::create('Ticket QR Code')
//     ->setTextColor(new Color(0, 0, 0));

// $writer = new PngWriter();

// $qrCodeImage = 'data:image/png;base64,' . base64_encode($writer->write($qrCode, null, $label)->getString());
?>

<div class="container">
    <h1>The Festival Ticket</h1>

    <p class="ticket-information">* Please have ready on your device to present for scanning.</p>

    <div class="ticket-info">
        <label>Event Name:</label>
        <p> 
            <?php echo $ticket->getEvent()->getName() ?>
        </p>
    </div>

    <div class="ticket-info">
        <label>Event Date:</label>
        <p>
            <?php echo $ticket->getEvent()->getStartTime()->format('l, m/d/Y') ?>
        </p>
    </div>

    <div class="ticket-info">
        <label>Event Time:</label>
        <p> <?php echo $ticket->getEvent()->getStartTime()->format('H:i') ?> - <?php echo
            $ticket->getEvent()->getEndTime()->format('H:i') ?> </p>
    </div>

    <div class="ticket-info">
        <label>Customer Name:</label>
        <p> <?php echo $ticket->getCustomer()->getFirstName() . ' ' . $ticket->getCustomer()->getLastName() ?></p>
    </div>

    <div class="ticket-info">
        <label>Event Location:</label>
        <p>St. Bavo Church</p>
    </div>

    <div class="ticket-info">
        <label>Customer Email:</label>
        <p> <?php echo $ticket->getCustomer()->getEmail() ?></p>
    </div>

    <div class="ticket-info">
        <label>Price:</label>
        <p style="color: red">€ <?php echo $ticket->getEvent()->getPrice() ?></p>
    </div>
    <br>
    <hr>
    <img src="<?php echo $qrCodeImage ?>" alt="Ticket QR Code" class="qr-code">
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

    .logo {
        display: block;
        margin: 0 auto 20px;
        max-width: 200px;
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
        display: block;
        margin: 10px auto 0;
        max-width: 150px;
    }
</style>