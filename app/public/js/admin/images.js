import { ImagePicker } from "./image_picker.js";
import { MsgBox } from "./modals.js";

const msgBox = new MsgBox();

let images = document.getElementById("images");
const imgPicker = new ImagePicker();
imgPicker.loadImagePicker(images, () => {
    imgPicker.unselectAllButOneNotInSelectedImages();
    let selectedImages = imgPicker.getSelectedImages();

    if (selectedImages.length > 0) {
        let data = fetch('/api/images/' + selectedImages[0], {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('id').value = data.id;
                document.getElementById('loaded-alt').value = data.alt;
                document.getElementById('loaded-image').src = data.src;
                document.getElementById('file-size').value = (data.size * 0.000001).toFixed(2) + " MB";
                document.getElementById('resolution').value = data.resolution;
                document.getElementById('mime-type').value = data.type;
                document.getElementById('btn-remove').disabled = false;
            });
    }
}, () => {
    clearDetails();
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
                if (!data.error_message) {
                    // reload image picker
                    imgPicker.loadImagePicker(images);
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
                if (!data.error_message) {
                    // reload image picker
                    imgPicker.loadImagePicker(images);
                    msgBox.createToast('Success!', 'Image details have been updated');
                } else {
                    msgBox.createToast('Somethin went wrong', data.error_message);
                }
            });
    }
}