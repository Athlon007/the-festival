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
    <form action="editRestaurant" method="POST">
        <div class="form-group">
            <label for="RestaurantId">Restaurant ID</label>
            <input type="text" class="form-control" id="userID" name="id" value="<?php echo $restaurant['restaurantId']; ?>"
                readonly>
        </div>
        <div class="form-group">
            <label for="name">Restaurant Name</label>
            <input type="text" class="form-control" id="name" name="name"
                value="<?php echo $restaurant['restaurantName']; ?>" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="description">Restaurant Description</label>
            <input type="text" class="form-control" id="description" name="description"
                value="<?php echo $restaurant['description']; ?>" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="description">Price</label>
            <input type="text" class="form-control" id="price" name="price"
                value="<?php echo $restaurant['price']; ?>" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="addressId">Address</label>
            <input type="text" class="form-control" id="addressId" name="location"
                value="<?php echo $restaurant['addressId']; ?>" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="rating">Rating</label>
            <input type="text" class="form-control" id="addressId" name="rating"
                value="<?php echo $restaurant['rating']; ?>" autocomplete="off">
        </div>        
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="addressId" name="type"
                value="<?php echo $restaurant['typeId']; ?>" autocomplete="off">
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