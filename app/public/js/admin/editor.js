import { ImagePicker } from "./image_picker.js";
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
const imgPicker = new ImagePicker();

tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    menu: {
        custom: {
            title: 'Festival',
            items: 'customAddButtonButton customInsertImageButton customInsertNavTile customInsertMap customInsertCalendar'
        }
    },
    menubar: 'file edit view insert format tools table custom',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    table_default_attributes: {
        border: "0"
    },
    content_css: [
        "https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css",
        "/css/main.css",
        "/css/editor.css"
    ],
    setup: (editor) => {
        try {
            editor.ui.registry.addMenuItem('customAddButtonButton', {
                text: 'Add Button',
                onAction: () => {
                    msgBox.createDialogWithInputs('Add Button', [
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
            editor.ui.registry.addMenuItem('customInsertImageButton', {
                text: 'Insert Image',
                onAction: () => {
                    let rndInt = Math.floor(Math.random() * 100000000);
                    msgBox.createDialogWithInputs('Insert Image From Library', [
                        {
                            label: 'Image Picker',
                            id: 'image-picker-' + rndInt,
                            type: 'image-picker'
                        },
                        {
                            label: 'Image Width',
                            id: 'image-width',
                        },
                        {
                            label: 'Image Height',
                            id: 'image-height',
                        }],
                        function () {
                            let imagePicker = document.getElementById('image-picker-' + rndInt);
                            let selectedImage;
                            for (let label of imagePicker.getElementsByClassName('tile-picker')) {
                                let input = label.getElementsByTagName('input')[0];
                                if (input.checked) {
                                    selectedImage = label.getElementsByTagName('img')[0].src;
                                }
                            }

                            // remvoe the first part of the url before the /img
                            selectedImage = selectedImage.replace(/.*\/img/, '/img');

                            let imageWidth = document.getElementById('image-width').value;
                            let imageHeight = document.getElementById('image-height').value;

                            // if widtth and height are empty, set to auto
                            if (imageWidth == '') {
                                imageWidth = 'auto';
                            }
                            if (imageHeight == '') {
                                imageHeight = 'auto';
                            }

                            editor.insertContent(`<img src="${selectedImage}" width="${imageWidth}" height="${imageHeight}">`);
                        },
                        function () { });
                }
            });
            editor.ui.registry.addMenuItem('customInsertNavTile', {
                text: 'Insert Nav Tile',
                onAction: () => {
                    let rndInt = Math.floor(Math.random() * 100000000);
                    msgBox.createDialogWithInputs('Create Nav Tile', [
                        {
                            label: 'Image Picker',
                            id: 'image-picker-' + rndInt,
                            type: 'image-picker'
                        },
                        {
                            label: 'Tile Text',
                            id: 'tile-text'
                        },
                        {
                            label: 'Tile Link',
                            id: 'tile-link'
                        },
                        {
                            label: 'Description',
                            id: 'tile-description'
                        }
                    ],
                        () => {
                            let imagePicker = document.getElementById('image-picker-' + rndInt);
                            let selectedImage;
                            for (let label of imagePicker.getElementsByClassName('tile-picker')) {
                                let input = label.getElementsByTagName('input')[0];
                                if (input.checked) {
                                    selectedImage = label.getElementsByTagName('img')[0].src;
                                }
                            }

                            // remvoe the first part of the url before the /img
                            selectedImage = selectedImage.replace(/.*\/img/, '/img');

                            let tileText = document.getElementById('tile-text').value;
                            let tileLink = document.getElementById('tile-link').value;
                            let tileDescription = document.getElementById('tile-description').value;

                            // Now we build the tile.
                            let a = document.createElement('a');
                            a.href = tileLink;
                            let div = document.createElement('div');
                            div.classList.add('card', 'img-fluid', 'nav-tile');
                            let divCarousel = document.createElement('div');
                            divCarousel.classList.add('carousel-caption');
                            let p = document.createElement('p');
                            p.innerText = tileText;
                            divCarousel.appendChild(p);
                            div.appendChild(divCarousel);

                            let img = document.createElement('img');
                            img.src = selectedImage;
                            img.classList.add('card-img-top');
                            div.appendChild(img);

                            let cardOverlay = document.createElement('div');
                            cardOverlay.classList.add('card-img-overlay');
                            let pOverlay = document.createElement('p');
                            pOverlay.classList.add('card-text', 'w-65', 'inline-block');
                            pOverlay.innerText = tileDescription;
                            cardOverlay.appendChild(pOverlay);
                            let btn = document.createElement('button');
                            btn.classList.add('btn', 'btn-primary', 'float-end');
                            btn.innerText = 'Learn More';
                            cardOverlay.appendChild(btn);
                            div.appendChild(cardOverlay);

                            a.appendChild(div);

                            let container = document.createElement('div');
                            container.appendChild(a);

                            console.log(a.outerHTML);

                            editor.insertContent(container.outerHTML);
                        });
                }
            });
            editor.ui.registry.addMenuItem('customInsertMap', {
                text: 'Insert Map',
                onAction: () => {
                    editor.insertContent("<div id='mapContainer' class='row' data-mapkind='general'></div>");
                }
            });
            editor.ui.registry.addMenuItem('customInsertCalendar', {
                text: 'Insert Calendar',
                onAction: () => {
                    editor.insertContent("<div id='calendar' class='row'></div>");
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
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
                let option = createNewOptionItem(data);
                textPagesList.appendChild(option);
                textPagesList.selectedIndex = textPagesList.length - 1;
                editedPageId = data.id;
                isInNewPageMode = false;
                btnSubmit.innerHTML = 'Save';
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
    let pickedImageIds = imgPicker.getSelectedImages();
    console.log(pickedImageIds);
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
                    // remove the option from the list
                    let options = textPagesList.getElementsByTagName('option');
                    for (let option of options) {
                        if (option.value == editedPageId) {
                            option.remove();
                            break;
                        }
                    }
                    toggleEditor(masterEditor, false);
                    msgBox.createToast('Success!', 'Page has been deleted');
                } else {
                    msgBox.createToast('Somethin went wrong', data.error_message);
                }
            })
    }, function () { });
}


document.getElementById('cancel').onclick = function () {
    toggleEditor(masterEditor, false);
}

function createNewOptionItem(element) {
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

                    imgPicker.unselectAllImages();
                    // select images that are used by the page.
                    data.images.forEach(image => {
                        let checkboxes = document.getElementsByName('image');
                        imgPicker.selectImage(image.id);
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

    return option;
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
                let option = createNewOptionItem(element);

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

imgPicker.loadImagePicker(images, () => { }, () => { });

function toggleEditor(element, isEnabled) {
    if (isEnabled) {
        element.classList.remove('disabled-module');
    } else {
        element.classList.add('disabled-module');
        tinymce.activeEditor.setContent('');
        editedPageId = -1;
        imgPicker.unselectAllImages();
        textPagesList.selectedIndex = 0;
        title.value = '';
        pageHref.value = '';
    }
}

document.getElementById('new-page').onclick = function () {
    isInNewPageMode = true;
    toggleEditor(masterEditor, true);
    tinymce.activeEditor.setContent('');
    editedPageId = -1;
    imgPicker.unselectAllImages();
    textPagesList.selectedIndex = 0;
    title.value = '';
    pageHref.value = '';
    btnSubmit.innerHTML = 'Create';
}