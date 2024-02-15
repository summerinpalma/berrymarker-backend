mapboxgl.accessToken = 'pk.eyJ1Ijoic3VtbWVyaW5wYWxtYSIsImEiOiJjbHMzMXhhNWUwcmhoMmxta3FqeWpxZnF2In0.g8gNNytJyeRD8TROH5i_Sg';

const map = new mapboxgl.Map({
    container: 'map-container',
    style: 'mapbox://styles/mapbox/satellite-v9',
    projection: 'globe',
    center: [137.915, 36.259],
    zoom: 15
});

let tooltip = document.getElementById("tooltip");
let currentMarker;

map.on('load', () => {
    console.log("testtest");
    fetchMarkerData();
});

map.on('style.load', () => {
    console.log("testest");
    map.setFog({});
});


if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
        var lng = position.coords.longitude;
        var lat = position.coords.latitude;

        // Set the map's center to the user's current location
        map.setCenter([lng, lat]);
    });
}

map.on('click', (e) => {
    currentMarker = e.lngLat;

    let markerLongitude = document.getElementById("txtLongitude");
    let markerLatitude = document.getElementById("txtLatitude");

    markerLongitude.value = currentMarker.lng;
    markerLatitude.value = currentMarker.lat;

});

/*function getClosestCity(currentMarker) {
    // Replace 'YOUR_ACCESS_TOKEN' with your actual Mapbox access token
const accessToken = 'eyJ1Ijoic3VtbWVyaW5wYWxtYSIsImEiOiJjbHMzMXhhNWUwcmhoMmxta3FqeWpxZnF2In0';
const longitude = currentMarker.lng; // Example 
const latitude = currentMarker.lat; // Example 

console.log(latitude);

// Construct the API URL
const apiUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json?access_token=${accessToken}`;

// Fetch the reverse geocoding data
fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        // Extract city name
        const features = data.features;
        if (features.length > 0) {
            const city = features[0].context.find(c => c.id.includes('place')).text;
            console.log("Nearest city: " + city);
        } else {
            console.error("No location found.");
        }
    })
    .catch(error => {
        console.error('Error fetching reverse geocoding data:', error);
    });
}*/

// CLOSE TOOLTIP. 
function closeToolTip() {
    tooltip.style.display = 'none';
}

// SUBMIT FORM FUNCTION. 
function submitForm() {
    let markerNameInput = document.getElementById("markerName");
    let markerName = markerNameInput.value;

    // CHECK 
    console.log(markerName);
    console.log(currentMarker.lat);
    console.log(currentMarker.lng);

    tooltip.style.display = "none";

    sendDataToPHP(markerName, currentMarker.lat, currentMarker.lng);
}

function sendDataToPHP(markerName, latitude, longitude) {
    fetch('process.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            markername: markerName,
            latitude: latitude,
            longitude: longitude
        })
    })

        .then(response => response.json())

        .then(result => {
            console.log('Data sent succesfully:', result);
        })

        .catch(error => {
            console.error('Error sending data:', error);
        })

}
function fetchMarkerData() {
    fetch('mapboxjson.php')
        .then(response => response.json())
        .then(data => {
            console.log("test");
            addMarkersToMap(data);
        })
        .catch(error => {
            console.error('Error fetching marker data:', error);
        });
}

function addMarkersToMap(markerData) {
    // PARSE THE JSON DATA.
    const markers = markerData;

    // ADD EACH MARKER TO THE MAPBOX MAP.
    markers.forEach(marker => {
        // GET PROPERTIES.
        const latitude = marker.geometry.coordinates[1];
        const longitude = marker.geometry.coordinates[0];
        const plantName = marker.properties.plantName;
        const harvestPeriod = marker.properties.harvestPeriod;
        const userName = marker.properties.username;
        const iconUrl = marker.properties.icon;

        // NEW MAPBOX MARKER.
        const mapMarker = new mapboxgl.Marker().setLngLat([longitude, latitude]).addTo(map);

        mapMarker.properties = { plantName: plantName, harvestPeriod: harvestPeriod };

        console.log(iconUrl);
        const popup = new mapboxgl.Popup({offset: 25}).setHTML(`<h3>${plantName}</h3><p>Marked by ${userName}<p>Harvest Period: ${harvestPeriod}</p>`);
        mapMarker.setPopup(popup);

    })
}
