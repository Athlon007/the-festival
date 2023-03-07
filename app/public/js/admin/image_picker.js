export class ImagePicker {
    loadImagePicker(container, onImageSelected, onImageUnselected) {
        container.innerHTML = '';
        this.container = container;

        // Load search bar
        let searchBar = document.createElement('div');
        searchBar.classList.add('search-bar');
        searchBar.innerHTML = `<input type="text" class="form-input w-100" name="search" id="search" placeholder="Search images...">`;
        // when clicking enter, search for images
        searchBar.addEventListener('keyup', (e) => {
            if (e.keyCode === 13) {
                e.preventDefault();
                let search = searchBar.querySelector('input').value;
                this.loadImages('/api/images?search=' + search);
            }
        });
        container.appendChild(searchBar);


        this.imageContainer = document.createElement('div')
        container.appendChild(this.imageContainer);
        this.selectedImages = [];

        this.loadImages('/api/images');
    }

    loadImages(request) {
        this.imageContainer.innerHTML = '';
        fetch(request, {
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

                    this.imageContainer.appendChild(label);
                })
            })
            .then(() => {
                this.restoreLastSelectedImages();
            });


    }

    unselectAllImages() {
        const labels = this.imageContainer.querySelectorAll('label');
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

    restoreLastSelectedImages() {
        for (let image of this.selectedImages) {
            this.selectImage(image);
        }
    }

    unselectAllButOneNotInSelectedImages() {
        const labels = this.imageContainer.querySelectorAll('label');
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

    selectImage(id) {
        const labels = this.imageContainer.querySelectorAll('label');
        labels.forEach(element => {
            let checkboxes = element.querySelectorAll('input');
            checkboxes.forEach(element => {
                if (element.value == id) {
                    element.checked = true;
                    if (!this.selectedImages.includes(element.value)) {
                        this.selectedImages.push(element.value);
                    }
                }
            });
        });
    }
}