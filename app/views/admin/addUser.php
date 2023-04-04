<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>

    <div class="container mt-2">
        <h1>Register Employee/Admin</h1>
        <div class="form-group">
            <label for="firstName" style="margin-top:15px;">First Name *</label>
            <input type="text" class="form-control" name="firstName" id="firstName" placeholder="Enter a first name" autocomplete="off">
        </div>
        <div class="form-group" style="margin-top:15px;">
            <label for="lastName">Last Name *</label>
            <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Enter a last name" autocomplete="off">
        </div>
        <div class="form-group" style="margin-top:15px;">
            <label for="email">Username *</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter the email" autocomplete="off">
        </div>
        <div>
            <label for="role" style="margin-top:15px;">Role *</label>
            <select class="form-select" name="role" id="role">
                <option value="employee">Employee</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="form-group" style="margin-top:15px;">
            <label for="password">Password *</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter a password" autocomplete="off">
        </div>
        <div class="form-group" style="margin-top:15px;">
            <label for="confirmPassword">Confirm Password *</label>
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm the password" autocomplete="off">
        </div>

        <div class="mt-3" style="margin-bottom:10px;">
            <button type="submit" class="btn btn-outline-success" name="register" onclick="addUser()">Submit</button>
        </div>

        </form>

    </div>

    <script src="../js/admin/manageUser.js"></script>

    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script type="module" src="/js/foot.js"></script>
</body>