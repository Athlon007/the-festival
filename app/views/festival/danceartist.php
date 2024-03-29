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
    <title>Visit Haarlem - Artist: <?= $artist->getName(); ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/img/jpg/EDM_1.jpg" class="d-block w-100" alt="We ran out of image budget.">
                <div class="carousel-caption">
                    <h1><?= $artist->getName(); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?php if ($artist->noInformation()) { ?>
            <div class="container">
                <div class="row">
                    <h2 class="mx-auto text-center">Sorry! No information about <?= $artist->getName() ?> is currently available.</h2>
                </div>
            </div>
        <?php } else { ?>
            <div class="row card col-10 mx-auto p-1 my-2">
                <div class="row">
                    <h2>Overview</h2>
                </div>
                <div class="row mx-auto">
                    <?php if ($artist->getRecentAlbums() != '') { ?>
                        <div class="col-3">
                            <h3>Recent albums</h3>
                            <p><?= str_replace(',', "<br>", $artist->getRecentAlbums()); ?></p>
                        </div>
                    <?php } ?>
                    <?php if ($artist->getGenres() != '') { ?>
                        <div class="col-3">
                            <h3>Genres</h3>
                            <p><?= str_replace(',', "<br>", $artist->getGenres()); ?></p>
                        </div>
                    <?php } ?>
                    <?php if ($artist->getCountry() != '') { ?>
                        <div class="col-3">
                            <h3>Country</h3>
                            <p><?= $artist->getCountry(); ?></p>
                        </div>
                    <?php } ?>
                </div>
                <div class="row d-flex justify-content-end p-1">
                    <!-- Social Media Buttons -->
                    <?php
                    if (strlen($artist->getFacebook()) > 0) {
                        echo '<a href="' . $artist->getFacebook() . '" class="w-auto p-1" target="_blank"><button class="btn btn-primary btn-icon facebook-icon"></button></a>';
                    }
                    if (strlen($artist->getTwitter()) > 0) {
                        echo '<a href="' . $artist->getTwitter() . '" class="w-auto p-1" target="_blank"><button class="btn btn-primary btn-icon twitter-icon"></button></a>';
                    }
                    if (strlen($artist->getInstagram()) > 0) {
                        echo '<a href="' . $artist->getInstagram() . '" class="w-auto p-1" target="_blank"><button class="btn btn-primary btn-icon instagram-icon"></button></a>';
                    }
                    if (strlen($artist->getSpotify()) > 0) {
                        echo '<a href="' . $artist->getSpotify() . '" class="w-auto p-1" target="_blank"><button class="btn btn-primary btn-icon spotify-icon"></button></a>';
                    }
                    if (strlen($artist->getHomepage()) > 0) {
                        echo '<a href="' . $artist->getHomepage() . '" class="w-auto p-1" target="_blank"><button class="btn btn-primary btn-icon homepage-icon"></button></a>';
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <?php if (count($artist->getImages()) > 1) { ?>
                    <div id="bannerCarouselSecond" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            for ($counter = 1; $counter < count($artist->getImages()); $counter++) {
                                $image = $artist->getImages()[$counter];
                            ?>
                                <div class="carousel-item <?= $counter == 1 ? 'active' : ''; ?>">
                                    <img src="<?= $image->getSrc(); ?>" class="d-block w-100" alt="<?= $image->getAlt(); ?>">
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (count($artist->getImages()) > 2) { ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarouselSecond" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarouselSecond" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-12 col-xl-6 mx-auto">
                    <h2>About</h2>
                    <?php if (strlen($artist->getDescription()) == 0) { ?>
                        <p>Sorry! No information about <?= $artist->getName() ?> is currently available.</p>
                    <?php } else { ?>
                        <p><?= $artist->getDescription(); ?></p>
                    <?php } ?>
                </div>
                <?php if (strlen($artist->getSpotify()) > 0) { ?>
                    <div class="col-12 col-xl-4 mx-auto">
                        <h2>Listen</h2>
                        <iframe src="https://open.spotify.com/embed/artist/<?= basename($artist->getSpotify()) ?>" width="100%" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                    </div>
                <?php } ?>
            </div>
        <?php  } ?>
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