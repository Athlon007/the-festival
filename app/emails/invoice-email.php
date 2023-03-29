<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Order Invoice</title>
    
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
        <?= $ticket->getCustomer()->getFullName() ?>,
    </p>
    <p>Thank you for your purchase!</p>
    <p>See the attachment for the invoice for your order: 
        <strong> Order Number: <?= $order->getOrderId() ?> </strong>
    </p>
        
    </ul>
    <p>If there are any questions, there is no way to reach out to us.</p>
    <p>Kind regards,</p>
    <p>The Festival Team</p>
</body>

</html>