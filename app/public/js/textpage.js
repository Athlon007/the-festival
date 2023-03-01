let areImagesSwappedForSmall = false;
let tableRowsWithImagesOnRight = document.querySelectorAll('tr td:nth-child(2) img');

let counter = 0;
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

// Load Map (if present)
if (document.getElementById('mapContainer')) {
    console.log('Map container found! Loading map...');
    let script = document.createElement('script');
    script.src = '/js/map.js';
    script.type = 'text/javascript';
    document.getElementsByTagName('head')[0].appendChild(script);
} else {
    console.log('No map container found.');
}