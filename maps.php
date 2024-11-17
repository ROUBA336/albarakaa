<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Picker</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Pick a Location</h2>
    <div id="map"></div>
    <div id="location-info">
        <h3>Selected Location:</h3>
        <p id="address"></p>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4KGIs9F_wy1-993csG2-1riEUCNMF8ls&libraries=places&callback=initMap" async defer></script>
    <script>
        let map;
        let geocoder;
        let marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 0, lng: 0 },
                zoom: 8
            });

            geocoder = new google.maps.Geocoder();

            map.addListener('click', function(event) {
                placeMarker(event.latLng);
                geocodeLatLng(event.latLng);
            });
        }

        function placeMarker(location) {
            if (marker) {
                marker.setPosition(location);
            } else {
                marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            }
            map.panTo(location);
        }

        function geocodeLatLng(latlng) {
            geocoder.geocode({ 'location': latlng }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('address').textContent = results[0].formatted_address;
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }
    </script>
</body>
</html>
