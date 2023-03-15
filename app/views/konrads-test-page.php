<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name=”robots” content="index, follow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <title>Example</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <div class="container">
        <div class="row col-12">
            <div class="col-3 p-1">
                <div class="row">
                    <h2>Sort</h2>
                    <select id="sort" class="form-select">
                        <option value="price-asc">Price ascending</option>
                        <option value="price-desc">Price descending</option>
                        <option value="time-asc">Time ascending</option>
                        <option value="time-desc">Time descending</option>
                    </select>
                </div>
                <div class="row">
                    <h2>Time</h2>
                    <h3>From</h3>
                    <select id="time-start" class="form-select">
                        <option value="0">00:00</option>
                        <option value="1">01:00</option>
                        <option value="2">02:00</option>
                        <option value="3">03:00</option>
                        <option value="4">04:00</option>
                        <option value="5">05:00</option>
                        <option value="6">06:00</option>
                        <option value="7">07:00</option>
                        <option value="8">08:00</option>
                        <option value="9">09:00</option>
                        <option value="10">10:00</option>
                        <option value="11">11:00</option>
                        <option value="12">12:00</option>
                        <option value="13">13:00</option>
                        <option value="14">14:00</option>
                        <option value="15">15:00</option>
                        <option value="16">16:00</option>
                        <option value="17">17:00</option>
                        <option value="18">18:00</option>
                        <option value="19">19:00</option>
                        <option value="20">20:00</option>
                        <option value="21">21:00</option>
                        <option value="22">22:00</option>
                        <option value="23">23:00</option>
                    </select>
                    <h3>To</h3>
                    <select id="time-end" class="form-select">
                        <option value="0">00:00</option>
                        <option value="1">01:00</option>
                        <option value="2">02:00</option>
                        <option value="3">03:00</option>
                        <option value="4">04:00</option>
                        <option value="5">05:00</option>
                        <option value="6">06:00</option>
                        <option value="7">07:00</option>
                        <option value="8">08:00</option>
                        <option value="9">09:00</option>
                        <option value="10">10:00</option>
                        <option value="11">11:00</option>
                        <option value="12">12:00</option>
                        <option value="13">13:00</option>
                        <option value="14">14:00</option>
                        <option value="15">15:00</option>
                        <option value="16">16:00</option>
                        <option value="17">17:00</option>
                        <option value="18">18:00</option>
                        <option value="19">19:00</option>
                        <option value="20">20:00</option>
                        <option value="21">21:00</option>
                        <option value="22">22:00</option>
                        <option value="23">23:00</option>
                    </select>
                </div>
                <div class="row">
                    <h2>Band</h2>
                    <select id="band" class="form-select">
                        <option value="all">All</option>
                        <option value="1">Band 1</option>
                        <option value="2">Band 2</option>
                        <option value="3">Band 3</option>
                        <option value="4">Band 4</option>
                        <option value="5">Band 5</option>
                    </select>
                </div>
                <div class="row">
                    <h2>Price</h2>
                    <h3>From</h3>
                    <input id="price-start" type="number" class="form-control" placeholder="0">
                    <h3>To</h3>
                    <input id="price-start" type="number" class="form-control" placeholder="0">
                </div>
                <div class="row">
                    <h2>Attributes</h2>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="attr1" name="attr1" value="attr1">
                        <label for="attr1" class="form-check-label"> Hide events without seats</label>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="container gy-1">
                    <div class="row card">
                        <div class="row">
                            <h2>Event Name</h2>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <h3>Location</h3>
                                <p>Name</p>
                            </div>
                            <div class="col-3">
                                <h3>Time</h3>
                                <p>27th of July<br>Thursday<br>18:00-19:00</p>
                            </div>
                            <div class="col-3">
                                <h3>Seats</h3>
                                <p>300/300</p>
                            </div>
                            <div class="col-3">
                                <h3>Price</h3>
                                <p class="price text-start">1000</p>
                            </div>
                        </div>
                        <div class="row justify-content-end py-2 gx-2 px-0">
                            <input style="width:4.5em;margin-right:0.5em;" type="number" class="form-control" id="ticketAmount" name="ticketAmount" min="1" max="10" value="1">
                            <button class="btn btn-primary col-3">Add ticket to cart</button>
                            <a href="/festival/jazz/event/" class="col-3">
                                <button class="btn btn-secondary w-100">About event</button>
                            </a>
                        </div>
                    </div>
                    <div class="row card">
                        <div class="row">
                            <h2>Event Name</h2>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <h3>Location</h3>
                                <p>Name</p>
                            </div>
                            <div class="col-3">
                                <h3>Time</h3>
                                <p>27th of July<br>Thursday<br>18:00-19:00</p>
                            </div>
                            <div class="col-3">
                                <h3>Seats</h3>
                                <p>300/300</p>
                            </div>
                            <div class="col-3">
                                <h3>Price</h3>
                                <p class="price text-start">1000</p>
                            </div>
                        </div>
                        <div class="row justify-content-end py-2 gx-2 px-0">
                            <input style="width:4.5em;margin-right:0.5em;" type="number" class="form-control" id="ticketAmount" name="ticketAmount" min="1" max="10" value="1">
                            <button class="btn btn-primary col-3">Add ticket to cart</button>
                            <a href="/festival/jazz/event/" class="col-3">
                                <button class="btn btn-secondary w-100">About event</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div id="events" data-type="jazz"></div>
        </div>
        <footer class="foot row bottom"></footer>
        <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script type="module" src="/js/nav.js"></script>
        <script type="module" src="/js/foot.js"></script>
        <script type="module" src="/js/textpage.js"></script>
</body>

</html>