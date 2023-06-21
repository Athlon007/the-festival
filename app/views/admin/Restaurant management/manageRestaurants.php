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
        <?php require_once(__DIR__ . '/../adminNavbar.php'); ?>
        <h1 class="text-center mt-3">Manage Restaurants</h1>
        <br>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($restaurants as $restaurant) { ?>
                        <tr>
                            <td data-th="Restaurant Name">
                                <?php echo $restaurant->getRestaurantName(); ?>
                            </td>
                            <td data-th="address Id">
                                <?php echo $restaurant->location; ?>
                            </td>
                            <td data-th="Description">
                                <?php echo $restaurant->getDescription(); ?>
                            </td>
                            <td data-th="Price">
                                <?php echo $restaurant->getPrice(); ?>
                            </td>
                            <td data-th="Rating">
                                <?php echo $restaurant->getRating(); ?>
                            <td>
                            <button id="delete_restaurant" name="delete_restaurant" value="<?= $restaurant->getRestaurantId(); ?>" class="btn btn-danger" onclick="deleteRestaurant(<?= $restaurant->getRestaurantId(); ?>)">Delete</button>
                                <form action="deleteRestaurant" method="POST">          
                                    <a href="updateRestaurant?id=<?php echo $restaurant->getRestaurantId() ?>" class="btn btn-primary">Update</a>
                                    <a href="manageSessions?restaurantId=<?=$restaurant->getRestaurantId()?>" class="btn btn-primary">Manage Session</a>
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

        <script>
            function deleteRestaurant(restaurantId) {

                window.confirm("Are you sure you want to delete this restaurant?");

                if (confirm("Are you sure you want to delete this restaurant?")) {
                fetch('http://localhost/api/deleteRestaurants?id=' + restaurantId, {
                        method: 'DELETE',
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                    console.log("Restaurant deleted");
                    window.location.replace('/manageRestaurants');       
                } else {
                    console.log("Restaurant not deleted");
                }

            }
        </script>


        <footer class="foot row bottom"></footer>
        <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <script type="module" src="/js/foot.js"></script>
    </body>