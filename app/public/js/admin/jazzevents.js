import { MsgBox } from "./modals.js";

let editedId = -1;
let editedEvent = null;
const locations = document.getElementById('locations');
const masterEditor = document.getElementById('master-editor');

// Artist fields.
const artist = document.getElementById('artist');
const locationSelect = document.getElementById('location');
const price = document.getElementById('price');
const startTime = document.getElementById('startTime');
const endTime = document.getElementById('endTime');

const btnSubmit = document.getElementById('submit');
let isInCreationMode = false;

const msgBox = new MsgBox();

let pin;


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
                msgBox.createToast('Something went wrong', data.error_message);
            }
        })
        .catch(error => {
            msgBox.createToast('Something went wrong', error);
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
            if (!data.error_message) {
                let option = createNewOptionItem(data);
                locations.appendChild(option);
                locations.selectedIndex = locations.length - 1;
                editedId = data.id;
                editedEvent = data;
                isInCreationMode = false;
                btnSubmit.innerHTML = 'Save';
                msgBox.createToast('Success!', 'Location has been created');

                // exit the new page mode
                isInCreationMode = false;
                btnSubmit.innerHTML = 'Save';
            } else {
                msgBox.createToast('Something went wrong', data.error_message);
            }
        })
        .catch(error => {
            msgBox.createToast('Something went wrong', error);
        });
}

btnSubmit.onclick = function () {
    // to json
    let data = {
        name: name.value,
        locationType: locationType.value,
        capacity: capacity.value,
        lat: lat.value,
        lon: lon.value,
        address: {
            addressId: editedAddressId,
            postalCode: postal.value,
            streetName: street.value,
            houseNumber: number.value,
            city: city.value,
            country: country.value
        }
    };

    if (data.capacity === '') {
        data.capacity = 0;
    }

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

    msgBox.createYesNoDialog('Delete page', 'Are you sure you want to delete this event? This is irreversible!', function () {
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
                    msgBox.createToast('Something went wrong', data.error_message);
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

    let name = element.name;
    let location = element.location.name;
    let dispStartTime = element.startTime.date;
    let dispEndTime = element.endTime.date;

    // make sure that name always is 15 chars long
    if (name.length > 15) {
        name = name.substring(0, 15) + '...';
    } else {
        while (name.length < 15) {
            name += '&nbsp;';
        }
    }

    // make sure that location always is 15 chars long
    if (location.length > 15) {
        location = location.substring(0, 15) + '...';
    } else {
        while (location.length < 15) {
            location += '&nbsp;';
        }
    }

    // display startTime and endTime in a following pattern: dd/mm/yyyy hh:mm
    dispStartTime = dispStartTime.substring(8, 10) + '/' + dispStartTime.substring(5, 7) + '/' + dispStartTime.substring(0, 4) + ' ' + dispStartTime.substring(11, 16);
    dispEndTime = dispEndTime.substring(8, 10) + '/' + dispEndTime.substring(5, 7) + '/' + dispEndTime.substring(0, 4) + ' ' + dispEndTime.substring(11, 16);

    option.innerHTML = name + ' | ' + location + ' | ' + dispStartTime + ' | ' + dispEndTime;

    option.value = element.id;

    // on click
    option.onclick = function () {
        toggleEditor(masterEditor, true);
        btnSubmit.innerHTML = 'Save';
        isInCreationMode = false;
        // Do the api call to get the page content.
        fetch('/api/events/jazz/' + element.id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (!data.error_message) {
                    editedId = data.id;
                    editedEvent = data;

                    // select the artist option corresponding to id in the select
                    let options = artist.getElementsByTagName('option');
                    for (let option of options) {
                        if (option.value == data.artist.id) {
                            option.selected = true;
                            break;
                        }
                    }

                    // select the location option corresponding to id in the selec
                    options = locationSelect.getElementsByTagName('option');
                    for (let option of options) {
                        if (option.value == data.location.id) {
                            option.selected = true;
                            break;
                        }
                    }


                    price.value = data.price;

                    let dateStart = new Date(data.startTime.date);
                    dateStart.setHours(dateStart.getHours() + 2);
                    dateStart = dateStart.toISOString().slice(0, 16);
                    startTime.value = dateStart;

                    let dateEnd = new Date(data.endTime.date);
                    dateEnd.setHours(dateEnd.getHours() + 2);
                    dateEnd = dateEnd.toISOString().slice(0, 16);
                    endTime.value = dateEnd;
                } else {
                    msgBox.createToast('Something went wrong', data.error_message);
                }
            })
            .catch(error => {
                msgBox.createToast('Something went wrong', error);
                console.error('Error:', error);
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
    option.innerHTML = 'Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
        '| Location&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
        ' | START&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | END';
    option.value = -1;
    option.disabled = true;
    locations.appendChild(option);

    let url = '/api/events/jazz';
    // fetch with post
    fetch(url, {
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

    // load artist list to artist select
    artist.innerHTML = '';
    let jazzSelectOption = document.createElement('option');
    jazzSelectOption.innerHTML = '-- Select Artist -- ';
    jazzSelectOption.value = -1;
    jazzSelectOption.disabled = true;
    artist.appendChild(jazzSelectOption);
    fetch('/api/artists/jazz?sort=name', {
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
                    let option = document.createElement('option');
                    option.innerHTML = element.name;
                    option.value = element.id;
                    artist.appendChild(option);
                });
            }
        }
        );
    artist.selectedIndex = 0;

    // and now, load jazz locations.
    location.innerHTML = '';
    let jazzLocationOption = document.createElement('option');
    jazzLocationOption.innerHTML = '-- Select Location -- ';
    jazzLocationOption.value = -1;
    jazzLocationOption.disabled = true;
    locationSelect.appendChild(jazzLocationOption);
    fetch('/api/locations/type/1?sort=name', {
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
                    let option = document.createElement('option');
                    option.innerHTML = element.name;
                    option.value = element.id;
                    locationSelect.appendChild(option);
                });
            }
        }
        );
    location.selectedIndex = -1;
}

loadList();

function toggleEditor(element, isEnabled) {
    if (isEnabled) {
        element.classList.remove('disabled-module');
    } else {
        element.classList.add('disabled-module');
        editedId = -1;
        editedAddressId = -1;
        artist.selectedIndex = 0;
        locationSelect.selectedIndex = 0;
        price.value = '';
        startTime.value = '';
        endTime.value = '';

        if (locations.dataset.locations != undefined) {
            locationType.value = locations.dataset.locations;
        }
    }
}

document.getElementById('new-page').onclick = function () {
    isInCreationMode = true;
    toggleEditor(masterEditor, false);
    toggleEditor(masterEditor, true);
}

if (window.self != window.top) {
    let container = document.getElementsByClassName('container')[0];
    // 1em margin on left and right
    container.style.marginLeft = '1em';
    container.style.marginRight = '1em';

    container.style.padding = '0';
    container.style.width = '90%';
    // disable max-width
    container.style.maxWidth = 'none';
}