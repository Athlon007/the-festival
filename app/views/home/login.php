<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
    
    <!-- Login form -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class=text-center>Log in to Visit Haarlem</h2>
                <div class="card bg-light">
                    <div class="card-body">
                        <div id=errorbox class=form-errors>
                            <ul>
                                <li id=error>Error 1</li>
                                <li id=error>Error 2</li>
                            </ul>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button id="loginButton" class="btn btn-primary" onclick=AttemptLogin()>Login</button>
                        </form>
                    </div>
                    <div class="card-footer">
                        Don't have an account yet? <a href="/home/register">Register here.</a><br>
                        <a href="/forgotpassword">Forgot password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src = "js/login.js"></script>

    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <script type="module" src="/js/foot.js"></script>
</body>

</html>