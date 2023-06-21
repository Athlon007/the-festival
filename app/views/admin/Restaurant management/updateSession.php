<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
    <h1>Update Session</h1>
                
                <form action="editSession" method="POST">
                    <input type="text" hidden value="<?php echo $event['eventId']; ?>" name="eventId">
                <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" id="" name="eventName"                 
                        value="<?php echo $event['name']; ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="StarTime">Start Time</label>
                        <input type="datetime-local" class="form-control" id="" name="startTime"
                            value="<?php echo $event['startTime']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="EndTime">End Time</label>
                        <input type="datetime-local" class="form-control" id="" name="endTime"
                            value="<?php echo $event['endTime']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="AvailableTickets">Available Tickets</label>
                        <input type="text" class="form-control" id="" name="availableTickets"
                            value="<?php echo $event['availableTickets']; ?>" autocomplete="off">
                    </div>

                    <button type="submit" class="btn btn-primary" name="updateSessionBtn">Add Session</button>
                </form>




    <footer class="foot row bottom"></footer>
    <script type="application/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script type="module" src="/js/foot.js"></script>
</body>