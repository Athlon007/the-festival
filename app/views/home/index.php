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
    <p>Hello, world!</p>

    <form method="POST" action="/resetPassword">
    <label for="email">Email Address</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="Enter email address.." autocomplete="off">
    <button type="submit" name="submitEmail" class="btn btn-primary">Reset Password</button>
    </form>
</body>

</html>