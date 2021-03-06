<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-content">
      <div class="container">
        <?php $this->load->view('frontend/includes/bm_header'); ?>

        <div class="d-flex justify-content-center edit-bm">
          <a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/edit'); ?>" class="btn btn-red">
            <img src="assets/img/frontend/ic-edit.png" alt="ic-edit">
            <?php echo $this->lang->line('edit_my_profile'); ?>
          </a>
        </div>

        <div class="wrapper-bm-profile">
          <div class="overlay"></div>
          <div class="bp-top bm-top">
            <div class="container">
              <img src="<?php echo BUSINESS_PROFILE_PATH . $businessInfo['business_image_cover']; ?>" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
            </div>
          </div>

          <div class="bp-top-img bm-top-img">
            <div class="bp-header">
              <img src="<?php echo BUSINESS_PROFILE_PATH . $businessInfo['business_avatar']; ?>" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
              <h3 class="text-center page-title fw-bold text-black text-top"><?php echo $businessInfo['business_name']; ?></h3>
              <p class="mb-0 page-text-lg text-black text-center"><?php echo $businessInfo['business_slogan']; ?></p>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-3">
              <?php $this->load->view('frontend/includes/business_manage_nav_sidebar'); ?>
            </div>
            <div class="col-lg-9">
              <div class="bp-tabs-right bm-right">
                <div class="bp-about">
                  <div class="row justify-content-between">
                    <div class="col-lg-7">
                      <div class="bp-about-left">
                        <h4 class="fw-bold page-title-xs"><?php echo $this->lang->line('business_information'); ?></h4>
                        <div class="d-flex align-items-center mb-20">
                          <?php if (isset($reviewInfo) && $reviewInfo['sumReview'] > 0) { ?>
                            <div class="star-rating on line  mr-8px relative">
                              <div class="star-base">
                                <div class="star-rate" data-rate="<?php echo $reviewInfo['star']; ?>"></div>
                                <a dt-value="1" href="javascript:void(0)"></a>
                                <a dt-value="2" href="javascript:void(0)"></a>
                                <a dt-value="3" href="javascript:void(0)"></a>
                                <a dt-value="4" href="javascript:void(0)"></a>
                                <a dt-value="5" href="javascript:void(0)"></a>
                              </div>
                            </div>
                            <span class="star-rating-number">(<?php echo $reviewInfo['sumReview']; ?>)</span>
                          <?php } ?>
                        </div>
                        <ul class="list-unstyled list-info">
                          <li class="mb-3">
                            <div class="img">
                              <img src="assets/img/frontend/icon-tag.png" alt="tag icon" class="img-fluid">
                            </div><?php if (!empty($businessServiceTypes)) {
                                    for ($k = 0; $k < count($businessServiceTypes); $k++) {
                                      echo $businessServiceTypes[$k]['service_type_name'];
                                      if ($k < (count($businessServiceTypes) - 1)) {
                                        echo ', ';
                                      }
                                    }
                                  } ?>
                          </li>
                          <li class="mb-3">
                            <div class="img"><img src="assets/img/frontend/bp-open.png" alt="tag open" class="img-fluid"></div>
                            <div class="badge badge-approved"><?php echo $this->lang->line('open_now'); ?></div>
                          </li>
                          <li class="mb-3">
                            <div class="img"><img src="assets/img/frontend/bp-telephone.png" alt="telephone icon" class="img-fluid"></div>
                            <?php if (!empty($phoneCodeInfo)) { ?>+<?php echo $phoneCodeInfo['phonecode']; ?><?php } ?><?php echo $businessInfo['business_phone']; ?>
                          </li>
                          <li class="mb-3 d-flex align-items-center">
                            <div class="img">
                              <img src="assets/img/frontend/bp-place.png" alt="map icon" class="img-fluid">
                            </div>
                            <div>
                              <p class="mb-0"><?php echo $businessInfo['business_address']; ?></p>
                              <?php if (!empty($locationInfo)) { ?>
                                <a data-bs-toggle="modal" href="#aboutMapModal" class="d-inline-block"><?php echo $this->lang->line('view_map'); ?></a>
                              <?php } ?>
                            </div>
                          <li class="mb-3"><img src="assets/img/frontend/ic-mail.png" alt="email icon" class="img-fluid"><?php echo $businessInfo['business_email']; ?></li>
                        </ul>
                        <?php if (!empty($businessInfo['business_whatsapp'])) { ?>
                          <a target="_blank" href="https://wa.me/<?php echo $businessInfo['business_whatsapp']; ?>" class="btn btn-red what-app fw-medium">
                            <div class="img"><img src="assets/img/frontend/ic-whatapp.png" alt="bp-what-app"></div>
                            <?php echo $this->lang->line('contact_us_on_whatsapp'); ?>
                          </a>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="col-lg-5 order-first order-lg-last">
                      <?php if (!empty($businessOpeningHours)) { ?>
                        <div class="bp-about-right">
                          <div class="open-hour">
                            <h5 class="text-center page-text-lg"><?php echo strtoupper($this->lang->line('opening_hours')); ?></h5>
                            <ul class="list-unstyled mb-0">
                              <?php 
                              $dayShortIds = $this->Mconstants->dayShortIds();
                              foreach ($businessOpeningHours as $open_hours) { ?>
                                <li>
                                  <span class="date"><?php echo $dayShortIds[$open_hours['day_id']]; ?></span>
                                  <?php if ($open_hours['opening_hours_status_id'] == STATUS_ACTIVED) { ?>
                                    <span class="time"><?php echo ddMMyyyy($open_hours['start_time'], 'H:i'); ?> -
                                      <?php echo ddMMyyyy($open_hours['end_time'], 'H:i'); ?></span>
                                  <?php } else { ?>
                                    <span class="badge badge-cancel"><?php echo $this->lang->line('closed'); ?></span>

                                  <?php } ?>
                                </li>
                              <?php } ?>
                            </ul>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <?php if (!empty($businessInfo['business_description'])) { ?>
                    <div class="row">
                      <div class="col-12">
                        <div class="bp-introduce">
                          <h5 class="fw-bold page-title-xs"><?php echo $this->lang->line('introduction'); ?></h5>
                          <div class="">
                            <?php echo nl2br($businessInfo['business_description']); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if (!empty($locationInfo)) { ?>
      <!-- Modal About Map -->
      <div class="modal fade" id="aboutMapModal" tabindex="-1" aria-labelledby="aboutMapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-body p-0" style="padding:0px !important;">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="height500" id="map_business"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal About Map -->
    <?php } ?>
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Modal cannot create -->
<div class="modal fade" id="eventJoinAsGuest" tabindex="-1" aria-labelledby="bmCannotCreateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="page-text-lg text-center">This function will be available soon</p>
      </div>
    </div>
  </div>
</div>
<!-- End Modal cannot create -->

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEY_GOOGLE_MAP; ?>&callback=initMap&libraries=&v=weekly" async></script>
<script>
  $('.btn-join-as-guest').click(function() {
    /* $("#eventJoinAsGuest").modal('show'); */
  });
  if ($('#map_business').length > 0) {
    

    
    let map;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map_business"), {
        center: new google.maps.LatLng(50.047648687939635, 12.355822100555436),
        zoom: 16,
      });

      const iconBase = "<?php echo CONFIG_PATH; ?>";
      const icons = {
        iconMap: {
          icon: iconBase + "<?php if (!empty($configs['MARKER_MAP_IMAGE'])) {
                              echo $configs['MARKER_MAP_IMAGE'];
                            } else {
                              echo "iconmap.png";
                            } ?>",
        },
      };

      const features = [
        <?php if (!empty($locationInfo) > 0) { ?> {
            position: new google.maps.LatLng(<?php echo $locationInfo['lat']; ?>, <?php echo $locationInfo['lng']; ?>),
            type: "iconMap",
            servicetypes: '<?php
                            for ($k = 0; $k < count($businessServiceTypes); $k++) {
                              echo $businessServiceTypes[$k]['service_type_name'];
                              if ($k < (count($businessServiceTypes) - 1)) {
                                echo ', ';
                              }
                            } ?>',
            imgiInfo: '<?php echo BUSINESS_PROFILE_PATH . $businessInfo['business_avatar']; ?>',
            linkInfo: '',
            titleInfo: '<?php echo $businessInfo['business_name']; ?>',
            starInfo: '',
            evaluateInfo: 0,
            linkClose: '1',
            linkLocation: '',
            linkView: '<?php echo base_url(BUSINESS_PROFILE_URL . $businessInfo['business_url']); ?>',
          },
        <?php } ?>
      ];
      // Create markers.
      for (let i = 0; i < features.length; i++) {
        var open_status = "";
        if (features[i].linkClose == 1) {
          open_status = `<a href="javascript:void(0);" class="text-success"><?php echo $this->lang->line('opening'); ?></a>`;
        } else {
          open_status = `<a href="javascript:void(0);" class="customer-location-close"><?php echo $this->lang->line('closed'); ?></a>`;
        }
        var link_location = "";
        if (features[i].linkLocation !== "") {
          link_location = `<a href="${features[i].linkLocation}"><img src="assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon"
                            alt="location image"></a>`;
        }
        /*
        const infoMap = `<div class="card rounded-0 customer-location-item mb-2">
              <div class="row g-0">
                  <div class="col-3">
                      <a href="#" class="customer-location-img"><img  src="${features[i].imgiInfo}" class="img-fluid" alt="location image" style="max-width: 100%; height: auto"></a>
                  </div>
                  <div class="col-9">
                      <div class="card-body p-0 ml-2">
                          <h6 class="card-title mb-1 page-text-xs"><a href="${features[i].linkInfo}" title="">${features[i].titleInfo}</a></h6>
                          <div class="d-flex align-items-center mb-5px"> 
                            <div class="star-rating on line  mr-8px relative"> 
                                <div class="star-base">
                                  <div class="star-rate" data-rate="<?php echo $reviewInfo['star']; ?>"></div> 
                                  <a dt-value="1" href="javascript:void(0)"></a> 
                                  <a dt-value="2" href="javascript:void(0)"></a> 
                                  <a dt-value="3" href="javascript:void(0)"></a> 
                                  <a dt-value="4" href="javascript:void(0)"></a> 
                                  <a dt-value="5" href="javascript:void(0)"></a>
                                </div>
                            </div>
                            <span>(<?php echo $reviewInfo['sumReview']; ?>)</span>
                        </div>
                          <ul class="list-inline mb-2 list-rating-sm">
                            ${features[i].starInfo}
                          </ul>
                          <p class="card-text mb-0 page-text-xxs text-secondary">${features[i].servicetypes}
                          </p>
                          ${open_status}
                          
                          <a target="_blank" href="${features[i].linkView}"
                              class="btn btn-outline-red btn-outline-red-xs btn-view">${textView}</a>
                      </div>
                  </div>
              </div>
          </div>`;
        */
        const infoMap = `<h6 class="card-title mb-1 page-text-xs text-center"><a target="_blank" href="<?php echo base_url($businessInfo['business_url']); ?>" title=""><?php echo $businessInfo['business_name']; ?></a></h6>`;
        const infowindow = new google.maps.InfoWindow({
          content: infoMap,
        });
        starRate();
        const marker = new google.maps.Marker({
          position: features[i].position,
          icon: icons[features[i].type].icon,
          map: map,
        });
        infowindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
          });
        marker.addListener("click", () => {
          infowindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
          });
        });
      }
    }
    
  }
</script>