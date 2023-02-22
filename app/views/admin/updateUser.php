<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Update User</title>
</head>

<body>
<form action="updateUser" method="POST">
    <div class="form-group">
        <label for="userID">User ID</label>
        <input type="text" class="form-control" id="userID" name="userID" value="<?php echo $user->getUserId(); ?>" readonly>
    </div>
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $user->getFirstName(); ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $user->getLastName(); ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="username">Email</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->getEmail(); ?>" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="role">Role</label>
        <input type="text" class="form-control" id="role" name="role" value="<?php if ($user->getUserType() == 3){
            ?> Editor <?php
        }?>" readonly>
    </div>
    <button type="submit" class="btn btn-primary" name="updateUserButton">Update User</button>
</form>
</body>
