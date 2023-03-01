const START_DATE = '2023-07-27 10:00:00';

// Load FullCalendar's JS.
let fcScript = document.createElement('script');
fcScript.src = 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js';
fcScript.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(fcScript);

// Wait for FullCalendar to be defined 5 times every 1 second.
let calendarLoadRetries = 0;
let calLoadInterval = setInterval(() => {
    if (calendarLoadRetries > 5) {
        clearInterval(calLoadInterval);
        console.error('Could not load calendar.');
        return;
    }
    if (typeof FullCalendar === 'undefined') {
        calendarLoadRetries++;
        return;
    }
    clearInterval(calLoadInterval);
    console.log('FullCalendar defined. Loading calendar...');
    loadCalendar();
}, 1000);


function loadCalendar() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap5',
        initialView: 'timeGridWeek4Days',
        selectable: true,
        height: 650,
        initialDate: getStartDate(),
        headerToolbar: {
            left: 'prev,next today backToEvent',
            center: 'title',
            right: 'timeGridWeek4Days,timeGridDay'
        },
        slotLabelFormat: {
            hour: 'numeric',
            hour12: false,
            minute: '2-digit'
        },
        eventTimeFormat: {
            hour: 'numeric',
            hour12: false,
            minute: '2-digit'
        },
        views: {
            timeGridWeek4Days: {
                type: 'timeGridWeek',
                buttonText: '4 days',
                duration: { days: 4 },
                slotEventOverlap: false,
                allDaySlot: false,
                dayHeaderFormat: {
                    weekday: 'long'
                }
            }
        },
        customButtons: {
            backToEvent: {
                text: 'back to event',
                click: function () {
                    calendar.changeView('timeGridWeek4Days');
                    calendar.gotoDate(getStartDate());
                }
            }
        }
    });
    calendar.render();
    calendar.scrollToTime('10:00:00');

    function getStartDate() {
        return START_DATE; // TODO: Pull that from the database
    }

    function checkResize() {
        calendar.changeView($(window).width() < 960 ? 'timeGridDay' : 'timeGridWeek4Days');
    }

    function addEvent(title, start, end, url, backgroundColor, borderColor) {
        calendar.addEvent({
            title: title,
            start: start,
            end: end,
            url: url,
            backgroundColor: backgroundColor,
            textColor: '#000',
            borderColor: borderColor
        });
    }

    $(window).on('resize', function () {
        checkResize();
    });
    checkResize();
}
