<!DOCTYPE html>
<html lang="en">

<head>
    <title>Visit Haarlem Admin - Nav</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/editor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div id="master-editor" class="col-12 card p-0">
                <div class="card-body m-0">
                    <div class="row">
                        <div class="col-6">
                            <h3>Pages</h3>
                            <ul id="pages" class="list-group">
                            </ul>
                        </div>
                        <div class="col-6">
                            <h3>Navbar</h3>
                            <ul id="navs" class="list-group">
                            </ul>
                        </div>
                    </div>
                    <div class="mt-1">
                        <button id="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://johnny.github.io/jquery-sortable/js/jquery-sortable.js"></script>
    <script type="module" src="/js/admin/nav.js"></script>
</body>

</html>