<!DOCTYPE html>
<html>

<head>
    <title>Invoice - 5GuysProduction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        td,
        th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #d3d3d3;
            font-weight: bold;
            text-transform: uppercase;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .contact {
            margin-top: 30px;
            font-size: 14px;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        .company-info {
            margin-top: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .company-info h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .company-info p {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .company-info a {
            color: #333;
        }
    </style>

</head>

<body>
    <div class="company-info">
        <h2>5GuysProduction</h2>
        <p>Haarlem, Overveen</p>
        <p>Phone: +31687097844</p>
        <p>Email: <a href="mailto:infohaarlemfestival5@gmail.com">infohaarlemfestival5@gmail.com</a></p>
    </div>
    <h1>Invoice of Haarlem Festival</h1>
    <h2><u>Order:</u>
        #<?php echo $order->getOrderId(); ?>
    </h2>
    <p><u>Date:</u>
        <?php echo $order->getOrderDate()->format('l, m/d/Y'); ?>
    </p>
    <p><u>Customer:</u>
        <?php echo $order->getCustomer()->getFullName(); ?>
    </p>
    <p><u>Customer Email:</u>
        <?php echo $order->getCustomer()->getEmail(); ?>
    </p>
    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Quantity</th>
                <th>Price (excl. Taxes)</th>
                <th>Tax Rate</th>
                <th>Tax Amount</th>
                <th>Price (incl. Taxes)</th>
                <th>Total Price (exl. Taxes)</th>
                <th>Total Price (incl. Taxes)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->getOrderItems() as $orderItem) { ?>
                <tr>
                    <td>
                        <?php echo $orderItem->getEventName(); ?>
                    </td>
                    <td>
                        <?php echo $orderItem->getQuantity(); ?>
                    </td>
                    <td> €
                        <?php echo number_format($orderItem->getTotalBasePrice,2); ?>
                    </td>
                    <td> 
                    %<?php echo ($orderItem->getVatPercentage() * 100); ?>
                    </td>
                    <td> €
                        <?php echo number_format($orderItem->getVatAmount() * $orderItem->getQuantity(),2); ?>
                    </td>
                    <td> €
                        <?php echo number_format($orderItem->getFullPrice() * $orderItem->getQuantity(),2); ?>
                    </td>
                    <td> €
                        <?php echo number_format($orderItem->getBasePrice() * $orderItem->getQuantity(),2); ?>
                    </td>
                    <td> €
                        <?php echo number_format($orderItem->getFullPrice() * $orderItem->getQuantity(),2); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="7" class="total">Subtotal:</td>
                <td>
                    €
                    <?php echo number_format($order->getTotalBasePrice(),2); ?>
                </td>
            </tr>
            <tr>
                <td colspan="7" class="total">Tax %9:</td>
                <td>
                    €
                    <?php echo number_format($order->getTotalVat9Amount(),2) ?>
                </td>
            </tr>
            <tr>
                <td colspan="7" class="total">Tax %21:</td>
                <td>
                    €
                    <?php echo number_format($order->getTotalVat21Amount(),2) ?>
                </td>
            </tr>
            <tr>
                <td colspan="7" class="total">Total:</td>
                <td>
                    €
                    <?php echo number_format($order->getTotalPrice(),2); ?>
                </td>
            </tr>
        </tbody>
    </table>