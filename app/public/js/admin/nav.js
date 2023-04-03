if (window.frameElement == null) {
    //window.location.href = '/manageTicketTypes';
}

import { MsgBox } from "./modals.js";

let editedId = -1;
let editedEventId = -1;

// Artist fields.
const navs = document.getElementById('navs');

const btnSubmit = document.getElementById('submit');
let isInCreationMode = false;

const msgBox = new MsgBox();

let baseURL = '/api/nav';

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
                locations.appendChild(createNewOptionItem(data));
                locations.selectedIndex = locations.length - 1;
                editedId = data.id;
                isInCreationMode = false;
                btnSubmit.innerHTML = 'Save';

                msgBox.createToast('Success!', 'Pass has been updated');
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
                locations.appendChild(createNewOptionItem(data));
                locations.selectedIndex = locations.length - 1;
                editedId = data.id;

                msgBox.createToast('Success!', 'Pass has been created');

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
    let d = new Date(date.value);
    d = d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();

    // to json
    let data = {
        id: 0,
        event: {
            id: editedEventId,
            name: name.value,
            startTime: d,
            endTime: d,
            eventType: {
                id: festivalEventType.value,
            }
        },
        ticketType: {
            id: ticketType.value,
        }
    };


    if (isInCreationMode) {
        createNewEntry(data);
    } else {
        updateExistingEntry(editedId, data);
    }
}

document.getElementById('cancel').onclick = function () {
    toggleEditor(masterEditor, false);
}

function createNewOptionItem(element) {
    // create option
    let li = document.createElement('li');
    li.classList.add('list-group-item', 'my-2');
    li.id = element.id;
    li.dataset.pageId = element.page.id;

    // add p and - button
    let p = document.createElement('p');
    p.classList.add('d-inline-block');
    p.innerHTML = element.page.title;
    li.appendChild(p);

    let btn = document.createElement('button');
    btn.classList.add('btn', 'btn-danger', 'float-right', 'ml-2');
    btn.innerHTML = '-';
    btn.onclick = function () {
        // remove the option from the list
        li.remove();

        createNewPagesItem(element.page);
    }
    li.appendChild(btn);

    // add the 'open' button
    btn = document.createElement('button');
    btn.classList.add('btn', 'btn-primary', 'float-right');
    btn.innerHTML = 'Open';
    btn.onclick = function () {
        // open the page
        window.open(element.page.href, '_blank');
    }
    li.appendChild(btn);


    let ul = document.createElement('ul');
    ul.classList.add('list-group');
    ul.classList.add('list-group-flush');
    ul.classList.add('ml-3');
    // set height to at least 16px, so you can drag into it.
    ul.style.minHeight = '16px';
    li.appendChild(ul);

    // If children of elemnt exist, create a ul and add the children to it.
    if (element.children.length > 0) {
        ul.id = element.id;
        ul.dataset.pageId = element.page.id;
        element.children.forEach(child => {
            ul.appendChild(createNewOptionItem(child));
        });
    }

    return li;
}

function createNewPagesItem(element) {
    let options = navs.getElementsByTagName('li');
    for (let option of options) {
        if (option.dataset.pageId == element.id) {
            // skip this one
            return;
        }

        // check the children
        let children = option.getElementsByTagName('li');
        for (let child of children) {
            if (child.dataset.pageId == element.id) {
                return;
            }
        }
    }

    let li = document.createElement('li');
    li.classList.add('list-group-item');
    li.id = element.id;

    // Add the p and + buttons.
    let p = document.createElement('p');
    p.innerHTML = element.title;
    li.appendChild(p);

    let btn = document.createElement('button');
    btn.classList.add('btn');
    btn.classList.add('btn-primary');
    btn.classList.add('btn-sm');
    btn.innerHTML = '+';
    btn.onclick = function () {
        let e = {
            id: 0,
            page: {
                id: li.id,
                title: p.innerHTML,
                href: element.href
            },
            children: []
        }

        let option = createNewOptionItem(e);
        navs.appendChild(option);

        // remove self from pages
        li.remove();
    };
    li.appendChild(btn);

    // aqdd btn that lets you open the page
    let btnOpen = document.createElement('button');
    btnOpen.classList.add('btn');
    btnOpen.classList.add('btn-primary');
    btnOpen.classList.add('btn-sm');
    btnOpen.classList.add('ml-2');
    btnOpen.innerHTML = 'Open';
    btnOpen.onclick = function () {
        window.open(element.href, '_blank');
    };
    li.appendChild(btnOpen);

    pages.appendChild(li);

    return li;
}


async function loadList() {
    // fetch with post
    await fetch(baseURL, {
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
                    option.dataset.pageId = element.page.id;

                    // append option
                    navs.appendChild(option);
                });
            }
        });

    fetch('/api/pages', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            // check if data is array
            const pages = document.getElementById('pages');
            if (Array.isArray(data)) {
                data.forEach(element => {
                    // Do not add, if already in the list of navs.
                    createNewPagesItem(element);
                });
            }
        }
        );
}

loadList();

$('#navs').sortable({
    group: 'nested'
});


function toggleEditor(element, isEnabled) {
    if (isEnabled) {
        element.classList.remove('disabled-module');
    } else {
        element.classList.add('disabled-module');
        editedId = -1;
    }
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