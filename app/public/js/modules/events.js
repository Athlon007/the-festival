class EventsList {
    constructor(container) {
        this.events = [];

        this.init(container);
    }

    static build(containerId) {
        this.container = document.getElementById(containerId);

        if (!this.container) {
            throw new Error('Container not found');
        }

        this.container.classList.add('row', 'col-12');

        const data = this.container.dataset;
        if (!data) {
            throw new Error('No data found');
        }

        if (data.type === 'jazz') {
            console.log('Jazz events');
            return new JazzEventList(this.container);
        } else if (data.type === 'stroll') {
            console.log('Stroll events');
            return new StrollEventList(this.container);
        }

        return new EventsList(this.container);
    }

    addEvent(event) {
        this.events.push(event);
    }

    getEvents() {
        return this.events;
    }

    removeEvent(event) {
        this.events = this.events.filter((e) => e !== event);
    }

    clearEvents() {
        this.events = [];
    }

    async init(container) {
        let eventContainer = document.createElement('div');
        eventContainer.classList.add('container', 'ticket-container');

        let rowContent = document.createElement('div');
        rowContent.classList.add('row');
        eventContainer.appendChild(rowContent);

        let colSorts = document.createElement('div');
        colSorts.classList.add('col-md-6');
        rowContent.appendChild(colSorts);

        let rowDateTime = document.createElement('div');
        rowDateTime.classList.add('row', 'mb-3');
        colSorts.appendChild(rowDateTime);

        let colDate = document.createElement('div');
        colDate.classList.add('col-md-6', 'dateOfTour');
        colDate.style.width = '50%';
        colDate.style.float = 'left';
        rowDateTime.appendChild(colDate);

        let labelColDate = document.createElement('label');
        labelColDate.innerText = 'Date';
        labelColDate.classList.add('form-label');

        let selectColDate = document.createElement('select');
        selectColDate.classList.add('form-select');
        selectColDate.id = 'dateOfTour';
        selectColDate.addEventListener('change', (e) => {
            this.dateOfTour = e.target.value;
            this.loadEvents();
        });

        let optionColDate = document.createElement('option');
        optionColDate.innerText = 'Choose Date';
        optionColDate.value = '-1';
        selectColDate.appendChild(optionColDate);


    }

    async getData() {
        // if sort by is set
        let url = '/api/events/stroll';
        let args = '';

        function addArg(arg) {
            if (args == '') {
                args += `?${arg}`;
            } else {
                args += `&${arg}`;
            }
        }

        if (this.sortMethod) {
            addArg(`sort=${this.sortMethod}`);
        }

        // if time_start is set
        if (this.timeStart) {
            addArg(`time_from=${this.timeStart}`);
        }
        if (this.timeEnd) {
            addArg(`time_to=${this.timeEnd}`);
        }

        // if price_from is set
        if (this.priceFrom) {
            addArg(`price_from=${this.priceFrom}`);
        }
        if (this.priceTo) {
            addArg(`price_to=${this.priceTo}`);
        }

        // if hide_without_seats is set
        if (this.hideWithoutSeats) {
            addArg(`hide_without_seats`);
        }

        let response = await fetch(url + args);
        let data = await response.json();
        return data;
    }

    async loadEvents() {
        this.clearEvents();
        let data = await this.getData();

        for (let event of data) {
            this.addEvent(event);
        }
    }

    addEvent(event) {
        super.addEvent(event);
    }

    createDetailBox(name, value) {
        let container = document.createElement('div');
        container.classList.add('col-3');
        let header = document.createElement('h3');
        header.innerText = name;
        let text = document.createElement('p');
        text.innerHTML = value;
        container.appendChild(header);
        container.appendChild(text);
        return container;
    }

    removeEvent(event) {
        super.removeEvent(event);
        let eventContainer = document.getElementById('event-' + event.id);
        eventContainer.remove();
    }

    clearEvents() {
        super.clearEvents();
        this.eventsContainer.innerHTML = '';
    }
}

class StrollEventList extends EventsList {
    constructor(container) {
        super(container);
        this.loadEvents();
    }

    async init(container) {
        super.init(container);

    }

