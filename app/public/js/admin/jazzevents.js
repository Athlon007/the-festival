if (window.frameElement == null) {
    window.location.href = '/manageJazz';
}

import { MsgBox } from "./modals.js";

let editedId = -1;
let editedEvent = null;
const locations = document.getElementById('locations');
const masterEditor = document.getElementById('master-editor');
const btnOpen = document.getElementById('open');

// Artist fields.
const artist = document.getElementById('artist');
const locationSelect = document.getElementById('location');
const price = document.getElementById('price');
const startTime = document.getElementById('startTime');
const endTime = document.getElementById('endTime');

const btnSubmit = document.getElementById('submit');
let isInCreationMode = false;

const msgBox = new MsgBox();

const maxNameLength = 12;
const maxLocationLength = 15;

let baseURL = '/api/events/';
if (window.frameElement != null && window.frameElement.getAttribute('data-kind') != undefined) {
    baseURL += window.frameElement.getAttribute('data-kind');
} else {
    baseURL += "jazz";
}

function updateExistingEntry(id, data) {
    fetch(baseURL + "/" + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (!data.error_message) {

                // update the option in the list
                let options = locations.getElementsByTagName('option');
                for (let option of options) {
                    if (option.value == editedId) {
                        // remove the option from the list
                        option.remove();
                        break;
                    }
                }

                // create new option
                let option = createNewOptionItem(data);
                locations.appendChild(option);
                locations.selectedIndex = locations.length - 1;
                editedId = data.id;
                editedEvent = data;
                isInCreationMode = false;
                btnSubmit.innerHTML = 'Save';

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
    fetch(baseURL, {
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
    let start = new Date(startTime.value);
    start = start.getFullYear() + '-' + (start.getMonth() + 1) + '-' + start.getDate() + ' ' + start.getHours() + ':' + start.getMinutes() + ':' + start.getSeconds();

    let end = new Date(endTime.value);
    end = end.getFullYear() + '-' + (end.getMonth() + 1) + '-' + end.getDate() + ' ' + end.getHours() + ':' + end.getMinutes() + ':' + end.getSeconds();

    // to json
    let data = {
        id: 0,
        name: artist.options[artist.selectedIndex].text,
        startTime: start,
        endTime: end,
        price: price.value,
        artist: {
            artistId: artist.value
        },
        location: {
            locationId: locationSelect.value
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

    msgBox.createYesNoDialog('Delete page', 'Are you sure you want to delete this event? This is irreversible!', function () {
        // fetch with post
        fetch('/api/events/' + editedId, {
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
    if (name.length > maxNameLength) {
        name = name.substring(0, maxNameLength) + '...';
    } else {
        let spacesAdded = 0;
        let spacesToAdd = maxNameLength - name.length;
        while (spacesAdded < spacesToAdd) {
            name += '&nbsp;';
            spacesAdded++;
        }

        console.log(name);
    }

    // make sure that location always is 15 chars long
    if (location.length > maxLocationLength) {
        location = location.substring(0, maxLocationLength) + '...';
    } else {
        let spacesAdded = 0;
        let spacesToAdd = maxLocationLength - location.length;
        while (spacesAdded < spacesToAdd + 3) {
            location += '&nbsp;';
            spacesAdded++;
        }

        console.log(location);
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
        fetch(baseURL + "/" + element.id, {
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

                    btnOpen.onclick = function () {
                        if (baseURL.endsWith('dance')) {
                            window.open('/festival/dance/event/' + data.id, '_blank');
                        } else {
                            window.open('/festival/jazz/event/' + data.id, '_blank');
                        }

                    }

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
    let head = 'Name' + ('&nbsp;').repeat(maxNameLength - 3) +
        '| Location' + ('&nbsp;').repeat(maxLocationLength - 5) +
        ' | START' + ('&nbsp;').repeat(12) + '| END';
    option.innerHTML = head;
    option.value = -1;
    option.disabled = true;
    locations.appendChild(option);

    let url = baseURL + '?sort=time';
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

    let uri = '/api/artists?sort=name';
    if (baseURL.endsWith('dance')) {
        uri += '&kind=2';
    } else {
        uri += '&kind=1';
    }

    fetch(uri, {
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

    let locationURI = '/api/locations/type/';
    if (baseURL.endsWith('dance')) {
        locationURI += '4';
    } else {
        locationURI += '1';
    }

    locationURI += '?sort=name';

    // and now, load jazz locations.
    location.innerHTML = '';
    fetch(locationURI, {
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
        editedEvent = null;
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

    locations.selectedIndex = -1;
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