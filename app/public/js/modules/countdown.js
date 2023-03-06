// A simple countdown timer that counts down to the start of the Festival.

class Countdown {
    constructor(container) {
        this.container = container;

        this.festivalStart = this.getFestivalStartDate();

        // If the festival has already started, show 'Festival started' instead of the countdown
        if (this.festivalStart < new Date()) {
            this.container.innerHTML = '<p class="countdown-counter">Festival started!</p>';
            return;
        }


        this.buildCountdown();
        this.updateCountdown();
        // Update the countdown every second
        setInterval(() => {
            this.updateCountdown();
        }, 1000);

        console.log('Countdown loaded.');
    }

    static start(id) {
        let spot = document.getElementById(id);
        if (!spot) {
            console.error('Could not find countdown container.');
            return;
        }

        let container = document.createElement('div');
        container.id = 'countdown';
        // Replace the spot with container
        spot.parentNode.replaceChild(container, spot);

        return new Countdown(container);
    }

    buildCountdown() {
        this.pDays = this.createTimeParagraph('countdown-days', '0');
        this.createTimeSeparator();
        this.pHours = this.createTimeParagraph('countdown-hours', '0');
        this.createTimeSeparator();
        this.pMinutes = this.createTimeParagraph('countdown-minutes', '0');
        this.createTimeSeparator();
        this.pSeconds = this.createTimeParagraph('countdown-seconds', '0');

        // Now we do the text below the numbers
        this.createSimpleText('Days');
        this.createSimpleText('');
        this.createSimpleText('Hours');
        this.createSimpleText('');
        this.createSimpleText('Minutes');
        this.createSimpleText('');
        this.createSimpleText('Seconds');
    }

    createTimeParagraph(id, text) {
        const p = document.createElement('p');
        p.id = id;
        p.classList.add('countdown-counter');
        p.innerText = text;
        this.container.appendChild(p);
        return p;
    }

    createTimeSeparator() {
        const p = document.createElement('p');
        p.classList.add('countdown-counter', 'countdown-separator');
        p.innerText = ':';
        this.container.appendChild(p);
        return p;
    }

    createSimpleText(text) {
        const p = document.createElement('p');
        p.innerText = text;
        this.container.appendChild(p);
        return p;
    }

    updateCountdown() {
        const now = new Date();
        const festivalStart = this.festivalStart;
        const timeLeft = festivalStart - now;

        this.pDays.innerText = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        this.pHours.innerText = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        this.pMinutes.innerText = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        this.pSeconds.innerText = Math.floor((timeLeft % (1000 * 60)) / 1000);
    }

    getFestivalStartDate() {
        if (this.festivalStart) {
            // We already have the start date.
            return this.festivalStart;
        }

        // TODO: Get the start date from the database
        return new Date('2023-07-27 10:00:00');
    }
}