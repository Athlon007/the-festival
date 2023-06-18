<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Add Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>

    <div class="container">
        <h1>Add an Event</h1>

        <form action="/api/events/stroll" method="POST" id="add-event-form">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
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
                        <option value="<?php echo $location->getLocationId(); ?>"><?php echo $location->getName(); ?>
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
                <input type="number" class="form-control" id="available_tickets" name="available_tickets" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Event</button>
        </form>
    </div>

    <footer class="foot row bottom"></footer>

    <script type="module" src="/js/nav.js"></script>
    <script type="module" src="/js/foot.js"></script>
    <script>
        document.getElementById('add-event-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting normally
            if (validateInputs()) {
                submitForm();
            }
        });

        function submitForm() {
            var form = document.getElementById('add-event-form');
            var formData = new FormData(form);
            var data = {};
            formData.forEach(function(value, key) {
                data[key] = value;
            });

            // Make sure that the numbers are not strings
            for (var key in data) {
                if (!isNaN(data[key])) {
                    // Convert to number
                    data[key] = Number(data[key]);
                }
            }

            console.log(data);
            return;
            fetch("/api/events/stroll", {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data),
                }).then(res => res.json())
                .then(data => {
                    if (data.success_message) {
                        alert(data.success_message)
                    } else {
                        alert(data.error_message)
                    }
                })
        }

        function validateInputs() {
            var nameInput = document.getElementById('name');
            var startTimeInput = document.getElementById('startTime');
            var endTimeInput = document.getElementById('endTime');
            var guideInput = document.getElementById('guide');
            var locationInput = document.getElementById('location');
            var availableTicketsInput = document.getElementById('available_tickets');
            var ticketTypeInput = document.getElementById('ticketType');

            // Validate name (ensure it is not empty)
            if (nameInput.value.trim() === '') {
                alert('Please enter a name.');
                nameInput.focus();
                return false;
            }

            // Validate start time (ensure it is in the correct format)
            var startTime = new Date(startTimeInput.value);
            if (isNaN(startTime)) {
                alert('Please enter a valid start time.');
                startTimeInput.focus();
                return false;
            }

            // Validate end time (ensure it is in the correct format)
            var endTime = new Date(endTimeInput.value);
            if (isNaN(endTime)) {
                alert('Please enter a valid end time.');
                endTimeInput.focus();
                return false;
            }

            // Validate available tickets (ensure it is a positive integer)
            var availableTickets = parseInt(availableTicketsInput.value);
            if (isNaN(availableTickets) || availableTickets <= 0) {
                alert('Please enter a valid number of available tickets.');
                availableTicketsInput.focus();
                return false;
            }

            // All inputs are valid
            return true;
        }
    </script>

    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>