const eventType = document.getElementById('event-type');
const passType = document.getElementById('pass-type');
const date = document.getElementById('event-date');
const price = document.getElementById('event-price');
const quantity = document.getElementById('quantity');
const master = document.getElementById('master');

// disable both
eventType.disabled = true;
passType.disabled = true;

let eventTypeId = 0;
let passTypeId = 0;

async function load() {
    eventType.value = 0;
    await fetch('/api/eventtypes', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            data.forEach(element => {
                eventType.innerHTML += `<option value="${element.id}">${element.name}</option>`;
            });
        })
        .catch((error) => {
            console.error('Error:', error);
        }
        );

    eventType.addEventListener('change', async (e) => {
        eventTypeId = e.target.value;
        loadPassTypes();
    });

    eventType.value = 0;
    eventType.disabled = false;

    // Check the GET parameters.
    const urlParams = new URLSearchParams(window.location.search);
    const eventTypeIdParam = urlParams.get('event_type');
    if (eventTypeIdParam) {
        eventType.value = eventTypeIdParam;
        eventTypeId = eventTypeIdParam;
        loadPassTypes();
    }
}
load();

async function loadPassTypes() {
    passType.innerHTML = '';
    passType.innerHTML += `<option value="0" disabled>===Select Pass Type===</option>`;
    passType.value = 0;
    passType.disabled = true;

    await fetch(`/api/events/passes?event_type=${eventTypeId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            data.forEach(element => {
                passType.innerHTML += `<option value="${element.id}">${element.event.name}</option>`;
            });
        })
        .catch((error) => {
            console.error('Error:', error);
        }
        );

    passType.addEventListener('change', async (e) => {
        passTypeId = e.target.value;
        prepare();
    });

    passType.value = 0;
    passType.disabled = false;

    // Check the GET parameters.
    const urlParams = new URLSearchParams(window.location.search);
    const passTypeIdParam = urlParams.get('pass_type');
    if (passTypeIdParam) {
        passType.value = passTypeIdParam;
        passTypeId = passTypeIdParam;
        prepare();
    }
}

function prepare() {
    fetch('/api/events/passes/' + passTypeId, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            // display date without the hour.
            if (data.ticketType.name.includes('All-Day')) {
                date.innerHTML = "All Day";
            } else {
                date.innerHTML = data.event.startTime.date.split(' ')[0];
            }
            price.innerHTML = '€ ' + data.ticketType.price * quantity.value;
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

quantity.addEventListener('change', (e) => {
    prepare();
});

document.getElementById('buy-pass').addEventListener('click', async (e) => {
    master.classList.add('disabled');
    for (let i = 0; i < quantity.value; i++) {
        await Cart.Add(passTypeId);
    }

    window.location.href = '/festival';
});