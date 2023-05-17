<!doctype html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
    <br>
    <?php require_once(__DIR__ . '/../adminNavbar.php'); ?>
    <h1 class="text-center mt-3">Manage the Tours</h1>
    <br>

    <h3>What do you want to manage:</h3>
    <div class="menu">
        <select id="name" class="form-select" aria-label="Default select example">
            <option selected><i>--Select a section--</i></option>
            <option value="Tour">Tours</option>
            <option value="Location">Locations</option>
        </select>
    </div>

    <?php
    var_dump($historyEvents)
    ?>


    <div class="content">
        <div id="Tour" class="data">
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Language</th>
                    <th>Time</th>
                </tr>
                <tbody>
                    <?php foreach ($historyEvents as $event) : ?>
                        <tr>
                            <td>
                                <?= $event['eventName'] ?>
                            </td>
                            <td>
                                <?= $event['locationName'] ?>
                            </td>
                            <td>
                                <?= $event['price'] ?>
                            </td>
                            <td>
                                <?= $event['language'] ?>
                            </td>
                            <td>
                                <?= $event['startTime']->format('Y-m-d H:i:s') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Add button -->
            <div class="row mt-3" style="padding-right: 10%; padding-bottom: 1%">
                <div class="col-12 text-right">
                    <a href="/addTour" class="btn btn-success btn-lg">Add Tours</a>
                </div>
            </div>
        </div>
        <div id="Location" class="data">
            <iframe id="iframe" src="/admin/locations" data-locations="2" style="width: 100%; height: 900px; border: none; margin-left:1em; margin-right:1em;"></iframe>
        </div>

    </div>
    <br>
    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

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