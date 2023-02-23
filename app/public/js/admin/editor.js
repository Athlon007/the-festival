import { loadImagePicker, unselectAllImages } from "./image_picker.js";

let editedPageId = -1;
const title = document.getElementById('title');
const images = document.getElementById('images');
const pageHref = document.getElementById('page-href');
const textPagesList = document.getElementById('text-pages-list');

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

function createToast(header, msg) {
    // Create bootstrap toast
    let toast = document.createElement('div');
    toast.classList.add('toast');
    toast.style.position = 'absolute';
    toast.style.zIndex = 9999;
    toast.style.left = '30px';
    toast.style.top = '30px';
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.setAttribute('data-bs-delay', '3000');
    toast.setAttribute('data-bs-autohide', 'true');

    // Create header
    let toastHeader = document.createElement('div');
    toastHeader.classList.add('toast-header');
    toastHeader.innerHTML = header;

    // Create body
    let toastBody = document.createElement('div');
    toastBody.classList.add('toast-body');
    toastBody.innerHTML = msg;

    // Append header and body to toast
    toast.appendChild(toastHeader);
    toast.appendChild(toastBody);

    // Append toast to the beginning of the body
    document.body.insertBefore(toast, document.body.firstChild);

    // Show toast
    let toastElement = new bootstrap.Toast(toast);
    toastElement.show();
}

function createYesNoDialog(header, msg, yesCallback, noCallback) {
    // Create bootstrap modal
    let modal = document.createElement('div');
    modal.classList.add('modal');
    modal.setAttribute('tabindex', '-1');

    // Create modal dialog
    let modalDialog = document.createElement('div');
    modalDialog.classList.add('modal-dialog');
    modal.appendChild(modalDialog);

    // Create modal content
    let modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');
    modalDialog.appendChild(modalContent);

    // Create modal header
    let modalHeader = document.createElement('div');
    modalHeader.classList.add('modal-header');
    modalContent.appendChild(modalHeader);

    // Create modal title
    let modalTitle = document.createElement('h5');
    modalTitle.classList.add('modal-title');
    modalTitle.innerHTML = header;
    modalHeader.appendChild(modalTitle);

    // Create modal body
    let modalBody = document.createElement('div');
    modalBody.classList.add('modal-body');
    modalContent.appendChild(modalBody);
    let modalBodyP = document.createElement('p');
    modalBodyP.innerHTML = msg;
    modalBody.appendChild(modalBodyP);

    // Create modal footer
    let modalFooter = document.createElement('div');
    modalFooter.classList.add('modal-footer');
    modalContent.appendChild(modalFooter);

    // Show modal
    let modalElement = new bootstrap.Modal(modal);
    modalElement.show();

    // Create yes button
    let yesButton = document.createElement('button');
    yesButton.classList.add('btn', 'btn-primary');
    yesButton.innerHTML = 'Yes';
    yesButton.onclick = function () {
        yesCallback();
        modalElement.hide();
    }
    modalFooter.appendChild(yesButton);

    // Create no button
    let noButton = document.createElement('button');
    noButton.classList.add('btn', 'btn-secondary');
    noButton.innerHTML = 'No';
    noButton.onclick = function () {
        noCallback();
        modalElement.hide();
    }
    modalFooter.appendChild(noButton);

    // Append modal to the beginning of the body
    document.body.insertBefore(modal, document.body.firstChild);

    // Focus on no button
    noButton.focus();
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
                loadTextPagesList();
                createToast('Success!', 'Page has been updated');
            } else {
                console.error('Error:', data.error_message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // TODO: Show error message.
        });
}

document.getElementById('delete').onclick = function () {
    if (editedPageId === -1) {
        createToast('Error!', 'No page selected');
        return;
    }

    createYesNoDialog('Delete page', 'Are you sure you want to delete this page? This is irreversible!', function () {
        // fetch with post
        fetch('/api/text-pages', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: editedPageId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success_message) {
                    loadTextPagesList();
                    createToast('Success!', 'Page has been deleted');
                } else {
                    console.error('Error:', data.error_message);
                }
            })
    }, function () { });
}


document.getElementById('cancel').onclick = function () {
    tinymce.activeEditor.setContent('');
    editedPageId = -1;
    unselectAllImages();
    textPagesList.selectedIndex = 0;
    title.value = '';
    pageHref.value = '';
}

// Load text pages from '/api/admin/text-pages'
function loadTextPagesList() {
    let lastSelectedId = textPagesList.value;

    textPagesList.innerHTML = '';
    let toSelect = -1;

    // Add empty unselected option
    let option = document.createElement('option');
    option.innerHTML = 'Select page';
    option.value = -1;
    option.disabled = true;
    textPagesList.appendChild(option);

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
                let option = document.createElement('option');
                option.innerHTML = element.title;
                option.value = element.id;

                // on click
                option.onclick = function () {
                    tinymce.activeEditor.setContent(element.content);
                    editedPageId = element.id;
                    title.value = element.title;

                    pageHref.value = element.href;

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
                textPagesList.appendChild(option);

                // if last selected
                // add a delay to make sure that the option is added to the list.
                if (lastSelectedId == element.id) {
                    toSelect = textPagesList.options.length - 1;
                }
            });

            // select last selected
            if (toSelect != -1) {
                textPagesList.selectedIndex = toSelect;
            }
        });
}

loadTextPagesList();

loadImagePicker(images);