import { loadImagePicker, unselectAllImages } from "./image_picker.js";
import { MsgBox } from "./modals.js";

let editedPageId = -1;
const title = document.getElementById('title');
const images = document.getElementById('images');
const pageHref = document.getElementById('page-href');
const textPagesList = document.getElementById('text-pages-list');
const masterEditor = document.getElementById('master-editor');

const btnSubmit = document.getElementById('submit');
let isInNewPageMode = false;

const btnOpen = document.getElementById('open');

const msgBox = new MsgBox();

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
                //editor.insertContent('<button class="btn btn-primary" href="#">Button</button>');
                let addButtonGui = msgBox.createDialogWithInputs('Add Button', [
                    {
                        label: 'Button Text',
                        id: 'btn-text'
                    },
                    {
                        label: 'Button Link',
                        id: 'btn-link'
                    }],
                    function () {
                        let btnText = document.getElementById('btn-text').value;
                        let btnLink = document.getElementById('btn-link').value;
                        editor.insertContent(`<a href="${btnLink}"><button class="btn btn-primary" href="#">${btnText}</button></a>`);
                    },
                    function () { });
            }
        });
    },
});

function updateExistingPage(id, data) {
    fetch('/api/textpages/' + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (!data.error_message) {
                loadTextPagesList();
                msgBox.createToast('Success!', 'Page has been updated');
            } else {
                msgBox.createToast('Somethin went wrong', data.error_message);
            }
        })
        .catch(error => {
            msgBox.createToast('Somethin went wrong', error);
        });
}

function createNewPage(data) {
    fetch('/api/textpages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (!data.error_message) {
                loadTextPagesList();
                msgBox.createToast('Success!', 'Page has been created');

                // exit the new page mode
                isInNewPageMode = false;
                btnSubmit.innerHTML = 'Save';
            } else {
                msgBox.createToast('Somethin went wrong', data.error_message);
            }
        })
        .catch(error => {
            msgBox.createToast('Somethin went wrong', error);
        });
}

btnSubmit.onclick = function () {
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
        title: titleValue,
        images: pickedImageIds,
        content: content,
        href: pageHref.value
    };

    if (isInNewPageMode) {
        createNewPage(data);
    } else {
        updateExistingPage(editedPageId, data);
    }
}

document.getElementById('delete').onclick = function () {
    if (editedPageId === -1) {
        msgBox.createToast('Error!', 'No page selected');
        return;
    }

    msgBox.createYesNoDialog('Delete page', 'Are you sure you want to delete this page? This is irreversible!', function () {
        // fetch with post
        fetch('/api/textpages/' + editedPageId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success_message) {
                    loadTextPagesList();
                    msgBox.createToast('Success!', 'Page has been deleted');
                } else {
                    msgBox.createToast('Somethin went wrong', data.error_message);
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
    toggleEditor(masterEditor, false);
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
    fetch('/api/textpages', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
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
                    toggleEditor(masterEditor, true);
                    btnSubmit.innerHTML = 'Save';
                    isInNewPageMode = false;
                    // Do the api call to get the page content.
                    fetch('/api/textpages/' + element.id, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.error_message) {
                                tinymce.activeEditor.setContent(data.content);
                                editedPageId = data.id;
                                title.value = data.title;

                                pageHref.value = data.href;

                                unselectAllImages();
                                // select images that are used by the page.
                                data.images.forEach(image => {
                                    let checkboxes = document.getElementsByName('image');
                                    checkboxes.forEach(img => {
                                        if (img.value == image.id) {
                                            img.checked = true;
                                        }
                                    });
                                });

                                btnOpen.onclick = function () {
                                    let link = data.href;
                                    if (link == '') {
                                        link = "http://" + window.location.hostname;
                                    }
                                    window.open(link, '_blank');
                                };
                            } else {
                                msgBox.createToast('Somethin went wrong', data.error_message);
                            }
                        })
                        .catch(error => {
                            msgBox.createToast('Somethin went wrong', error);
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

function toggleEditor(element, isEnabled) {
    if (isEnabled) {
        element.classList.remove('disabled-module');
    } else {
        element.classList.add('disabled-module');
    }
}

document.getElementById('new-page').onclick = function () {
    isInNewPageMode = true;
    toggleEditor(masterEditor, true);
    tinymce.activeEditor.setContent('');
    editedPageId = -1;
    unselectAllImages();
    textPagesList.selectedIndex = 0;
    title.value = '';
    pageHref.value = '';
    btnSubmit.innerHTML = 'Create';
}