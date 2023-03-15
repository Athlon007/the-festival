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
        // create the sorting columns
        this.sortingContainer = document.createElement('div');
        this.sortingContainer.classList.add('col-3', 'p-1');
        container.appendChild(this.sortingContainer);

        let eventsMain = document.createElement('div');
        eventsMain.classList.add('col-8');

        this.eventsContainer = document.createElement('div');
        this.eventsContainer.classList.add('container', 'gy-1', 'overflow-auto');
        this.eventsContainer.style.maxHeight = '500px';
        eventsMain.appendChild(this.eventsContainer);

        container.appendChild(eventsMain);
    }

    addEventToCard(event, amount) {
    }
}

class JazzEventList extends EventsList {
    constructor(container) {
        super(container);
        this.loadEvents();
    }

    async init(container) {
        super.init(container);

        // SORT
        let sortRow = document.createElement('div');
        sortRow.classList.add('row');
        let sortHeader = document.createElement('h2');
        sortHeader.innerText = 'Sort';
        let sorts = document.createElement('select');
        sorts.classList.add('form-select');
        sorts.addEventListener('change', (e) => {
            this.sortMethod = e.target.value;
            this.loadEvents();
        });

        let sortOptions = [
            { value: 'time-asc', text: 'Time ascending' },
            { value: 'time-desc', text: 'Time descending' },
            { value: 'price-asc', text: 'Price ascending' },
            { value: 'price-desc', text: 'Price descending' }
        ];
        for (let option of sortOptions) {
            let sortOption = document.createElement('option');
            sortOption.value = option.value;
            sortOption.innerText = option.text;
            sorts.appendChild(sortOption);
        }

        sortRow.appendChild(sortHeader);
        sortRow.appendChild(sorts);
        this.sortingContainer.appendChild(sortRow);

        // FILTER
        // Filter Time
        let timeFilter = document.createElement('div');
        timeFilter.classList.add('row');
        let timeHeader = document.createElement('h2');
        timeHeader.innerText = 'Time';
        //start
        let timeStartHeader = document.createElement('h3');
        timeStartHeader.innerText = 'From';
        let timeStart = document.createElement('select');
        timeStart.classList.add('form-select');
        timeStart.addEventListener('change', (e) => {
            this.timeStart = e.target.value;
            this.loadEvents();
        });
        //end
        let timeEndHeader = document.createElement('h3');
        timeEndHeader.innerText = 'To';
        let timeEnd = document.createElement('select');
        timeEnd.classList.add('form-select');
        timeEnd.addEventListener('change', (e) => {
            this.timeEnd = e.target.value;
            this.loadEvents();
        });

        // add hours from 0 to 23
        for (let i = 0; i < 24; i++) {
            let optionStart = document.createElement('option');
            let optionEnd = document.createElement('option');
            optionStart.value = optionEnd.value = i;
            optionStart.innerText = optionEnd.innerText = i + ':00';
            timeStart.appendChild(optionStart);
            timeEnd.appendChild(optionEnd);
        }

        timeFilter.appendChild(timeHeader);
        timeFilter.appendChild(timeStartHeader);
        timeFilter.appendChild(timeStart);
        timeFilter.appendChild(timeEndHeader);
        timeFilter.appendChild(timeEnd);
        this.sortingContainer.appendChild(timeFilter);

        // Price
        let priceFilter = document.createElement('div');
        priceFilter.classList.add('row');
        let priceHeader = document.createElement('h2');
        priceHeader.innerText = 'Price';
        let priceFromHeader = document.createElement('h3');
        priceFromHeader.innerText = 'From';
        let priceFrom = document.createElement('input');
        priceFrom.type = 'number';
        priceFrom.classList.add('form-control');
        priceFrom.addEventListener('change', (e) => {
            this.priceFrom = e.target.value;
            this.loadEvents();
        }
        );

        let priceToHeader = document.createElement('h3');
        priceToHeader.innerText = 'To';
        let priceTo = document.createElement('input');
        priceTo.type = 'number';
        priceTo.classList.add('form-control');
        priceTo.addEventListener('change', (e) => {
            this.priceTo = e.target.value;
            this.loadEvents();
        }
        );

        priceFilter.appendChild(priceHeader);
        priceFilter.appendChild(priceFromHeader);
        priceFilter.appendChild(priceFrom);
        priceFilter.appendChild(priceToHeader);
        priceFilter.appendChild(priceTo);
        this.sortingContainer.appendChild(priceFilter);

        // Attributes
        let attributesFilter = document.createElement('div');
        attributesFilter.classList.add('row');
        let attributesHeader = document.createElement('h2');
        attributesHeader.innerText = 'Attributes';
        // hide events without seats checkbox
        let hideWithoutSeatsDiv = document.createElement('div');
        hideWithoutSeatsDiv.classList.add('form-check');
        let hideWithoutSeats = document.createElement('input');
        hideWithoutSeats.type = 'checkbox';
        hideWithoutSeats.classList.add('form-check-input');
        hideWithoutSeats.addEventListener('change', (e) => {
            this.hideWithoutSeats = e.target.checked;
            this.loadEvents();
        }
        );
        let hideWithoutSeatsLabel = document.createElement('label');
        hideWithoutSeatsLabel.classList.add('form-check-label');
        hideWithoutSeatsLabel.innerText = 'Hide events without seats';
        hideWithoutSeatsLabel.htmlFor = 'hideWithoutSeats';

        attributesFilter.appendChild(attributesHeader);
        hideWithoutSeatsDiv.appendChild(hideWithoutSeats);
        hideWithoutSeatsDiv.appendChild(hideWithoutSeatsLabel);
        attributesFilter.appendChild(hideWithoutSeatsDiv);
        this.sortingContainer.appendChild(attributesFilter);
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