<meta name="google-signin-client_id" content="1001160309619-f30jgqido5nq8v2nt3gbdd0d7pr5hp7c.apps.googleusercontent.com">
<?php echo form_open('frontend/site/changeLanguage', array('id' => 'languageForm')); ?>
    <select class="form-control" name="language_id" id="languageId" onchange="this.form.submit()">
        <?php foreach($this->Mconstants->languageIds as $k => $item): ?>
            <option value="<?php echo $k ?>" <?php echo $customer['language_id'] == $k ? 'selected':''; ?> ><?php echo $item; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="UrlOld" value="<?php echo $this->uri->uri_string(); ?>"/>
    <input type="submit" hidden="hidden" name="" value=""/>

    
<?php echo form_close(); ?>

<br>
<span><?php echo $this->lang->line('hello'); ?><span>
<a href="javascript:void(0);" onclick="fbLogin();" id="fbLink">LOgin fb</a>
<br>
<div class="col-sm-12 no-padding">
    <div class="box box-default padding15">
        <div id="mapLocation" style="height: 700px;width: 100%;"></div>
    </div>
</div>
<?php 
$configs = $this->Mconfigs->getListMap();
?>
<script>
    var iconMarker = "<?php echo base_url(CONFIG_PATH.$configs['MARKER_MAP_IMAGE']) ?>";
    var latMapAdmin = <?php echo LAT_MAP_ADMIN ?>;
    var lngMapAdmin = <?php echo LNG_MAP_ADMIN ?>;
    var zoomMapAdmin = <?php echo ZOOM_MAP_ADMIN ?>;
    var locations = <?php echo json_encode($locations); ?>
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEY_GOOGLE_MAP; ?>&callback=initMap&libraries=&v=weekly" async></script>
<script>
    var myStyles =[
        {
            featureType: "poi",
            elementType: "labels",
            stylers: [
                { visibility: "off" }
            ]
        }
    ];
    function initMap() {
    latitude = latMapAdmin;
    longitude = lngMapAdmin;
    
    const myLatlng = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
   
    
    const map = new google.maps.Map(document.getElementById("mapLocation"), {
        zoom: zoomMapAdmin,
        center: myLatlng,
        styles: myStyles 
    });

    // Create the initial InfoWindow.
    var infoWindow = new google.maps.InfoWindow();
    let marker, i;
    for (i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
            map,
            draggable:true,
            animation: google.maps.Animation.DROP,
            icon: iconMarker
        });
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(locations[i].location_name);
                infoWindow.open(map, marker);
            }
        })(marker, i));
    }
}
</script>
<script src="<?php echo base_url('assets/vendor/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/frontend/home/fb_login.js'); ?>"></script>

<input type="hidden" value="<?php echo base_url('fb-login'); ?>" id="loginFacebook">
<input type="hidden" value="<?php echo base_url('fb-logout'); ?>" id="logoutFacebook">

<script src="https://apis.google.com/js/platform.js" async defer></script>

<div class="g-signin2" data-onsuccess="onSignIn"></div>

<script>
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log(profile)
    // $("#name").text(profile.getName());
    // $("#email").text(profile.getEmail());
    // $("#image").attr('src', profile.getImageUrl());
    // $(".data").css("display", "block");
    // $(".g-signin2").css("display", "none");
}

function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log("You have been signed out successfully");
        // $(".data").css("display", "none");
        // $(".g-signin2").css("display", "block");
    });
}
</script>