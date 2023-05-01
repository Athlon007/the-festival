<!DOCTYPE html>
<html>

<head>
    <title>Order History</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Order History</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Total Price</th>
                    <th>Ticket ID</th>
                    <th>Base Price</th>
                    <th>VAT</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($orders as $order) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $order->getOrderId() ?>
                        </td>
                        <td>
                            <?= $order->getOrderDate()->format('Y-m-d') ?>
                        </td>
                        <td>
                            <?php echo $order->getTotalFullPrice() ?>
                        </td>
                        <?php
                        foreach ($order->getTickets() as $ticket) {
                            ?>
                            <td>
                                <?php echo $ticket->getTicketId() ?>
                            </td>
                            <td>
                                <?php echo $ticket->getBasePrice() ?>
                            </td>
                            <td>
                                <?php echo $ticket->getVat() ?>
                            </td>

                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>