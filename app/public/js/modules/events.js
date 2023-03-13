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

    async init(container) {
        // create the sorting columns
        this.sortingContainer = document.createElement('div');
        sortColumns.classList.add('col-3', 'p');
        container.appendChild(sortColumns);

        let eventsMain = document.createElement('div');
        eventsMain.classList.add('col-8');

        this.eventsContainer = document.createElement('div');
        this.eventsContainer.classList.add('container', 'gy-1');
        eventsMain.appendChild(this.eventsContainer);

        container.appendChild(eventsMain);
    }
}

class JazzEventList extends EventList {
    constructor(container) {
        super(container);
    }

    async init(container) {
        super.init(container);

        let data = await this.getData();

        // create the filter columns
        let sortRow = document.createElement('div');
        sortRow.classList.add('row');
        let sortHeader = document.createElement('h2');
        sortHeader.innerText = 'Sort';
    }

    async getData() {
        let response = await fetch('http://localhost/events/jazz');
        let data = await response.json();
        return data;
    }
}