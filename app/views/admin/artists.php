<!DOCTYPE html>
<html>

<head>
    <title>Visit Haarlem Admin - Artists</title>
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
            <h1>Artists</h1>
        </div>
        <div class="row">
            <div class="col-2 card m-0">
                <div class="card-body p-0 m-0 mt-1 mh-100">
                    <button id="new-page" class="btn btn-success mb-1 w-100">Add Artist</button>
                    <select id="artists" class="form-select" size="25" aria-label="size 3 select example" data-live-search="true" style="overflow-y: scroll;">
                        <option data-tokens=""></option>
                    </select>
                </div>
            </div>
            <div id="master-editor" class="col-10 card p-0 disabled-module">
                <div class="card-body m-0">
                    <div class="row">
                        <div class="col-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="row">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" class="form-control"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" id="country" class="form-control mb-2" placeholder="Country">
                        </div>
                        <div class="col-6">
                            <label for="genres" class="form-label">Genres</label>
                            <input type="text" id="genres" class="form-control mb-2" placeholder="Genres (comma separated)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="text" id="facebook" class="form-control mb-2" placeholder="Link">
                        </div>
                        <div class="col-6">
                            <label for="twitter" class="form-label">Twitter</label>
                            <input type="text" id="twitter" class="form-control mb-2" placeholder="Link">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="text" id="instagram" class="form-control mb-2" placeholder="Link">
                        </div>
                        <div class="col-6">
                            <label for="spotify" class="form-label">Spotify</label>
                            <input type="text" id="spotify" class="form-control mb-2" placeholder="Link">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="albums" class="form-label">Recent Albums</label>
                            <input type="text" id="albums" class="form-control mb-2" placeholder="Recent Albums (comma separated)">
                        </div>
                        <div class="col-6"></div>
                    </div>
                    <label for="banner-images" class="form-label">Images</label>
                    <div class="card">
                        <div id="images" class="card-body">
                        </div>
                    </div>
                    <div class="mt-1">
                        <button id="submit" class="btn btn-success">Save</button>
                        <button id="cancel" class="btn btn-secondary">Cancel</button>
                        <button id="open" class="btn btn-primary">Open In New Tab</button>
                        <button id="delete" class="btn btn-danger float-end">Delete Artist</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="module" src="/js/admin/artists.js"></script>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>