    async getData() {
        // if sort by is set
        let url = '/api/events/jazz';
        let args = '';

        function addArg(arg) {
            if (args == '') {
                args += `?${arg}`;
            } else {
                args += `&${arg}`;
            }
        }

        if (this.sortMethod) {
            addArg(`sort=${this.sortMethod}`);
        }

        // if time_start is set
        if (this.timeStart) {
            addArg(`time_from=${this.timeStart}`);
        }
        if (this.timeEnd) {
            addArg(`time_to=${this.timeEnd}`);
        }

        // if price_from is set
        if (this.priceFrom) {
            addArg(`price_from=${this.priceFrom}`);
        }
        if (this.priceTo) {
            addArg(`price_to=${this.priceTo}`);
        }

        // if hide_without_seats is set
        if (this.hideWithoutSeats) {
            addArg(`hide_without_seats`);
        }

        let response = await fetch(url + args);
        let data = await response.json();
        return data;
    }

    async loadEvents() {
        this.clearEvents();
        let data = await this.getData();

        for (let event of data) {
            this.addEvent(event);
        }
    }

    addEvent(event) {
        super.addEvent(event);

        let eventContainer = document.createElement('div');
        eventContainer.classList.add('row', 'card');
        eventContainer.id = 'event-' + event.id;

        let rowTitle = document.createElement('div');
        rowTitle.classList.add('row');
        let title = document.createElement('h2');
        title.innerText = event.name;
        rowTitle.appendChild(title);

        let rowDetails = document.createElement('div');
        rowDetails.classList.add('row');

        rowDetails.appendChild(this.createDetailBox('Location', event.location.name));

        const startTime = new Date(event.startTime.date);
        const endTime = new Date(event.endTime.date);
        const startHour = startTime.getHours();
        const endHour = endTime.getHours();
        const startMinutes = startTime.getMinutes();
        const endMinutes = endTime.getMinutes();
        const startMinutesString = startMinutes < 10 ? '0' + startMinutes : startMinutes;
        const endMinutesString = endMinutes < 10 ? '0' + endMinutes : endMinutes;
        const displayTime = `${startTime.toDateString()}<br> ${startHour}:${startMinutesString} - ${endHour}:${endMinutesString}`;
        rowDetails.appendChild(this.createDetailBox('Time', displayTime));

        rowDetails.appendChild(this.createDetailBox('Seats', event.location.capacity));
        rowDetails.appendChild(this.createDetailBox('Price', event.price));

        // buttons row
        let rowButtons = document.createElement('div');
        rowButtons.classList.add('row', 'justify-content-end', 'py-2', 'gx-2', 'px-0');
        // amount input
        let amountInput = document.createElement('input');
        amountInput.type = 'number';
        amountInput.classList.add('form-control');
        amountInput.value = 1;
        amountInput.min = 1;
        amountInput.max = 10;
        amountInput.style.width = '4.5em';
        amountInput.style.marginRight = '0.5em';
        // buy button
        let buyButton = document.createElement('button');
        buyButton.classList.add('btn', 'btn-primary', 'col-3');
        buyButton.innerText = 'Add ticket to cart';
        buyButton.addEventListener('click', () => {
            let amount = amountInput.value;
            this.addEventToCard(event.id, amount);
        });
        let buttonDetailsA = document.createElement('a');
        buttonDetailsA.href = `/festival/jazz/event/${event.id}`;
        buttonDetailsA.classList.add('col-3');
        let buttonDetails = document.createElement('button');
        buttonDetails.classList.add('btn', 'btn-secondary', 'w-100');
        buttonDetails.innerText = 'About event';
        buttonDetailsA.appendChild(buttonDetails);
        rowButtons.appendChild(amountInput);
        rowButtons.appendChild(buyButton);
        rowButtons.appendChild(buttonDetailsA);

        eventContainer.appendChild(rowTitle);
        eventContainer.appendChild(rowDetails);
        eventContainer.appendChild(rowButtons);

        this.eventsContainer.appendChild(eventContainer);
    }

    createDetailBox(name, value) {
        let container = document.createElement('div');
        container.classList.add('col-3');
        let header = document.createElement('h3');
        header.innerText = name;
        let text = document.createElement('p');
        text.innerHTML = value;
        container.appendChild(header);
        container.appendChild(text);
        return container;
    }

    removeEvent(event) {
        super.removeEvent(event);
        let eventContainer = document.getElementById('event-' + event.id);
        eventContainer.remove();
    }

    clearEvents() {
        super.clearEvents();
        this.eventsContainer.innerHTML = '';
    }
}