class JazzEvents {
    constructor() {
        this.events = [];
    }

    addEvent(event) {
        this.events.push(event);
    }

    getEvents() {
        return this.events;
    }
}