<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem Cart - Payment Check</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>

    <!-- Container -->
    <section class="h-100 h-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div id="checking-paymemnt" class="col-10">
                    <h2>We're checking the payment status...</h2>
                </div>
                <div id="payment-success" class="col-10 d-none">
                    <h2>Payment successful!</h2>
                    <p>Thank you for your order. You will receive an email with your tickets shortly.</p>
                    <a href="/" class="btn btn-primary">Go to home</a>
                </div>
                <div id="payment-failed" class="col-10 d-none">
                    <h2>Payment failed!</h2>
                    <p>Something went wrong with your payment. Please try again.</p>
                    <a href="/shopping-cart" class="btn btn-primary">Go to cart</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="/js/payment-success.js"></script>
    <script type="module" src="/js/foot.js"></script>
</body>

</html>