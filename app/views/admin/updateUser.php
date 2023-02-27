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

    
    <!-- <form action="updateUser" method="POST"> -->
        <div class="form-group">
            <label for="userID">User ID</label>
            <input type="text" class="form-control" id="userID" name="userID" value="<?php echo $user->getUserId(); ?>"
                readonly>
        </div>
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName"
                value="<?php echo $user->getFirstName(); ?>" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName"
                value="<?php echo $user->getLastName(); ?>" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email"
                value="<?php echo $user->getEmail(); ?>" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" class="form-control" id="role" name="role" value="<?php if ($user->getUserType() == 3) {
                ?> Customer <?php
            } else if ($user->getUserType() == 2) {
                ?> User <?php
            } ?>" readonly>
        </div>
        <button id="updateUserButton" type="button" class="btn btn-primary"
            onclick="updateUser('<?= $user->getUserId(); ?>')">Update</button>
    <!-- </form> -->

    <script src="../js/admin/updateUser.js"></script>

    <footer class="foot row bottom"></footer>
    <script type="application/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script type="module" src="/js/foot.js"></script>
</body>