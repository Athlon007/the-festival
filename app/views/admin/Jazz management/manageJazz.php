<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Manage Jazz</title>
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
        <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="/manageTextPages">Text Pages</a>
        <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="/manageImages">Images</a>
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
        <div id="Venues" class="data" style="width:95%">
            <iframe id="iframe" src="/admin/locations" data-locations="1" style="width: 100%; height: 900px; border: none; margin-left:1em; margin-right:1em;"></iframe>
        </div>

        <div id="Artist" class="data" style="width:95%">
            <iframe id="iframe" src="/admin/artists" data-kind="1" style="width: 100%; height: 900px; border: none; margin-left:1em; margin-right:1em;"></iframe>
        </div>

        <div id="Event" class="data" style="width:95%">
            <iframe id="iframe" src="/admin/jazz-events" style="width: 100%; height: 900px; border: none; margin-left:1em; margin-right:1em;"></iframe>
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