<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
    <form action="updateUser" method="POST">
        <div class="form-group">
            <label for="RestaurantId">Restaurant ID</label>
            <input type="text" class="form-control" id="userID" name="userID" value="<?php echo $restaurant->getRestaurantId(); ?>"
                readonly>
        </div>
        <div class="form-group">
            <label for="name">Restaurant Name</label>
            <input type="text" class="form-control" id="name" name="name"
                value="<?php echo $restaurant->getRestaurantName(); ?>" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="description">Restaurant Description</label>
            <input type="text" class="form-control" id="description" name="description"
                value="<?php echo $restaurant->getDescription(); ?>" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="addressId">Address</label>
            <input type="text" class="form-control" id="addressId" name="addressId"
                value="<?php echo $restaurant->getAddressId(); ?>" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="amount">Number of Sessions</label>
            <input type="number" class="form-control" id="amount" name="amount"
                value="<?php echo $restaurant->getNumOfSessions(); ?>" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="duration">Duration of the Sessions</label>
            <input type="time" class="form-control" id="duration" name="duration"
                value="<?php echo $restaurant->getDurationOfSessions(); ?>" autocomplete="off">
        </div>

        <button type="submit" class="btn btn-primary" name="updateUserButton">Update User</button>
    </form>

    <footer class="foot row bottom"></footer>
    <script type="application/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script type="module" src="/js/foot.js"></script>
</body>