<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>

    <!-- Container -->
    <section class="h-100 h-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-10">
                    <h2 class="m-5">Shopping Cart</h2>
                    <button class="btn btn-secondary float-end">Order History</button>
                    <!--Pop-up message-->
                    <div id="popup">
                    </div>

                    <!-- Cart -->

                    <?php
                    if (!$ticketLinks) {
                        echo "Your cart is empty. Go back and buy some stuff!";
                    } else {
                        foreach ($ticketLinks as $ticketLink) {
                            $id = $ticketLink["ticketLink"]->getId(); ?>
                            <div id="cart-item-<?= $id ?>" class="card p-3 m-3" style="width: 60%">
                                <div class="card-header" style="width: 100%">
                                    <?= $ticketLink['ticketLink']->getEvent()->getName() ?>
                                    <?= $ticketLink['ticketLink']->getTicketType()->getName() ?> - &euro; <?= $ticketLink['ticketLink']->getTicketType()->getPrice() ?>
                                </div>
                                <br>
                                <div style="width: 100%">
                                    <button id="cart-item-remove-<?= $id ?>" class="btn btn-light" style="width: 20%">-</button>
                                    <span id="cart-item-counter-<?= $id ?>"><?= $ticketLink['amount'] ?></span>
                                    <button id="cart-item-add-<?= $id ?>" class=" btn btn-light" style="width: 20%">+</button>
                                    <span id="cart-item-unit-price-<?= $id ?>" class=" d-none float-end"><?= $ticketLink['ticketLink']->getTicketType()->getPrice() ?></span>
                                    <span id="cart-item-total-price-<?= $id ?>" class="price float-end">&euro; <?= $ticketLink['price'] ?></span>
                                </div>
                                <br>
                                <div style="width: 100%">
                                    <button id="cart-item-delete-<?= $ticketLink["ticketLink"]->getId() ?>" class="btn btn-danger float-end">Delete</button>
                                </div>
                            </div>


                    <?php }
                    }   ?>
                    <br>
                    <br>
                    <h4 id="total">Total price: &euro; <?= $cart['totalPrice'] ?></h4>
                    <button class="btn btn-primary">Check out</button>


                </div>
            </div>
        </div>
    </section>

    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="/js/cartcontroller.js"></script>
    <script type="module" src="/js/foot.js"></script>
</body>

</html>