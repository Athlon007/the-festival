<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .contact {
            margin-top: 30px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1>Invoice</h1>
    <?php foreach ($orders as $order) { ?>
        <h2>Order #
            <?php echo $order->getOrderId(); ?>
        </h2>
        <p>Date:
            <?php echo $order->getOrderDate()->format('l, m/d/Y'); ?>
        </p>
        <p>Customer:
            <?php echo $order->getCustomer()->getFullName(); ?>
        </p>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Quantity</th>
                    <th>Price (excl. Taxes)</th>
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
                            <?php echo $orderItem->getBasePrice(); ?>
                        </td>
                        <td> %
                            <?php echo $orderItem->getVatAmount(); ?>
                        </td>
                        <td> €
                            <?php echo $orderItem->getBasePrice() * $orderItem->getQuantity();  ?>
                        </td>
                        <td> €
                            <?php echo $orderItem->getFullPrice() * $orderItem->getQuantity(); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" class="total">Subtotal:</td>
                    <td>
                        <?php echo $order->getTotalBasePrice(); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Tax:</td>
                    <td>
                        <?php echo $order->getTotalVat21Amount(); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="total">Total:</td>
                    <td>
                        <?php echo $order->getTotalBasePrice(); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
    } ?>