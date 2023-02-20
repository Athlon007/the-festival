let editedPageId = -1;
const title = document.getElementById('title');
const images = document.getElementById('images');

tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | customAddButtonButton',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    table_default_attributes: {
        border: "0"
    },
    content_css: [
        "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css",
        "/css/main.css"
    ],
    setup: function (editor) {
        editor.ui.registry.addButton('customAddButtonButton', {
            text: 'Add Button',
            onAction: function () {
                editor.insertContent('<button class="btn btn-primary" href="#">Button</button>');
            }
        });
    },
});

function createPopup(msg) {
    // Create bootstrap popup
    let popup = document.createElement('div');
    popup.classList.add('popup');
    popup.classList.add('alert');
    popup.classList.add('alert-success');
    popup.classList.add('alert-dismissible');
    popup.classList.add('fade');
    popup.classList.add('show');
    popup.setAttribute('role', 'alert');
    popup.innerHTML = msg;
    // show it
    document.body.appendChild(popup);
    // hide it after 3 seconds
    setTimeout(function () {
        popup.remove();
    }
        , 3000);
}



document.getElementById('submit').onclick = function () {
    let titleValue = title.value;
    let pickedImageIds = [];
    let checkboxes = document.getElementsByName('image');
    checkboxes.forEach(element => {
        if (element.checked) {
            pickedImageIds.push(element.value);
        }
    });
    let content = tinymce.activeEditor.getContent();

    // to json
    let data = {
        id: editedPageId,
        title: titleValue,
        images: pickedImageIds,
        content: content
    };

    // fetch with post
    fetch('/api/admin/text-pages/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success_message) {
                // reload list
                document.getElementById('text-pages-list').innerHTML = '';
                loadTextPagesList();
                createPopup('Page updated!');
            } else {
                console.error('Error:', data.error_message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // TODO: Show error message.
        });

}

document.getElementById('cancel').onclick = function () {
    tinymce.activeEditor.setContent('');
    editedPageId = -1;
    unselectAllImages();
}

// Load text pages from '/api/admin/text-pages'
function loadTextPagesList() {
    // fetch with post
    fetch('/api/admin/text-pages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({}), // TODO: Send API key.
    })
        .then(response => response.json())
        .then(data => {
            data.forEach(element => {
                // create option
                let a = document.createElement('a');
                a.classList.add('d-block');
                a.href = "#";
                a.innerHTML = element.title;

                // on click
                a.onclick = function () {
                    tinymce.activeEditor.setContent(element.content);
                    editedPageId = element.id;
                    title.value = element.title;

                    unselectAllImages();
                    // select images that are used by the page.
                    element.images.forEach(image => {
                        let checkboxes = document.getElementsByName('image');
                        checkboxes.forEach(element => {
                            if (element.value == image.id) {
                                element.checked = true;
                            }
                        });
                    });
                }

                // append option
                document.getElementById('text-pages-list').appendChild(a);
            })
        });
}

loadTextPagesList();

function loadImagePicker(container) {
    fetch('/api/admin/images', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({}), // TODO: Send API key.
    })
        .then(response => response.json())
        .then(data => {
            data.forEach(element => {
                let label = document.createElement('label');
                label.classList.add('brick', 'tile-picker');

                let input = document.createElement('input');
                input.type = 'checkbox';
                input.name = 'image';
                input.value = element.id;

                let img = document.createElement('img');
                img.src = element.src;
                img.alt = element.name;

                let i = document.createElement('i');
                i.classList.add('tile-checked');

                label.appendChild(input);
                label.appendChild(img);
                label.appendChild(i);

                container.appendChild(label);
            })
        });
}
loadImagePicker(images);

function unselectAllImages() {
    let checkboxes = document.getElementsByName('image');
    checkboxes.forEach(element => {
        element.checked = false;

    });
}