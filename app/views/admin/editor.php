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
    <!-- success modal -->
    <div class=" container">
        <div class="row">
            <h1>Editor</h1>
        </div>
        <div class="row">
            <div class="col-2 card m-0">
                <div class="card-body p-0 m-0 mt-1 mh-100">
                    <button id="new-page" class="btn btn-success mb-1 w-100">New Page</button>
                    <select id="text-pages-list" class="form-select" size="20" aria-label="size 3 select example" data-live-search="true" style="overflow-y: scroll;">
                        <option data-tokens=""></option>
                    </select>
                </div>
            </div>
            <div id="master-editor" class="col-10 card p-0 disabled-module">
                <div class="card-body m-0">
                    <div class="row">
                        <div class="col-6">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" class="form-control mb-2" placeholder="Title">
                        </div>
                        <div class="col-6">
                            <label for="href" class="form-label">Link</label>
                            <input type="text" id="page-href" class="form-control mb-2" placeholder="Href">
                        </div>
                    </div>
                    <label for="banner-images" class="form-label">Banner Images</label>
                    <div class="card">
                        <div id="images" class="card-body">
                        </div>
                    </div>
                    <label for="editor" class="form-label">Content</label>
                    <textarea id="editor">Welcome to TinyMCE!</textarea>
                    <div class="mt-1">
                        <button id="submit" class="btn btn-success" onclick="onSubmit()">Save</button>
                        <button id="cancel" class="btn btn-light">Cancel</button>
                        <button id="delete" class="btn btn-danger float-end">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="module" src="/js/admin/editor.js"></script>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>