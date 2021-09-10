var app = app || {};

app.init = function (locationId) {
    app.submits(locationId);
}

$(document).ready(function () {
    var locationId = parseInt($('input[name="id"]').val());
    app.init(locationId);
});

app.submits = function() {
    $("body").on('click', '.submit', function() {
        var $this = $(this);
        $this.prop('disabled', true);
        if (validateEmpty('#locationForm'), '.submit') {
            var form = $('#locationForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) {
                        redirect(false, $('a#btnCancel').attr('href'));
                    } else $this.prop('disabled', false);
                },
                error: function(response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    $this.prop('disabled', false);
                }
            });
        }
        return false;
    })
}
function initMap() {
    let locationId = parseInt($('input[name="id"]').val());
    let latitude = $("input[name='lat']").val().trim();
    let longitude = $("input[name='lng']").val().trim();
    latitude = latitude != '' ? latitude: 10.639014;
    longitude = longitude != '' ? longitude: 106.710205;
    
    const myLatlng = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
   
    if(locationId == 0) {
        $("input[name='lat']").val(myLatlng.lat);
        $("input[name='lng']").val(myLatlng.lng);
    }
    const map = new google.maps.Map(document.getElementById("mapLocation"), {
        zoom: 16,
        center: myLatlng,
    });

    // Create the initial InfoWindow.
    let marker = new google.maps.Marker({
        position: myLatlng,
        map,
        draggable:true,
        animation: google.maps.Animation.DROP,
        icon: iconMarker
    });
    let infoWindow = new google.maps.InfoWindow({
        content: JSON.stringify(myLatlng, null, 2),
        position: myLatlng,
    });

    infoWindow.open(map, marker);
    
    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        marker.setMap(null);
        infoWindow.close();
        
        marker = new google.maps.Marker({
            position: mapsMouseEvent.latLng,
            map,
            draggable:true,
            animation: google.maps.Animation.DROP,
            icon: iconMarker
        });
    
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
            JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
        );
        $("input[name='lat']").val(mapsMouseEvent.latLng.lat());
        $("input[name='lng']").val(mapsMouseEvent.latLng.lng());
        infoWindow.open(map, marker);
    });

    google.maps.event.addListener(marker, 'dragend', function(event) { 
        let lat = marker.getPosition().lat();
		let long = marker.getPosition().lng();
        infoWindow.setContent(
            JSON.stringify(marker.getPosition().toJSON(), null, 2)
        );
        $("input[name='lat']").val(lat);
        $("input[name='lng']").val(long);
     } );

}
