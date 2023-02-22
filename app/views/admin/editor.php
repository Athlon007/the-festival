<!DOCTYPE html>
<html>

<head>
    <title>Visit Haarlem Admin - Editor</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/editor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.tiny.cloud/1/k1ij9ynmcbqgglyj7dnenvnadfy29ad47qa4kewvc2udoshh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <h1>Editor</h1>
        </div>
        <div class="row">
            <div class="col-2 card p-0">
                <div class="card-body">
                    <h5 class="card-title">Text Pages</h5>
                    <div id="text-pages-list">
                    </div>
                </div>
            </div>
            <div class="col-10 card p-0">
                <div class="card-body">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" class="form-control mb-2" placeholder="Title">
                    <label for="banner-images" class="form-label">Banner Images</label>
                    <div class="card">
                        <div id="images" class="card-body">
                        </div>
                    </div>
                    <label for="editor" class="form-label">Content</label>
                    <textarea id="editor">Welcome to TinyMCE!</textarea>
                    <button id="submit" class="btn btn-success mt-2" onclick="onSubmit()">Save</button>
                    <button id="cancel" class="btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="/js/admin/editor.js"></script>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>