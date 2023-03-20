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
    <title>Visit Haarlem - Event: <?= $event->getName(); ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <? if (count($event->getArtist()->getImages()) > 0) { ?>
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <? $image = $event->getArtist()->getImages()[0]; ?>
                <div class="carousel-item active">
                    <img src="<?= $image->getSrc(); ?>" class="d-block w-100" alt="<?= $image->getAlt(); ?>">
                    <div class="carousel-caption">
                        <h1><?= $image->getAlt(); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
    <div class="container">
        <div class="row col-12 py-1 justify-content-center ">
            <input type="number" class="form-control" style="width:4em" id="ticketAmount" name="ticketAmount" min="1" max="10" value="1">
            <button class="btn btn-primary px-2 mx-1 w-auto">Add ticket to cart</button>
        </div>
        <div class="row card col-10 mx-auto p-1 my-2">
            <div class="row mx-auto">
                <div class="col-8">
                    <h2>About artist</h2>
                    <p><?= $event->getArtist()->getDescription() ?></p>
                    <a href="/festival/jazz/artist/<?= $event->getArtist()->getId() ?>">
                        <button class="btn btn-primary">More about <?= $event->getArtist()->getName() ?></button>
                    </a>
                </div>
                <div class="col-4">
                    <h2>Time</h2>
                    <p><?= $event->getStartTime()->format("l, F jS") ?><br><?= $event->getStartTime()->format("H:i") ?>-<?= $event->getEndTime()->format("H:i") ?></p>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col-8">
                    <h2>Where</h2>
                    <div id="mapContainer" style="height:300px" data-mapkind="event" data-lon="<?= $event->getLocation()->getLon() ?>" data-lat="<?= $event->getLocation()->getLat() ?>" data-name="<?= $event->getLocation()->getName() ?>" data-street="<?= $event->getLocation()->getAddress()->getStreetName() ?>"></div>
                </div>
                <div class="col-4">
                    <h2>Price</h2>
                    <p class="price text-start">&euro; <?= $event->getPrice() ?></p>
                </div>
            </div>
        </div>
    </div>
    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="module" src="/js/nav.js"></script>
    <script type="module" src="/js/foot.js"></script>
    <script type="application/javascript" src="/js/textpage.js"></script>
</body>

</html>