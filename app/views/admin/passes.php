<!DOCTYPE html>
<html lang="en">

<head>
    <title>Visit Haarlem Admin - Passes</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/editor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-3 card m-0">
                <div class="card-body p-0 m-0 mt-1 mh-100">
                    <button id="new-page" class="btn btn-success mb-1 w-100">New Ticket Type</button>
                    <select id="locations" class="form-select" size="25" aria-label="size 3 select example" data-live-search="true" style="overflow-y: scroll;">
                        <option data-tokens=""></option>
                    </select>
                </div>
            </div>
            <div id="master-editor" class="col-9 card p-0 disabled-module">
                <div class="card-body m-0">
                    <div class="row">
                        <div class="col-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control mb-2" placeholder="Name" required>
                        </div>
                        <div class="col-6">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" id="price" class="form-control mb-2" placeholder="15" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" class="form-control mb-2" placeholder="15" required>
                        </div>
                        <div class="col-6">
                            <label for="date" class="form-label">Festival Event Type</label>
                            <select id="festival-event-type" class="form-select" aria-label="Default select example">
                                <option value="0">All</option>
                            </select>
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
    </div>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="module" src="/js/admin/passes.js"></script>
</body>

</html>