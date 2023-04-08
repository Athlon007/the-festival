<!DOCTYPE html>
<html lang="en">

<head>
    <title>Visit Haarlem Admin - Jazz & Music Events</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/editor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <!-- success modal -->
    <div class="container">
        <div class="row">
            <div class="col-6 card m-0">
                <div class="card-body p-0 m-0 mt-1 mh-100">
                    <button id="new-page" class="btn btn-success mb-1 w-100">New Event</button>
                    <select id="locations" class="form-select" size="25" aria-label="size 3 select example" data-live-search="true" style="overflow-y: scroll;">
                        <option data-tokens=""></option>
                    </select>
                </div>
            </div>
            <div id="master-editor" class="col-6 card p-0 disabled-module">
                <div class="card-body m-0">
                    <div class="row">
                        <div class="col-6">
                            <label for="artist" class="form-label">Artist</label>
                            <select id="artist" class="form-label d-block w-100">
                                <option value="-1" disabled selected>-- Select Artist --</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="location" class="form-label">Location</label>
                            <select id="location" class="form-label d-block w-100" required>
                                <option value="-1" disabled selected>-- Select Location --</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="ticketType" class="form-label">Ticket Type</label>
                            <select id="ticketType" class="form-label d-block w-100" required>
                                <option value="-1" disabled selected>-- Select Ticket Type --</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Time</h3>
                        <div class="col-6">
                            <label for="startTime" class="form-label">Start</label>
                            <input type="datetime-local" id="startTime" class="form-control mb-2" required>
                        </div>
                        <div class="col-6">
                            <label for="endTime" class="form-label">End</label>
                            <input type="datetime-local" id="endTime" class="form-control mb-2" required>
                        </div>
                    </div>
                    <div class="mt-1">
                        <button id="submit" class="btn btn-success">Save</button>
                        <button id="cancel" class="btn btn-secondary">Cancel</button>
                        <button id="open" class="btn btn-primary">Open</button>
                        <button id="delete" class="btn btn-danger float-end">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="module" src="/js/admin/jazzevents.js"></script>
</body>

</html>