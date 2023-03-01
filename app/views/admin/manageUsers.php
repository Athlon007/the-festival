<!doctype html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
<br>
<nav class="nav nav-pills flex-column flex-sm-row">
  <a class="flex-sm-fill text-sm-center nav-link active" aria-current="page" href="/../manageUsers">Users</a>
  <a class="flex-sm-fill text-sm-center nav-link" href="/../manageRestaurants">Restaurants</a>
  <a class="flex-sm-fill text-sm-center nav-link" href="/../manageJazz">Jazz</a>
  <a class="flex-sm-fill text-sm-center nav-link" href="/../manageHistory">History</a>
</nav>


    <div class="container-fluid">
        <h1 class="text-center mt-3">Manage Users</h1>
        <div class="row mt-3">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td data-th="User ID">
                                    <?php echo $user->getUserId(); ?>
                                </td>
                                <td data-th="Name">
                                    <?php echo $user->getFirstName(); ?>
                                </td>
                                <td data-th="Last Name">
                                    <?php echo $user->getLastName(); ?>
                                </td>
                                <td data-th="Email">
                                    <?php echo $user->getEmail(); ?>
                                </td>
                                <td data-th="Email">
                                    <?php echo $user->getUserType(); ?>
                                </td>
                                <?php if ($user->getUserType() == 3) {
                                    ?>
                                    <td>Editor/User</td>
                                <?php
                                } ?>
                                <td>
                                    <form action="deleteUser" method="POST">
                                        <button type="submit" name="delete_user" value="<?= $user->getUserId(); ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                        <a href="updateUser?id=<?php echo $user->getUserId() ?>"
                                            class="btn btn-primary">Update</a>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <!-- Add User/Customer button -->
                <div class="row mt-3" style="padding-right: 10%; padding-bottom: 1%">
                    <div class="col-12 text-right">
                        <a href="/home/register" class="btn btn-success btn-lg">Add User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="foot row bottom"></footer>
    <script type="application/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script type="module" src="/js/foot.js"></script>
</body>