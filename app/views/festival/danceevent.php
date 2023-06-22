<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name=”robots” content="index, follow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/main_no_editor.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <title>Visit Haarlem - Event: <?= $event->getName(); ?></title>
</head>

<body>
    <nav class=" navbar navbar-expand-lg navbar-dark bg-dark">
    </nav>
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/img/jpg/EDM_1.jpg" class="d-block w-100" alt="We ran out of image budget.">
                <div class="carousel-caption">
                    <h1><?= $event->getName(); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row col-12 py-1 justify-content-center">
            <?php if ($cartItem->getTicketType()->getPrice() > 0) {
                if ($cartItem->getEvent()->getAvailableTickets() > 0) { ?>
                    <button class="btn btn-primary px-2 mx-1 w-auto" onclick="Cart.Add(<?= $cartItem->getId() ?>)">Add ticket to cart</button>
                    <p class="mx-auto text-center"><?= $cartItem->getEvent()->getAvailableTickets() ?> / <?= $cartItem->getEvent()->getLocation()->getCapacity() ?></p>
                <?php } else { ?>
                    <p class="mx-auto text-center">Sold out!</p>
                <?php }
            } else { ?>
                <button class="btn btn-primary px-2 mx-1 w-auto" onclick="Cart.Add(<?= $cartItem->getId() ?>)">Book a ticket</button>
            <?php } ?>
        </div>
        <div class="row card col-10 mx-auto p-1 my-2">
            <div class="row mx-auto">
                <div class="col-8">
                    <h2>Artists Playing</h2>
                    <ul>
                        <?php foreach ($event->getArtists() as $artist) { ?>
                            <a href="/festival/dance/artist/<?= $artist->getId(); ?>">
                                <li><?= $artist->getName(); ?></li>
                            </a>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-4">
                    <h2>Time</h2>
                    <p><?= $event->getStartTime()->format("l, F jS") ?><br><?= $event->getStartTime()->format("H:i") ?>-<?= $event->getEndTime()->format("H:i") ?></p>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col-8">
                    <h2>Where</h2>
                    <div class="row">
                        <div id="mapContainer" class="col-8" style="height:300px" data-mapkind="event" data-lon="<?= $event->getLocation()->getLon() ?>" data-lat="<?= $event->getLocation()->getLat() ?>" data-name="<?= $event->getLocation()->getName() ?>" data-street="<?= $event->getLocation()->getAddress()->getStreetName() ?>"></div>
                        <div class="col-4">
                            <strong><?= $event->getLocation()->getName() ?></strong>
                            <p class="my-0"><?= $event->getLocation()->getAddress()->getStreetName() ?> <?= $event->getLocation()->getAddress()->getHouseNumber() ?></p>
                            <p class="my-0"><?= $event->getLocation()->getAddress()->getPostalCode() ?> <?= $event->getLocation()->getAddress()->getCity() ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <h2>Price</h2>
                    <p class="price text-start"><?= $cartItem->getTicketType()->getPrice() == 0 ? "Free" : "&euro; " . $cartItem->getTicketType()->getPrice() ?></p>
                </div>
            </div>
        </div>
    </div>
    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="module" src="/js/nav.js"></script>
    <script type="module" src="/js/foot.js"></script>
    <script type="application/javascript" src="/js/cart.js"></script>
    <script type="application/javascript" src="/js/textpage.js"></script>
</body>

</html>