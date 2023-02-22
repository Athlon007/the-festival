<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Manage Users</title>
</head>

<body>
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
                        <td data-th="User ID"><?php echo $user->getUserId(); ?></td>
                        <td data-th="Name"><?php echo $user->getFirstName(); ?></td>
                        <td data-th="Last Name"><?php echo $user->getLastName(); ?></td>
                        <td data-th="Email"><?php echo $user->getEmail(); ?></td>
                        <td data-th="Email"><?php echo $user->getUserType(); ?></td>
                        <?php if ($user->getUserType() == 3){
                            ?><td>Editor/User</td><?php
                        }?>
                        <td>
                            <form action="deleteUser" method="POST">
                                <button type="submit" name="delete_user" value="<?=$user->getUserId();?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                <a href="updateUser?id=<?php echo $user->getUserId() ?>" class="btn btn-primary">Update</a>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <!-- Add User/Customer button -->
            <div class="row mt-3" style="padding-right: 10%; padding-bottom: 1%">
                <div class="col-12 text-right">
                    <a href="register" class="btn btn-success btn-lg">Add User</a> // TODO: here redirect to register page
                </div>
            </div>
        </div>
    </div>
</div>
</body>