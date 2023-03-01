const HAARLEM_LOCATION = [52.3814425, 4.6360367]; // I don't think Haarlem is going to move anytime soon.

// Load the CSS file.
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

//Haarlem: 52.3814425,4.6360367
map = L.map('map').setView(HAARLEM_LOCATION, 16);
L.tileLayer('https://tiles.stadiamaps.com/tiles/outdoors/{z}/{x}/{y}{r}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
