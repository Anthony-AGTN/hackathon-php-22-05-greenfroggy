/* // Step 1: Get user coordinates
function getCoordintes() {
    const options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };

    function success(pos) {
        const crd = pos.coords;
        const lat = crd.latitude.toString();
        const lng = crd.longitude.toString();
        const coordinates = [lat, lng];
        console.log(`Latitude: ${lat}, Longitude: ${lng}`);
        getCity(coordinates);
        return;

    }

    function error(err) {
        console.warn(`ERROR(${err.code}): ${err.message}`);
    }

    navigator.geolocation.getCurrentPosition(success, error, options);
}

// Step 2: Get city name
function getCity(coordinates) {
    const xhr = new XMLHttpRequest();
    const lat = coordinates[0];
    const lng = coordinates[1];

    // Paste your LocationIQ token below.
    xhr.open('GET', "https://us1.locationiq.com/v1/reverse.php?key=pk.12485d4488c50f0d4a2411aa17fe7295&lat=" + lat + "&lon=" + lng + "&format=json", true);
    xhr.send();
    xhr.onreadystatechange = processRequest;
    xhr.addEventListener("readystatechange", processRequest, false);

    function processRequest(e) {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const response = JSON.parse(xhr.responseText);
            const city = response.address.city;
            console.log(city);
            return;
        }
    }
}

getCoordintes();
 */

navigator.geolocation.getCurrentPosition(success[, error[, [options]])