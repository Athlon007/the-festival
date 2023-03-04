let areImagesSwappedForSmall = false;
let tableRowsWithImagesOnRight = document.querySelectorAll('tr td:nth-child(2) img');

// If table tr has an image that is in second column, then swap the two tds
function swapTableImg() {
    tableRowsWithImagesOnRight.forEach(element => {
        let parent = element.parentNode;
        let sibling = parent.previousElementSibling;
        parent.parentNode.insertBefore(parent, sibling);
    });
}

function checkResize() {
    if ($(window).width() < 960) {
        if (areImagesSwappedForSmall) {
            return;
        }
        areImagesSwappedForSmall = true;
        swapTableImg();
    }
    else {
        if (!areImagesSwappedForSmall) {
            return;
        }
        areImagesSwappedForSmall = false;
        swapTableImg();
    }
}

$(window).on('resize', function () {
    checkResize();
});

checkResize();

// LOAD MODULES
// Load Map (if present)
if (document.getElementById('mapContainer')) {
    console.log('Map container found! Loading map...');
    let script = document.createElement('script');
    script.src = '/js/modules/map.js';
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);

    // Start map after loading script
    script.onload = () => HMap.start('mapContainer');
} else {
    console.log('No map container found.');
}

// Load calendar (if present)
if (document.getElementById('calendar')) {
    console.log('Calendar container found! Loading calendar...');
    let script = document.createElement('script');
    script.src = '/js/modules/calendar.js';
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
} else {
    console.log('No calendar container found.');
}

// Load counter module (if present)
if (document.getElementById('countdown')) {
    console.log('Countdown container found! Loading countdown...');
    let script = document.createElement('script');
    script.src = '/js/modules/countdown.js';
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);

    script.onload = () => Countdown.start('countdown');
} else {
    console.log('No countdown container found.');
}