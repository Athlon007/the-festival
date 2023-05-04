<!DOCTYPE html>
<html>

<head>
    <title>Admin Orders</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
</head>

<body>

    <div class="container">
        <h1 class="my-5">Admin Orders</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Event Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php foreach ($order->getOrderItems() as $orderItem): ?>
                        <tr>
                            <td>
                                <?= $order->getOrderId() ?>
                            </td>
                            <td>
                                <?= date_format($order->getOrderDate(), 'd/m/Y') ?>
                            </td>
                            <td>
                                <?= $order->getCustomer()->getFirstName() ?>
                                <?= $order->getCustomer()->getLastName() ?>
                            </td>
                            <td>
                                <?= $order->getCustomer()->getEmail() ?>
                            </td>
                            <td>
                                <?= $orderItem->getEventName() ?>
                            </td>
                            <td>
                                <?= "€ " . $orderItem->getFullPrice() ?>
                            </td>
                            <td>
                                <?= $orderItem->getQuantity() ?>
                            </td>
                            <td>
                                <?= "€ " . $orderItem->getQuantity() * $orderItem->getFullPrice() ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/exportOrders" class="btn btn-primary">Export Orders</a>
    </div>

    <script src="../js/festivalhistory.js"></script>

    <footer class="foot row bottom">
    </footer>
    <script type="application/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script type="module" src="/js/foot.js"></script>
</body>

</html>