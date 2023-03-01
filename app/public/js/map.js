const HAARLEM_LOCATION = [52.3814425, 4.6360367]; // I don't think Haarlem is going to move anytime soon.

// LOAD LEAFLET
// Load the CSS file of Leaflet.
let head = document.getElementsByTagName('head')[0];
let link = document.createElement('link');
link.rel = 'stylesheet';
link.type = 'text/css';
link.href = 'https://unpkg.com/leaflet@1.9.3/dist/leaflet.css';
link.media = 'all';
head.appendChild(link);
// Load Leaflet JS file.
let script = document.createElement('script');
script.src = 'https://unpkg.com/leaflet@1.9.3/dist/leaflet.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

// LOAD MAP
const container = document.getElementById('mapContainer');
let map;

switch (container.dataset.mapkind) {
    case 'general':
        // Create a map with a general location.
        let colViews = document.createElement('div');
        colViews.classList.add('col-0', 'col-md-2');
        let h3 = document.createElement('h3');
        h3.innerText = 'Check out the locations per event';
        colViews.appendChild(h3);

        let btnLayers = document.createElement('button');
        btnLayers.classList.add('btn', 'btn-primary', 'd-block', 'd-md-none', 'collapsed');
        btnLayers.setAttribute('data-bs-toggle', 'collapse');
        btnLayers.setAttribute('data-bs-target', '#mapCollapseLayers');
        btnLayers.setAttribute('aria-expanded', 'false');
        btnLayers.setAttribute('aria-controls', 'mapCollapseLayers');
        btnLayers.innerText = 'Views';
        colViews.appendChild(btnLayers);

        let divCollapse = document.createElement('div');
        divCollapse.classList.add('w-100', 'list-group', 'collapsed', 'collapse', 'd-md-flex');
        divCollapse.id = 'mapCollapseLayers';
        colViews.appendChild(divCollapse);

        let btnLayerOverview = document.createElement('button');
        btnLayerOverview.classList.add('list-group-item', 'list-group-item-action', 'active');
        btnLayerOverview.innerText = 'Overview';
        btnLayerOverview.onclick = showOverview;
        divCollapse.appendChild(btnLayerOverview);

        let mapDiv = document.createElement('div');
        mapDiv.id = 'map';
        mapDiv.classList.add('col-12', 'col-md-10');

        container.appendChild(colViews);
        container.appendChild(mapDiv);

        map = L.map('map').setView(HAARLEM_LOCATION, 16);
        L.tileLayer('https://tiles.stadiamaps.com/tiles/outdoors/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        break;
    default:
        console.error('Unknown map type: ' + container.dataset.maptype);
        break;
}

function moveMap(location, zoom) {
    map.panTo(location);
    map.setZoom(zoom);
}

let areas = [];

function addArea(name, coordinates, color) {
    let area = L.polygon(coordinates, {
        color: color,
        fillColor: color,
        fillOpacity: 0.5
    }).addTo(map);
    area.bindPopup(name);

    areas.push(area);
}

function clearAreas() {
    areas.forEach(area => {
        map.removeLayer(area);
    });
    areas = [];
}


function showOverview() {
    const LOCATION = [52.393306, 4.622498];
    const ZOOM = 14;
    moveMap(LOCATION, ZOOM);

    clearAreas();

    addArea('Festival Area', [
        [52.385553700259415, 4.631949663162232],
        [52.38434879837112, 4.644438028335572],
        [52.38624781359209, 4.650413990020753],
        [52.38550786220234, 4.651283025741578],
        [52.38340580873727, 4.644362926483155],
        [52.3812447148585, 4.64674472808838],
        [52.37933238600426, 4.642689228057862],
        [52.38026236449064, 4.640800952911378],
        [52.37939787808805, 4.637947082519532],
        [52.37791773328495, 4.638075828552247],
        [52.37688291231777, 4.639331102371217],
        [52.37598561121694, 4.63626265525818],
        [52.37627379749958, 4.629557132720948],
        [52.37749856822017, 4.6264779567718515],
        [52.37787843672914, 4.624385833740235],
        [52.383857660450126, 4.629181623458863],
        [52.38364810660761, 4.630469083786012]
    ], '#4943A0');

    addArea('DANCE! Venue', [
        [52.411712914646635, 4.60553526878357],
        [52.41157752977527, 4.608570212417496],
        [52.40949635203989, 4.607754820876969],
        [52.40981049836807, 4.6043215933379065]
    ], '#4943A0');
}

function mapDebug() {
    // Keep printing the map location to the console.
    map.on('move', function () {
        console.log(map.getCenter() + ' ' + map.getZoom());
    });

    // On click on map, print the location to the console.
    map.on('click', function (e) {
        console.log(e.latlng);
    });
}

mapDebug();