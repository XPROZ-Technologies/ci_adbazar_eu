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


<fb:login-button 
data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false"
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '177851481129433',
      cookie     : true,
      xfbml      : true,
      version    : 'v12.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   
function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
</script>
