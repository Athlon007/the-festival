<?php

$destinations = array(
    array(
        'title' => 'St. Bavo Church',
        'image' => 'stbavo.jpg',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra urna sed dui hendrerit posuere.'
    ),
    array(
        'title' => 'Destination 1',
        'image' => 'destination1.jpg',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra urna sed dui hendrerit posuere.'
    ),
    array(
        'title' => 'Destination 2',
        'image' => 'destination2.jpg',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra urna sed dui hendrerit posuere.'
    ),
    array(
        'title' => 'Destination 3',
        'image' => 'destination3.jpg',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra urna sed dui hendrerit posuere.'
    ),
    array(
        'title' => 'One drink per person',
        'image' => 'onedrink.jpg',
        'description' => '15 min. break at Jopenkerk'
    )
);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>A Stroll Through History</title>
    <link rel="stylesheet" href="/css/history_stroll.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>A Stroll Through History - Festival Haarlem</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="hero-image">
            <div class="rectangle">
                <div class="hero-text">
                    <h1>A Stroll Through History</h1>
                </div>
            </div>
            <div class="hero-button">
                <button type="button">GET YOUR TICKETS NOW!</button>
            </div>
        </div>

        <div class="breadcrumb">
            <a href="/">Home ></a>
            <a href="/festival">Festival ></a>
            <a href="#">A Stroll Through History</a>
        </div>

        <div class="title">
            <h2>Welcome to The Festival Haarlem</h2>
            <hr>
        </div>


        <section class="about-section">
            <div class="row">
                <!-- First column -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h2>Let's Tour Around Haarlem</h2>
                    <p>Welcome to a city that is filled with historical monuments, spectacular museums and
                        world-famous art! Cars are not allowed on many streets in Haarlem which makes it a great
                        city for a tour! We organise tours every day during The Festival Haarlem.
                    </p>

                    <button type="submit" class="btn btn-outline-success">See Overview</button>

                </div>

                <!-- This is location and time column -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 location-and-time">
                    <div class="row location-time-row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 location-column">
                            <p>Starting Point<br>St. Bavo Church</p>
                        </div>

                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 festival-day-column">
                            <p>Every Festival Day</p>
                            <ul>
                                <li> 10:00 am</li>
                                <li> 13:00 pm</li>
                                <li> 16:00 pm</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <div class="container ticket-container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6 dateOfTour" style="width: 50%; float:left;">
                            <label for="date" class="form-label">Date</label>
                            <select class="form-select" id="date">
                                <option selected>Choose Date</option>
                                <option value="27">Thu 27/07/2023</option>
                                <option value="28">Fri 28/07/2023</option>
                                <option value="29">Sat 29/07/2023</option>
                                <option value="30">Sun 30/07/2023</option>
                            </select>
                        </div>
                        <div class="col-md-6 timeOfTour" style="width: 50%; float:right;">
                            <label for="time" class="form-label">Time</label>
                            <select class="form-select" id="time">
                                <option selected>Choose Time</option>
                                <option value="10">10:00</option>
                                <option value="13">13:00</option>
                                <option value="16">16:00</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 languageOfTour" style="width: 50%; float:left;">
                            <label for="language" class="form-label">Language</label>
                            <select class="form-select" id="language">
                                <option selected>Select language</option>
                                <option value="english">English</option>
                                <option value="chinese">Chinese</option>
                                <option value="dutch">Dutch</option>
                            </select>
                        </div>
                        <div class="col-md-6 ticketOfTour" style="width: 50%; float:right;">
                            <label for="ticket" class="form-label">Ticket</label>
                            <select class="form-select" id="ticket">
                                <option selected>Select ticket</option>
                                <option value="adult">Single € 17.50</option>
                                <option value="child">Family € 60.00</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary applyPreferencesButton">Apply preferences</button>
                </div>
                <div class="col-md-6">
                    <div class="scrollable-tickets">
                        <?php
                        // example array of tickets
                        $tickets = array(
                            array(
                                "name" => "History Tour",
                                "guide" => "John Doe",
                                "language" => "English",
                                "time" => "10:00",
                                "spot" => "St. Bavo Church",
                                "price" => 17.50
                            ),
                            array(
                                "name" => "History Tour",
                                "guide" => "Jane Smith",
                                "language" => "English",
                                "time" => "10:00",
                                "spot" => "St.Bavo Church",
                                "price" => 17.50
                            ),
                            array(
                                "name" => "History Tour",
                                "guide" => "Jane Smith",
                                "language" => "English",
                                "time" => "10:00",
                                "spot" => "St.Bavo Church",
                                "price" => 17.50
                            ),
                            array(
                                "name" => "History Tour",
                                "guide" => "Jane Smith",
                                "language" => "English",
                                "time" => "10:00",
                                "spot" => "St.Bavo Church",
                                "price" => 17.50
                            )
                        );
                        foreach ($tickets as $ticket) { ?>
                            <div class="ticket">
                                <div class="ticket-header">
                                    <h4>
                                        <?php echo $ticket["name"]; ?>
                                    </h4>
                                    <p>
                                        Guide:
                                        <?php echo $ticket["guide"]; ?>
                                    </p>
                                </div>
                                <div class="ticket-body">
                                    <div class="ticket-info">
                                        <p><strong>Language:</strong>
                                            <?php echo $ticket["language"]; ?>
                                        </p>
                                        <p><strong>Time:</strong>
                                            <?php echo $ticket["time"]; ?>
                                        </p>
                                        <p><strong>Spot:</strong>
                                            <?php echo $ticket["spot"]; ?>
                                        </p>
                                    </div>
                                    <div class="ticket-price">
                                        <p<strong>Price:</strong>
                                            €
                                            <?php echo $ticket["price"]; ?>
                                            </p>
                                            <button class="btn btn-primary addToCartButton">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="container destinations">
            <h2 class="text-center"> During 2.5 hours, you will visit</h2>

            <div class="row">
                <div class="col-8 st-bavo-church">
                    1 of 2
                    <div>
                        <div class="row">
                            <div class="col-4">
                                <div class="ellipse"></div>
                            </div>
                            <div class="col-8">
                                <h3>St. Bavo Church</h3>
                                <p>St. Bavo's Cathedral is a Roman Catholic cathedral in Haarlem, Netherlands. It is the
                                    largest Gothic church in the country and one of the most important monuments of
                                    Dutch
                                    Gothic architecture. The church is dedicated to Saint Bavo of Ghent, the patron
                                    saint of
                                    Haarlem. The church is a UNESCO World Heritage Site.</p>

                                <button class="learn-more-btn">Learn More</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="row">
                        <div class="col-9 advertisement-drink">
                        </div>
                    </div>
                    <p class="text-center">15 min. break at Jopenkerk</p>
                </div>
            </div>
        </div>



        <footer class="foot row bottom">
        </footer>
        <script type="application/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>

        <script type="module" src="/js/foot.js"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper-core.min.js"
            integrity="sha384-6JHuUaD+LX9EBy7v/klcnSyJZ5av5AGzxR5GzC5RSIhz1ibcsCq3X9lOESL9X+M/"
            crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>