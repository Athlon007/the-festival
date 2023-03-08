import { MsgBox } from "./modals.js";

let editedId = -1;
const locations = document.getElementById('locations');
const masterEditor = document.getElementById('master-editor');

// Artist fields.
const name = document.getElementById('name');
const postal = document.getElementById('postal');
const street = document.getElementById('street');
const number = document.getElementById('number');
const city = document.getElementById('city');
const country = document.getElementById('country');
const lat = document.getElementById('lat');
const lon = document.getElementById('lon');

const btnSubmit = document.getElementById('submit');
let isInCreationMode = false;

const msgBox = new MsgBox();


function updateExistingEntry(id, data) {
    fetch('/api/locations/' + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (!data.error_message) {
                loadList();
                msgBox.createToast('Success!', 'Location has been updated');
            } else {
                msgBox.createToast('Somethin went wrong', data.error_message);
            }
        })
        .catch(error => {
            msgBox.createToast('Somethin went wrong', error);
        });
}

function createNewEntry(data) {
    fetch('/api/locations', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (!data.error_message) {
                let option = createNewOptionItem(data);
                locations.appendChild(option);
                locations.selectedIndex = locations.length - 1;
                editedId = data.id;
                isInCreationMode = false;
                btnSubmit.innerHTML = 'Save';
                msgBox.createToast('Success!', 'Location has been created');

                // exit the new page mode
                isInCreationMode = false;
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
    // to json
    let data = {
        name: name.value,
        locationType: locationType.value,
        lon: lon.value,
        lat: lat.value,
        address: {
            postalCode: postal.value,
            streetName: street.value,
            houseNumber: number.value,
            city: city.value,
            country: country.value
        }
    };

    if (isInCreationMode) {
        createNewEntry(data);
    } else {
        updateExistingEntry(editedId, data);
    }
}

document.getElementById('delete').onclick = function () {
    if (editedId === -1) {
        msgBox.createToast('Error!', 'No page selected');
        return;
    }

    msgBox.createYesNoDialog('Delete page', 'Are you sure you want to delete this location? This is irreversible!', function () {
        // fetch with post
        fetch('/api/locations/' + editedId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success_message) {
                    // remove the option from the list
                    let options = locations.getElementsByTagName('option');
                    for (let option of options) {
                        if (option.value == editedId) {
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
    option.innerHTML = element.name;
    option.value = element.id;

    // on click
    option.onclick = function () {
        toggleEditor(masterEditor, true);
        btnSubmit.innerHTML = 'Save';
        isInCreationMode = false;
        // Do the api call to get the page content.
        fetch('/api/locations/' + element.id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (!data.error_message) {
                    console.log(data);
                    editedId = data.id;
                    name.value = data.name;
                    postal.value = data.address.postalCode;
                    street.value = data.address.streetName;
                    city.value = data.address.city;
                    number.value = data.address.houseNumber;
                    country.value = data.address.country;
                    lat.value = data.lat;
                    lon.value = data.lon;
                    locationType.value = data.locationType;
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
function loadList() {
    let lastSelectedId = locations.value;

    locations.innerHTML = '';
    let toSelect = -1;

    // Add empty unselected option
    let option = document.createElement('option');
    option.innerHTML = 'Select Location';
    option.value = -1;
    option.disabled = true;
    locations.appendChild(option);

    // fetch with post
    fetch('/api/locations', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            // check if data is array
            if (Array.isArray(data)) {
                data.forEach(element => {
                    let option = createNewOptionItem(element);

                    // append option
                    locations.appendChild(option);

                    // if last selected
                    // add a delay to make sure that the option is added to the list.
                    if (lastSelectedId == element.id) {
                        toSelect = locations.options.length - 1;
                    }
                });

                // select last selected
                if (toSelect != -1) {
                    locations.selectedIndex = toSelect;
                }
            }
        });
}

loadList();

function toggleEditor(element, isEnabled) {
    if (isEnabled) {
        element.classList.remove('disabled-module');
    } else {
        element.classList.add('disabled-module');
        editedId = -1;
        name.value = '';
        postal.value = '';
        street.value = '';
        city.value = '';
        number.value = '';
        country.value = '';
        lat.value = '';
        lon.value = '';
    }
}

document.getElementById('new-page').onclick = function () {
    isInCreationMode = true;
    toggleEditor(masterEditor, true);
    editedId = -1;
    locations.selectedIndex = 0;
    title.value = '';
    pageHref.value = '';
    btnSubmit.innerHTML = 'Create';
}


function fetchAddress() {
    let postalCode = postal.value.replace(" ", "");
    let houseNumber = number.value;

    if (postalCode.length < 6 || houseNumber.length < 1) {
        return;
    }

    let sendData = {
        postalCode: postalCode,
        houseNumber: houseNumber
    }

    fetch("/api/address/fetch-address", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(sendData)
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.message != null) {
                street.value = "";
                city.value = "";
                country.value = "";
            }
            else {
                street.value = data.street;
                city.value = data.city;
                country.value = "Netherlands";

                fetchGeocode();
            }
        });
}

function fetchGeocode() {

    fetch("/api/locations/geocode?street="
        + street.value + "&number=" + number.value + "&postal=" + postal.value + "&city=" + city.value,
        {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.message != null) {
                lat.value = "";
                lon.value = "";
            }
            else {
                lat.value = data.lat;
                lon.value = data.lon;
            }
        });
}

// on postal unselected
number.onblur = function () {
    fetchAddress();
}
postal.onblur = function () {
    fetchAddress();
}