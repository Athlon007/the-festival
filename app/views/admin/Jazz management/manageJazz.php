<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/management.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
    <br>
    <nav class="nav nav-pills flex-column flex-sm-row">
        <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="/../manageUsers">Users</a>
        <a class="flex-sm-fill text-sm-center nav-link active" href="/../manageJazz">Jazz</a>
        <a class="flex-sm-fill text-sm-center nav-link" href="/../manageRestaurants">Restaurants</a>
        <a class="flex-sm-fill text-sm-center nav-link" href="/../manageDJs">Dance</a>
        <a class="flex-sm-fill text-sm-center nav-link" href="/../manageHistory">History</a>
    </nav>

    <h1 class="text-center mt-3">Manage Jazz</h1>
    <br>
    <h3>What do you want to manage:</h3>
    <div class="menu">
        <select id="name" class="form-select" aria-label="Default select example" onchange="changeContent()">
            <option selected><i>--Select a section--</i></option>
            <option value="Venues">Venues</option>
            <option value="Artist">Artist</option>
            <option value="Event">Event</option>
        </select>
    </div>


    <div class="content">
        <div id="Venues" class="data">
            <div class="row">
                <div class="col-2 card m-0">
                    <div class="card-body p-0 m-0 mt-1 mh-100">
                        <button id="new-page" class="btn btn-success mb-1 w-100">Add Location</button>
                        <select id="locations" class="form-select" size="25" aria-label="size 3 select example" data-live-search="true" style="overflow-y: scroll;" data-locations="1">
                        </select>
                    </div>
                </div>
                <div id="master-editor" class="col-10 card p-0 disabled-module">
                    <div class="card-body m-0">
                        <div class="row">
                            <div class="col-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name-place" class="form-control" placeholder="Name">
                            </div>
                            <div class="col-6">
                                <label for="locationType" class="form-label">Location Type</label>
                                <select id="locationType" class="form-label d-block w-100">
                                    <option value="-1" disabled selected>-- Select Type --</option>
                                    <option value="1">Jazz</option>
                                    <option value="2">Restaurant</option>
                                    <option value="3">History</option>
                                    <option value="99">Unknown</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="postal" class="form-label">Postal Code</label>
                                <input type="text" id="postal" class="form-control mb-2" placeholder="2015 CE" required>
                            </div>
                            <div class="col-6">
                                <label for="number" class="form-label">Building Number</label>
                                <input type="text" id="number" class="form-control mb-2" placeholder="15" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="street" class="form-label">Street Name</label>
                                <input type="text" id="street" class="form-control mb-2" placeholder="Bijdroplaan">
                            </div>
                            <div class="col-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" id="city" class="form-control mb-2" placeholder="Haarlem">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" id="country" class="form-control mb-2" placeholder="Netherlands">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="lon" class="form-label">Longtitude</label>
                                <input type="number" id="lon" class="form-control mb-2" placeholder="0" disabled>
                            </div>
                            <div class="col-6">
                                <label for="lat" class="form-label">Latitude</label>
                                <input type="number" id="lat" class="form-control mb-2" placeholder="0" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div id="map" style="height:400px"></div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" id="capacity" class="form-control mb-2" placeholder="0"></input>
                            </div>
                        </div>
                        <div class="mt-1">
                            <button id="submit" class="btn btn-success">Save</button>
                            <button id="cancel" class="btn btn-secondary">Cancel</button>
                            <button id="delete" class="btn btn-danger float-end">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="Artist" class="data">
            <table class="table">
                <tr>
                    <th>Short description</th>
                    <th>Long description</th>
                    <th>Recent Albums</th>
                    <th>Genres</th>
                    <th>Country</th>
                    <th>Homepage</th>
                    <th>Facebook Page</th>
                    <th>Instagram Page</th>
                    <th>Spotify Page</th>
                </tr>
            </table>
            <!-- Add button -->
            <div class="row mt-3" style="padding-right: 10%; padding-bottom: 1%">
                <div class="col-12 text-right">
                    <a href="/addArtist" class="btn btn-success btn-lg">Add Artist</a>
                </div>
            </div>
        </div>

        <div id="Event" class="data">
            <table class="table">
                <tr>
                    <th>Artist</th>
                    <th>Venue</th>
                    <th>Price</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </table>
            <!-- Add button -->
            <div class="row mt-3" style="padding-right: 10%; padding-bottom: 1%">
                <div class="col-12 text-right">
                    <a href="/addEvent" class="btn btn-success btn-lg">Add Event</a>
                </div>
            </div>
        </div>

    </div>
    <br>
    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="application/javascript" src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script type="module" src="/js/admin/locations.js"></script>
    <script type="module" src="/js/foot.js"></script>
    <script>
        $(document).ready(function() {
            $("#name").on("change", function() {
                    //alert($(this).val());
                    $(".data").hide();
                    $("#" + $(this).val()).fadeIn(700);
                })
                .change();
        });
    </script>
</body>