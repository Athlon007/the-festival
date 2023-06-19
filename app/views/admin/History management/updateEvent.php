<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Update Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>

    <div class="container">
        <h1>Update History Event # <? echo $historyEvent->getId(); ?></h1>

        <form action="/api/events/stroll" method="POST" id="add-event-form">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="<?php echo $historyEvent->getName(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="startTime" class="form-label">Start Time:</label>
                <input type="datetime-local" class="form-control" id="startTime" name="start_time" required>
            </div>
            <div class="mb-3">
                <label for="endTime" class="form-label">End Time:</label>
                <input type="datetime-local" class="form-control" id="endTime" name="end_time" required>
            </div>
            <div class="mb-3">
                <label for="guide" class="form-label">Guide:</label>
                <select class="form-select" id="guide" name="guide" required>
                    <option value="" selected disabled>Select a guide</option>
                    <!-- Populate options from the database -->
                    <?php foreach ($guides as $guide) { ?>
                        <option value="<?php echo $guide->getGuideId(); ?>"><?php echo $guide->getFirstName() . ' ' . $guide->getLastName() . ' (' . $guide->getLanguage() . ')'; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <select class="form-select" id="location" name="location" required>
                    <option value="" selected disabled>Select a Location</option>
                    <!-- Populate options from the database -->
                    <?php foreach ($locations as $location) { ?>
                        <option value="<?php echo $location->getLocationId(); ?>"><?php echo "[" . $location->getLocationTypeAsString() . "] " . $location->getName(); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="ticketType" class="form-label">Ticket Type:</label>
                <select class="form-select" id="ticketType" name="ticketType" required>
                    <option value="" selected disabled>Select a Ticket Type</option>
                    <!-- Populate options from the database -->
                    <?php foreach ($ticketTypes as $ticketType) { ?>
                        <option value="<?php echo $ticketType->getId(); ?>"><?php echo $ticketType->getName() . ' ' . $ticketType->getPrice() ?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="available_tickets" class="form-label">Available Tickets:</label>
                <input type="number" class="form-control" id="available_tickets" name="available_tickets"
                    placeholder="<?php echo $historyEvent->getAvailableTickets(); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Event</button>
        </form>
    </div>

    <footer class="foot row bottom"></footer>

    <script type="module" src="/js/nav.js"></script>
    <script type="module" src="/js/foot.js"></script>
</body>