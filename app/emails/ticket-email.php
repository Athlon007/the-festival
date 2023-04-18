<!--Author: Vedat-->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Your Ticket for the Event:
        <?= $ticket->getEvent()->getName() ?>
    </title>
    <style type="text/css">
        /* Add some styles for the email body */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #003399;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0 0 10px 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <p>Dear
        <?= $order->getCustomer()->getFirstName() ?>
        <?= $order->getCustomer()->getLastName() ?>,
    </p>
    <p>Thank you for your purchase.</p>
    <p>Here is your ticket for the event: <strong>
            <?= $ticket->getEvent()->getName() ?>
        </strong></p>
    <p>Event Details:</p>
    <ul>
        <li>Date:
            <?= $ticket->getEvent()->getStartTime()->format('m/d/Y') ?>
        </li>
        <li>Time:
            <?= $ticket->getEvent()->getStartTime()->format('H:i') ?> -
            <?=
                $ticket->getEvent()->getEndTime()->format('H:i') ?>
        </li>
        <li>Location: St. Bavo Church </li>
    </ul>
    <p>Please print out the attached PDF or present it on your mobile device at the event.</p>
    <p>Kind regards,</p>
    <p>The Festival Team</p>
</body>

</html>