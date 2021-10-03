<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
            </section>
            <section class="content">
            <?php echo form_open('backend/location/update', array('id' => 'locationForm')); ?>
                <div class="row">
                    <div class="col-sm-12 no-padding">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Location name <span class="required">*</span></label>
                                        <input type="text" name="location_name" class="form-control hmdrequired" data-field="Location name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Latitude <span class="required">*</span></label>
                                        <input type="text" name="lat" class="form-control hmdrequired" data-field="Latitude" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Longitude <span class="required">*</span></label>
                                        <input type="text" name="lng" class="form-control hmdrequired" data-field="Longitude" readonly autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-3" style="top:25px;">
                                    <ul class="list-inline" >
                                        <li><button class="btn btn-primary submit" type="button">Save</button></li>
                                        <li><a href="<?php echo base_url('backend/location'); ?>" class="btn btn-default" id="btnCancel">Cancel</a></li>
                                        <input type="text" hidden="hidden" name="id" value="0">
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Business Profile</label>
                                        <select class="form-control" name="business_profile_id" id="business_profile_id"> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Expired Date</label>
                                        <input type="text" name="expired_date" id="expired_date" class="form-control" value="<?php echo date('d/m/Y H:i'); ?>" >
                                        <input type="hidden" name="business_profile_location_id" value="0">
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-sm-12 no-padding">
                        <div class="box box-default padding15">
                            <div id="mapLocation" style="height: 700px;width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <input type="text" hidden="hidden" id="urlGetBusinessProfileNotInLocation" value="<?php echo base_url('sys-admin/business-profile/get-business-profile-not-in-location') ?>">
            <?php echo form_close(); ?>
            </section>
        </div>
    </div>
<?php $this->load->view('backend/includes/footer'); 
$configs = $this->session->userdata('configs');
?>
<script>
    var iconMarker = "<?php echo base_url(CONFIG_PATH.$configs['MARKER_MAP_IMAGE']) ?>";
    var latMapAdmin = <?php echo LAT_MAP_ADMIN ?>;
    var lngMapAdmin = <?php echo LNG_MAP_ADMIN ?>;
    var zoomMapAdmin = <?php echo ZOOM_MAP_ADMIN ?>;
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEY_GOOGLE_MAP; ?>&callback=initMap&libraries=&v=weekly" async></script>
