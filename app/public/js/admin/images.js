import { loadImagePicker, unselectAllImages } from "./image_picker.js";

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
    fetch(`/api/admin/images/${event.detail.id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({}), // TODO: Send API key.
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('id').value = data.id;
            document.getElementById('loaded-alt').value = data.alt;
            document.getElementById('loaded-image').src = data.src;
        });
});

document.getElementById('btn-remove').onclick = () => {
    let id = document.getElementById('id').value;
    if (id) {
        fetch(`/api/admin/images`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "action": "delete",
                "id": id
            }), // TODO: Send API key.
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success_message) {
                    // reload image picker
                    images.innerHTML = '';
                    loadImagePicker(images);
                } else {
                    // TODO: show error :)
                }
            });
    }
}

document.getElementById('btn-save').onclick = () => {
    let id = document.getElementById('id').value;
    let alt = document.getElementById('loaded-alt').value;
    if (id) {
        fetch(`/api/admin/images`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "action": "update",
                "id": id,
                "alt": alt
            }),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success_message) {
                    // reload image picker
                    images.innerHTML = '';
                    loadImagePicker(document.getElementById("images"));
                } else {
                    // TODO: Show error.
                }
            });
    }
}