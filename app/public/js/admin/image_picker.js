export function loadImagePicker(container) {
    container.innerHTML = '';

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
                input.classList.add('image-checkbox');

                // on input click, broadcast event
                input.addEventListener('click', (e) => {
                    if (e.target.checked) {
                        let event = new CustomEvent('image-selected', { detail: { id: element.id } });
                        document.dispatchEvent(event);
                    } else {
                        let event = new CustomEvent('image-unselected', { detail: { id: element.id } });
                        document.dispatchEvent(event);
                    }

                });

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

export function unselectAllImages() {
    let checkboxes = document.getElementsByName('image');
    checkboxes.forEach(element => {
        element.checked = false;

    });
}