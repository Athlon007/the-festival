<doctype html>
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
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="/manageTextPages">Text Pages</a>
            <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="/manageImages">Images</a>
            <a class="flex-sm-fill text-sm-center nav-link" aria-current="page" href="/../manageUsers">Users</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="/../manageJazz">Jazz</a>
            <a class="flex-sm-fill text-sm-center nav-link active" href="/../manageRestaurants">Restaurants</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="/../manageDJs">Dance</a>
            <a class="flex-sm-fill text-sm-center nav-link" href="/../manageHistory">History</a>
        </nav>
        <h1 class="text-center mt-3">Manage Restaurants</h1>
        <br>
        <div>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Number of Sessions</th>
                            <th>Duration of Sessions</th>
                            <th>Available seats</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($restaurants as $restaurant) { ?>
                            <tr>
                                <td data-th="Restaurant Name">
                                    <?php echo $restaurant->getRestaurantName(); ?>
                                </td>
                                <td data-th="address Id">
                                    <?php echo $restaurant->getAddressId(); ?>
                                </td>
                                <td data-th="Number of Sessions">
                                    <?php echo $restaurant->getNumOfSessions(); ?>
                                </td>
                                <td data-th="Duration of Sessions">
                                    <?php echo $restaurant->getDurationOfSessions(); ?>
                                </td>
                                <td>
                                    <form action="deleteRestaurant" method="POST">
                                        <button type="submit" name="delete_restaurant" value="<?= $user->getUserId(); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                        <a href="updateUser?id=<?php echo $user->getUserId() ?>" class="btn btn-primary">Update</a>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="row mt-3" style="padding-right: 10%; padding-bottom: 1%">
                    <div class="col-12 text-right">
                        <a href="/addRestaurant" class="btn btn-success btn-lg">Add Restautrant</a>
                    </div>
                </div>
            </div>


            <footer class="foot row bottom"></footer>
            <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

            <script type="module" src="/js/foot.js"></script>
    </body>