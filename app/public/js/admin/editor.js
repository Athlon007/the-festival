let editedPageId = -1;
const title = document.getElementById('title');

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



document.getElementById('submit').onclick = function () {
    let content = tinymce.activeEditor.getContent();
    alert(content);
}

document.getElementById('cancel').onclick = function () {
    tinymce.activeEditor.setContent('');
    editedPageId = -1;
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
                a.href = "#";
                a.innerHTML = element.title;
                // on click
                a.onclick = function () {
                    tinymce.activeEditor.setContent(element.content);
                    editedPageId = element.id;
                    title.value = element.title;
                }

                // append option
                document.getElementById('text-pages-list').appendChild(a);
            })
        });
}

loadTextPagesList();