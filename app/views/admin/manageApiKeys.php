<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#fffbfa">
    <meta name="robots" content="noindex, nofollow">
    <title>Visit Haarlem - Navigation Bar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/management.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
    <script type="module" src="/js/nav.js"></script>
    <br>
    <?php require_once(__DIR__ . '/adminNavbar.php'); ?>

    <h1 class="text-center mt-3">Manage API Keys</h1>
    <div class="content">
        <div class="row mx-4">
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Token</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($apiKeys as $apiKey) {
                    ?>
                        <tr>
                            <td><?php echo $apiKey->getToken(); ?></td>
                            <td><?php echo $apiKey->getName(); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?php echo $apiKey->getId(); ?>">
                                    <input type="hidden" name="action" value="DELETE">
                                    <button type="submit" class="btn btn-danger">Revoke</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-4">
                <form method="POST">
                    <h3>Create new API key</h3>
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Name" class="form-control">
                    <input type="hidden" name="action" value="POST">
                    <button type="submit" class="btn btn-primary mt-3">Create</button>
                </form>
            </div>
        </div>
    </div>
    <br>
    <footer class="foot row bottom"></footer>
    <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="application/javascript" src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script type="module" src="/js/foot.js"></script>
</body>