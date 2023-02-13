<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name=”robots” content="index, follow">
    <title>Example</title>
</head>

<body>

<!-- Before that I need to verify the reset token -->

<?php
// if the reset token is valid, show the password reset form
?>
<form action="reset-password.php" method="post">
        <input type="hidden" name="reset_token" value="<?php echo $reset_token; ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Reset Password">
    </form>
</body>
<?php // else show the message somethign went wrong (reset token is not valid) ?>

</html>