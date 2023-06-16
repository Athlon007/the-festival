<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
</head>

<body>
    <br>
    <?php require_once(__DIR__ . '/adminNavbar.php'); ?>
    <div class="container">
        <h1 class="my-5">Orders</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Total excl VAT</th>
                    <th>Quantity</th>
                    <th>Total inc VAT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <?php foreach ($order->getOrderItems() as $orderItem) : ?>
                        <tr>
                            <td>
                                <?= $order->getOrderId() ?>
                            </td>
                            <td>
                            <?= $order->getOrderDateAsDMY(); ?>
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
                                <?= "€ " . number_format($orderItem->getBasePrice(), 2) ?>
                            </td>
                            <td>
                                <?= "€ " . $orderItem->getFullTicketPrice() ?>
                            </td>
                            <td>
                                <?= $orderItem->getQuantity() ?>
                            </td>
                            <td>
                                <?= "€ " . number_format($orderItem->getTotalBasePrice(), 2) ?>
                            </td>
                            <td>
                                <?= "€ " . $orderItem->getTotalFullPrice() ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="/downloadOrders" class="btn btn-success"><i class="bi bi-download"></i> Export Orders</a>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
    </svg>

    <script src="../js/festivalhistory.js"></script>

    <footer class="foot row bottom">
    </footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script type="module" src="/js/foot.js"></script>
</body>

</html>