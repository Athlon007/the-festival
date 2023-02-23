import { loadImagePicker, unselectAllImages } from "./image_picker.js";
import { MsgBox } from "./modals.js";

const msgBox = new MsgBox();

let images = document.getElementById("images");
loadImagePicker(images);

// listen to image-selected event
document.addEventListener('image-selected', (event) => {
    console.log(event.detail.id);
    // unselect all but the selected image
    unselectAllImages();
    let checkbox = document.querySelector(`input[value="${event.detail.id}"]`);
    checkbox.checked = true;

    // Load image details.
    fetch(`/api/images/${event.detail.id}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById('id').value = data.id;
            document.getElementById('loaded-alt').value = data.alt;
            document.getElementById('loaded-image').src = data.src;
            document.getElementById('file-size').value = (data.size * 0.000001).toFixed(2) + " MB";
            document.getElementById('resolution').value = data.resolution;
            document.getElementById('mime-type').value = data.type;
        });
});

function clearDetails() {
    // clear the details
    document.getElementById('id').value = '';
    document.getElementById('loaded-alt').value = '';
    document.getElementById('loaded-image').src = '';
    document.getElementById('file-size').value = '';
    document.getElementById('resolution').value = '';
    document.getElementById('mime-type').value = '';
}

document.addEventListener('image-unselected', (event) => {
    clearDetails();
});

document.getElementById('btn-remove').onclick = () => {
    let id = document.getElementById('id').value;
    if (id) {
        fetch(`/api/images/` + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (!data.error_message) {
                    // reload image picker
                    images.innerHTML = '';
                    loadImagePicker(images);
                    clearDetails();
                    msgBox.createToast('Success!', 'Image has been deleted');
                } else {
                    msgBox.createToast('Somethin went wrong', data.error_message);
                }
            });
    }
}

document.getElementById('btn-save').onclick = () => {
    let id = document.getElementById('id').value;
    let alt = document.getElementById('loaded-alt').value;
    if (id) {
        fetch(`/api/images/` + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "alt": alt
            }),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (!data.error_message) {
                    // reload image picker
                    images.innerHTML = '';
                    loadImagePicker(document.getElementById("images"));
                    msgBox.createToast('Success!', 'Image details have been updated');
                } else {
                    msgBox.createToast('Somethin went wrong', data.error_message);
                }
            });
    }
}