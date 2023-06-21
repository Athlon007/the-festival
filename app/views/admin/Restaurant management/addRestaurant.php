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
    <h1>Add Retsaurant</h1>
                
                <form action="insertRestaurant" method="POST">
                    <div class="form-group">
                        <label for="shortDescription">name</label>
                        <input type="text" class="form-control" id="" name="restaurant_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="longDescription">Location</label>
                    <select class="form-select" name="location" id="location">
                            <?php 
                            foreach($locations as $location): ?>
                            <option value="<?= $location['locationId'] ?>"><?= $location['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recentAlbums">Description</label>
                        <input type="text" class="form-control" id="" name="description" value="">
                    </div>
                    <div class="form-group">
                        <label for="genres">Price</label>
                        <input type="text" class="form-control" id="" name="price" value="">
                    </div>
                    <div class="form-group">
                        <label for="Country">Rating</label>
                        <input type="text" class="form-control" id="" name="rating" value="">
                    </div>
                    <div class="form-group">
                        <select class="form-select" name="type" id="type">
                            <?php 
                            
                            foreach($types as $type): ?>
                            <option value="<?= $type['typeId'] ?>"><?= $type['typeName'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addRestaurantBtn">Add Restaurant</button>
                </form>

    <footer class="foot row bottom"></footer>
    <script type="application/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script type="module" src="/js/foot.js"></script>
</body>