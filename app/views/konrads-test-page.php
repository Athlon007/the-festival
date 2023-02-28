<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name=”robots” content="index, follow">
    <link rel="stylesheet" href="/stylesheet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <title>Example</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>

    <div class="container">
        <table style="color: var(--bs-body-color); font-family: var(--bs-body-font-family); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align); background-color: var(--bs-body-bg); width: 100%; height: 787px; border-width: 0px;">
            <tbody>
                <tr style="height: 438px;">
                    <td style="height: 438px; border-width: 0px; padding: 12px;">
                        <a href="/festival">
                            <div class="card img-fluid nav-tile">
                                <div class="carousel-caption">
                                    <p>Name</p>
                                </div>
                                <img class="card-img-top" src="../img/jpg/food-home.jpg" alt="">
                                <div class="card-img-overlay">
                                    <p class="card-text w-65 d-inline-block">This card has supporting text below as a natural lead-in to additional content.</p>
                                    <button class="btn btn-primary w-25 d-inline float-end">MY Button</button>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td style="height: 438px; border-width: 0px; padding: 12px;">
                        <a href="/festival">
                            <div class="card img-fluid nav-tile">
                                <div class="carousel-caption">
                                    <p>A Stroll Through Haarlem</p>
                                </div>
                                <img class="card-img-top" src="../img/jpg/food-home.jpg" alt="">
                                <div class="card-img-overlay">
                                    <p class="card-text w-65 d-inline-block">This card has supporting text below as a natural lead-in to additional content.</p>
                                    <button class="btn btn-primary w-25 d-inline float-end">MY Button</button>
                                </div>
                            </div>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="map"></div>
    </div>
    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="module" src="/js/nav.js"></script>
    <script type="module" src="/js/foot.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script type="module" src="/js/textpage.js"></script>

</body>

</html>