<!DOCTYPE html>
<html>

<head>
    <title>Visit Haarlem Admin - Images</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/editor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.tiny.cloud/1/k1ij9ynmcbqgglyj7dnenvnadfy29ad47qa4kewvc2udoshh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>
    <?php
    if (isset($_GET["errors"])) {
        echo "<div class='alert alert-danger' role='alert'>" . $_GET["errors"] . "</div>";
    } elseif (isset($_GET["success"])) {
        echo "<div class='alert alert-success' role='alert'>Image uploaded successfully!</div>";
    }
    ?>
    <div class="container">
        <div class="row">
            <h1>Images</h1>
        </div>
        <div class="row mb-1">
            <form method="POST" action="/uploader/upload-image" class="col-12 card p-2" enctype="multipart/form-data">
                <div class="form-group p-2">
                    <label for="alt">Banner Text/Alt</label>
                    <input type="text" class="form-control" id="alt" name="alt">
                </div>
                <div class="form-group p-2">
                    <label for="">Upload Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <input type="submit" class="btn btn-primary" value="Upload">
            </form>
        </div>
        <div class="row">
            <div class="col-3 card p-1">
                <h2>Details</h2>
                <div class="w-100">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" disabled>
                    <label for="loaded-alt">Banner Text/Alt</label>
                    <input type="text" class="form-control" id="loaded-alt">
                    <label for="loaded-image">Image</label>
                    <img id="loaded-image" class="img-fluid mb-2" src="" alt="">
                    <label for="file-size">File Size (MB)</label>
                    <input type="text" class="form-control" id="file-size" disabled>
                    <label for="resolution">Resolution</label>
                    <input type="text" class="form-control" id="resolution" disabled>
                    <label for="mime-type">Mime Type</label>
                    <input type="text" class="form-control" id="mime-type" disabled>
                </div>
                <div class="m-1">
                    <button class="btn btn-primary" id="btn-save">Save</button>
                    <button class="btn btn-danger" id="btn-remove">Remove</button>
                </div>
            </div>
            <div class="col-9 card">
                <div class="card-body">
                    <label for="banner-images" class="form-label">Images</label>
                    <div class="card">
                        <div id="images" class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="module" src="/js/admin/images.js"></script>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>