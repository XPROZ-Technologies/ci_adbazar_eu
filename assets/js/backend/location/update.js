var app = app || {};

app.init = function (locationId) {
    app.submits(locationId);
    app.handle();
}

$(document).ready(function () {
    var locationId = parseInt($('input[name="id"]').val());
    app.init(locationId);
});

app.submits = function() {
    $("body").on('click', '.submit', function() {
        var $this = $(this);
        $this.prop('disabled', true);
        if (validateEmpty('#locationForm', '.submit')) {
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

app.handle = function() {
    $('#expired_date').datetimepicker({
        format: 'DD/MM/YYYY HH:mm',
        minDate:new Date()
    });
    $("select#business_profile_id").select2({
        placeholder: '--Choose Business Profile--',
        allowClear: true,
        ajax: {
            url: $("input#urlGetBusinessProfileNotInLocation").val(),
            type: 'POST',
            dataType: 'json',
            data: function(data) {

                return {
                    search_text: data.term,
                    business_profile_location_id: $('input[name="business_profile_location_id"]').val()
                };
            },
            processResults: function(data, params) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.business_name,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }

    }).on('change',function() {
        $("input#expired_date").val('');
    });
}

function initMap() {
    let locationId = parseInt($('input[name="id"]').val());
    let latitude = $("input[name='lat']").val().trim();
    let longitude = $("input[name='lng']").val().trim();
    latitude = latitude != '' ? latitude: latMapAdmin;
    longitude = longitude != '' ? longitude: lngMapAdmin;
    
    const myLatlng = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
   
    if(locationId == 0) {
        $("input[name='lat']").val(myLatlng.lat);
        $("input[name='lng']").val(myLatlng.lng);
    }
    const map = new google.maps.Map(document.getElementById("mapLocation"), {
        zoom: zoomMapAdmin,
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
