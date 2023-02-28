export class ImagePicker {
    loadImagePicker(container, onImageSelected, onImageUnselected) {
        container.innerHTML = '';

        this.selectedImages = [];

        fetch('/api/images', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
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
                            onImageSelected();
                            if (!this.selectedImages.includes(e.target.value)) {
                                this.selectedImages.push(e.target.value);
                            }
                        } else {
                            onImageUnselected();
                            // remove from selectedImagdes
                            let index = this.selectedImages.indexOf(e.target.value);
                            if (index > -1) {
                                this.selectedImages.splice(index, 1);
                            }
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

                    this.container = container;
                })
            });
    }

    unselectAllImages() {
        const labels = this.container.querySelectorAll('label');
        labels.forEach(element => {
            let checkboxes = element.querySelectorAll('input');
            checkboxes.forEach(element => {
                element.checked = false;
                this.selectedImages = [];
            });
        });
    }

    getSelectedImages() {
        return this.selectedImages;
    }

    unselectAllButOneNotInSelectedImages() {
        const labels = this.container.querySelectorAll('label');
        labels.forEach(element => {
            let checkboxes = element.querySelectorAll('input');
            checkboxes.forEach(element => {
                if (this.selectedImages.includes(element.value)) {
                    element.checked = false;
                    this.selectedImages.splice(this.selectedImages.indexOf(element.value), 1);
                } else if (element.checked) {
                    element.checked = true;
                    if (!this.selectedImages.includes(element.value)) {
                        this.selectedImages.push(element.value);
                    }
                }

            });
        });
    }
}