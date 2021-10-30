const popupMap = document.querySelector('#popup-map');
const popupMapTitle = document.querySelector('#popup-map-title');
const popupMapClose = document.querySelector('#popup-map-close');
const input = document.getElementById("location-search-input");
const options = {
    fields: ["formatted_address", "geometry", "name"],
    strictBounds: false,
    types: ["establishment"],
};
const autocomplete = new google.maps.places.Autocomplete(input, options);

function popupMapS(data) {
    popupMapClose.addEventListener('click', () => {
        popupMap.style.display = 'none';
    })

    popupMap.style.display = 'flex';
    popupMapTitle.innerHTML = data.title;
    const target = new google.maps.LatLng(data.target.location.lat, data.target.location.lng);
    let source = null;
    let sourceMarker = null;
    let targetMarker = null;

    var mapProp = {
        center: target,
        zoom: 5, clickableIcons: false
    };
    var map = new google.maps.Map(document.getElementById("googleMapPopUp"), mapProp);
    var infowindow = new google.maps.InfoWindow();
    createMarker(target, true);
    google.maps.event.addListener(map, 'click', function (event) {
        source = event.latLng
        displayRoute(
            source,
            target,
            directionsService,
            directionsRenderer
        );
        infowindow.open(map, targetMarker);
    });


    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        source = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
        displayRoute(
            source,
            target,
            directionsService,
            directionsRenderer
        );
    });
    ////////////


    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        draggable: false,
        map,
        suppressMarkers: true,
        panel: document.getElementById("panel"),
    });

    function createMarker(latlng, isWindow = false) {
        var contentString = data.target.content;
        if (sourceMarker) {
            sourceMarker.setMap(null);
        }
        const marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: isWindow ? {
                path: "M0,0",
                anchor: new google.maps.Point(0, 0),
                strokeWeight: 0,
                scale: 1
            } : null,
            title: '',
            zIndex: Math.round(latlng.lat() * -100000) << 5
        });

        if (isWindow) {
            infowindow.setContent(contentString);
            infowindow.open(map, marker);
            targetMarker = marker;
        } else {
            sourceMarker = marker;
        }
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                source = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                displayRoute(
                    source,
                    target,
                    directionsService,
                    directionsRenderer
                );
            });
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    getLocation();

    function displayRoute(origin, destination, service, display) {
        service.route({
            origin: origin,
            destination: destination,
            waypoints: [],
            travelMode: google.maps.TravelMode.DRIVING,
            avoidTolls: true,
        }).then((result) => {
            var startLocation = new Object();
            var endLocation = new Object();
            var legs = result.routes[0].legs;
            startLocation.latlng = legs[legs.length - 1].start_location;
            endLocation.latlng = legs[legs.length - 1].end_location;
            //createMarker(endLocation.latlng, "end", "special text for end marker", "http://www.google.com/mapfiles/markerB.png")
            createMarker(startLocation.latlng);
            display.set('directions', null);
            display.setDirections(result);
            //hien chi duong, thu nho ban do
        }).catch((e) => {
            alert("Could not display directions due to: " + e);
        });
    }


}
