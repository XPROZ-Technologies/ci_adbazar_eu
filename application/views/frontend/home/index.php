<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-customer-home">
    <?php if (count($listSlidersHome) > 0) { ?>
      <!-- Home Slider -->
      <section class="customer-slider">
        <!-- <div class="container"> -->
        <div id="carouselCustomer" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-caption text-left">
            <div class="container">
              <h5 class="fw-bold animate__animated animate__fadeInLeft"><?php echo $configs['HOME_BANNER_TEXT']; ?>
              </h5>
            </div>
          </div>
          <div class="carousel-inner">
            <?php foreach ($listSlidersHome as $indexSlider => $homeSlider) { ?>
              <div class="carousel-item <?php if ($indexSlider == 0) { ?>active<?php } ?>">
                <img src="<?php echo SLIDER_PATH . $homeSlider['slider_image']; ?>" class="d-block w-100" alt="">
              </div>
            <?php } ?>
          </div>
        </div>
        <!-- </div> -->
      </section>
      <!-- END. Home Slider  -->
    <?php } ?>

    <?php if (!empty($services) && count($services) > 0) { ?>
      <!-- Customer Service -->
      <section class="home-service">
        <div class="container">
          <h2 class="page-heading fw-bold page-title">Services</h2>
          <div class="owl-carousel owl-customer-service">
            <?php for ($i = 0; $i < count($services); $i++) {
              $serviceUrl = base_url('service/' . makeSlug($services[$i]['service_slug']) . '-' . $services[$i]['id']) . '.html'; ?>
              <div class="item">
                <div class="card customer-service-item">
                  <a href="<?php echo $serviceUrl; ?>" class="customer-service-img">
                    <img src="<?php echo SERVICE_PATH . $services[$i]['service_image'] ?>" class="card-img-top img-fluid" alt="<?php echo $services[$i]['service_name']; ?>">
                  </a>
                  <div class="card-body text-center">
                    <h5 class="card-title">
                      <a href="<?php echo $serviceUrl; ?>"><?php echo $services[$i]['service_name']; ?></a>
                    </h5>

                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
          <a href="<?php echo base_url('services.html'); ?>" class="btn btn-red discover_more">Discover more</a>
        </div>
      </section>
      <!-- End Customer Service -->
    <?php } ?>

    <?php if (count($listSlidersEvent) > 0) { ?>
      <!-- Customer Event Slider -->
      <section class="home-event-slider">
        <div id="carouselCustomerEvent" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            <?php foreach ($listSlidersEvent as $indexSlider => $eventSlider) { ?>
              <button type="button" data-bs-target="#carouselCustomerEvent" data-bs-slide-to="<?php echo $indexSlider; ?>" class="<?php if ($indexSlider  == 0) {
                                                                                                                                    echo 'active';
                                                                                                                                  } ?>" aria-current="true" aria-label="Slider Event <?php echo ($indexSlider + 1); ?>"></button>
            <?php } ?>
          </div>
          <div class="carousel-inner">
            <?php foreach ($listSlidersEvent as $indexSlider => $eventSlider) { ?>
              <div class="carousel-item <?php if ($indexSlider  == 0) {
                                          echo 'active';
                                        } ?>">
                <img src="<?php echo SLIDER_PATH . $eventSlider['slider_image']; ?>" class="d-block w-100" alt="">
                <div class="carousel-caption">
                  <div class="container">
                    <h4 class="page-title"><?php echo $configs['EVENT_BANNER_TEXT']; ?></h4>
                    <p><a href="<?php echo base_url('events.html'); ?>" class="btn btn-red discover_more">Discover more</a></p>
                  </div>
                </div>
              </div>
            <?php } ?>

          </div>
        </div>
      </section>
      <!-- End Customer Event Slider -->
    <?php } ?>


    <?php if (count($listCoupons) > 0) { ?>
      <!-- Customer Coupon -->
      <section class="home-coupon">
        <div class="container">
          <h2 class="text-center page-title">Coupons</h2>
          <div class="owl-carousel owl-coupon">
            <!-- item coupon -->
            <?php foreach ($listCoupons as $indexCoupon => $itemCoupon) {
              $couponDetailUrl = base_url('coupon/' . makeSlug($itemCoupon['coupon_subject']) . '-' . $itemCoupon['id']) . '.html'; ?>
              <div class="item position-relative coupon-item-<?php echo $itemCoupon['id']; ?>">
                <a class="card customer-coupon-item" href="<?php echo $couponDetailUrl; ?>">
                  <p class="customer-coupon-img mb-0">
                    <img src="<?php echo COUPONS_PATH . $itemCoupon['coupon_image']; ?>" class="img-fluid" alt="<?php echo $itemCoupon['coupon_subject']; ?>">
                  </p>
                  <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                    <div class="customer-coupon-body">
                      <h6 class="card-title"><?php echo $itemCoupon['coupon_subject']; ?></h6>
                      <p class="card-text page-text-xs"><?php echo ddMMyyyy($itemCoupon['start_date']); ?> to <?php echo ddMMyyyy($itemCoupon['end_date']); ?></p>
                      <div class="d-flex align-items-center justify-content-between">
                        <div class="wraper-progress">
                          <div class="progress">
                            <div class="progress-bar page-text-xs fw-500" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="progress-text"><span class="progress-first"><?php echo $itemCoupon['coupon_amount_used']; ?></span>/<span class="progress-last"><?php echo $itemCoupon['coupon_amount']; ?></span></span></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
                <a href="javascript:void(0)" class="btn btn-outline-red btn-outline-red-md btn-getnow get-coupon-in-list" data-customer="<?php echo $customer['id']; ?>" data-id="<?php echo $itemCoupon['id']; ?>" data-index="<?php echo $indexCoupon; ?>">Get now</a>
              </div>
            <?php } ?>
            <!-- item coupon -->
          </div>
          <div class="text-right">
            <a href="<?php echo base_url('coupons.html'); ?>" class="view-all">View all</a>
          </div>
        </div>
      </section>
      <!-- End Customer Coupon -->
    <?php } ?>

    <?php if (!empty($configs['VIDEO_URL'])) { ?>
      <!-- Customer Video -->
      <section class="customer-video">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-10">
              <div class="customer-video-content">
                <iframe width="1280" height="720" src="https://www.youtube.com/embed/<?php echo getYoutubeIdFromUrl($configs['VIDEO_URL']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Customer Video -->
    <?php } ?>


    <!-- Customer Location -->
    <section class="customer-location" id="maps">
      <div class="container">
        <h2 class="page-heading page-title">Location</h2>
        <div class="row">
          <div class="col-lg-4">
            <div class="customer-location-dropdown">
              <div class="custom-select mb-20">
                <select id="selectServiceMap">
                  <option value="0" selected>All</option>
                  <?php if (!empty($listServices)) {
                    foreach ($listServices as $itemService) ?>
                    <option value="<?php echo $itemService['id']; ?>" <?php if ($service_id == $itemService['id']) {
                                                                        echo 'selected="selected"';
                                                                      } ?>><?php echo $itemService['service_name']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="customer-location-left">
              <div class="customer-location-list">
                <?php if (!empty($listProfiles) > 0) { ?>
                  <!-- business item -->
                  <?php foreach ($listProfiles as $kBusines => $itemBusines) { ?>
                    <div class="card rounded-0 customer-location-item mb-2">
                      <div class="row g-0">
                        <div class="col-3">
                          <a href="#" class="customer-location-img"><img src="<?php echo BUSINESS_PROFILE_PATH . $itemBusines['business_avatar']; ?>" class="img-fluid" alt="<?php echo $itemBusines['business_name']; ?>"></a>
                        </div>
                        <div class="col-9">
                          <div class="card-body p-0">
                            <h6 class="card-title mb-1 page-text-xs"><a href="<?php echo base_url(BUSINESS_PROFILE_URL . $itemBusines['business_url']); ?>" title=""><?php echo $itemBusines['business_name']; ?></a></h6>
                            <!--
                            <ul class="list-inline mb-2 list-rating-sm">
                              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                              <li class="list-inline-item me-0">(10)</li>
                            </ul>
                            -->
                            <p class="card-text mb-0 page-text-xxs text-secondary"><?php $businessServiceTypes = $itemBusines['businessServiceTypes'];
                                                                                    for ($k = 0; $k < count($businessServiceTypes); $k++) {
                                                                                      echo $businessServiceTypes[$k]['service_type_name'];
                                                                                      if ($k < (count($businessServiceTypes) - 1)) {
                                                                                        echo ', ';
                                                                                      }
                                                                                    } ?>
                            </p>
                            <?php if ($itemBusines['isOpen']) { ?>
                              <a href="" class="text-success">Opening</a>
                            <?php } else { ?>
                              <a href="" class="customer-location-close">Closed</a>
                            <?php } ?>
                            <!--<a href=""><img src="assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon" alt="location image"></a>-->
                            <a href="#" class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <!-- END. business item-->
                <?php } ?>

              </div>
              <?php if (!empty($listProfiles) > 0) { ?>
                <!-- pagination -->
                <nav>
                  <?php echo $paggingHtml; ?>
                </nav>
                <!-- END. pagination -->
              <?php } ?>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="text-right mb-20">
              <div class="wrapper-search">
                <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                  <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                  <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>">
                </form>
              </div>
            </div>
            <div class="customer-location-right">
              <div id="map"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- End Customer Location -->

    <!-- Customer Contact -->
    <section class="customer-contact" id="contact-us">
      <div class="container">
        <div class="row justify-content-center">
          <div class=" col-lg-9">
            <div class="drop-shadow">
              <div class="row g-0">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                  <div class="customer-contact-left d-flex align-items-center">
                    <form class="row g-3" action="" id="formContactUs" method="POST">
                      <h3 class="fw-bold text-center mb-4">Contact Us </h3>
                      <div class="col-12">
                        <input type="text" class="form-control" name="contact_name" id="contactName" placeholder="Name" required>
                      </div>
                      <div class="col-12">
                        <input type="email" class="form-control" name="contact_email" id="contactEmail" placeholder="Email" required>
                      </div>
                      <div class="col-12">
                        <textarea class="form-control" name="contact_message" id="contactMessage" rows="3" placeholder="Type your message here" required ></textarea>
                      </div>
                      <div class="col-12 d-flex justify-content-center btn-submit">
                        <button type="submit" class="btn btn-red">Submit</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                  <div class="customer-contact-right">
                    <img src="<?php echo CONFIG_PATH . $configs['CONTACT_US_IMAGE']; ?>" class="img-fluid h-100" alt="slider image">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Customer Contact -->
  </div>
</main>
<!-- footer script -->
<?php $this->load->view('frontend/includes/footer'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo KEY_GOOGLE_MAP; ?>&callback=initMap&libraries=&v=weekly" async></script>
<script>
  if ($('#map').length > 0) {
    let map;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(50.047648687939635, 12.355822100555436),
        zoom: 16,
      });
    
      const iconBase =
        "<?php echo CONFIG_PATH; ?>";
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
        <?php if (!empty($listProfilesMap) > 0) {
          foreach ($listProfilesMap as $kBusines => $itemBusines) {
              if(!empty($itemBusines['locationInfo'])){ ?> {
              position: new google.maps.LatLng(<?php echo $itemBusines['locationInfo']['lat']; ?>, <?php echo $itemBusines['locationInfo']['lng']; ?>),
              type: "iconMap",
              servicetypes: '',
              imgiInfo: '<?php echo BUSINESS_PROFILE_PATH . $itemBusines['business_avatar']; ?>',
              linkInfo: '',
              titleInfo: '<?php echo $itemBusines['business_name']; ?>',
              starInfo: '',
              evaluateInfo: 0,
              linkClose: '<?php echo $itemBusines['isOpen']; ?>',
              linkLocation: '',
              linkView: '<?php echo base_url(BUSINESS_PROFILE_URL . $itemBusines['business_url']); ?>',
            },
        <?php } }
        } ?>
      ];
      // Create markers.
      for (let i = 0; i < features.length; i++) {
        var rank = ``;
        if (features[i].starInfo === 0) {
          var rank = `
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              `;
        } else if (features[i].starInfo === 1) {
          var rank = `
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              `;
        } else if (features[i].starInfo === 2) {
          var rank = `
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              `;
        } else if (features[i].starInfo === 3) {
          var rank = `
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              `;
        } else if (features[i].starInfo === 4) {
          var rank = `
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
              `;
        } else if (features[i].starInfo === 5) {
          var rank = `
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
              `;
        }
        var open_status = "";
        if (features[i].linkClose == 1) {
          open_status = `<a href="javascript:void(0);" class="text-success">Opening</a>`;
        } else {
          open_status = `<a href="javascript:void(0);" class="customer-location-close">Closed</a>`;
        }
        var evaluate_info = "";
        if (features[i].evaluateInfo !== 0) {
          evaluate_info = `<li class="list-inline-item me-0">(${features[i].evaluateInfo})</li>`;
        }
        var link_location = "";
        if (features[i].linkLocation !== "") {
          link_location = `<a href="${features[i].linkLocation}"><img src="assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon"
                            alt="location image"></a>`;
        }

        const infoMap = `<div class="card rounded-0 customer-location-item mb-2">
              <div class="row g-0">
                  <div class="col-3">
                      <a href="#" class="customer-location-img"><img  src="${features[i].imgiInfo}" class="img-fluid" alt="location image" style="max-width: 100%; height: auto"></a>
                  </div>
                  <div class="col-9">
                      <div class="card-body p-0 ml-2">
                          <h6 class="card-title mb-1 page-text-xs"><a href="${features[i].linkInfo}" title="">${features[i].titleInfo}</a></h6>
                          <ul class="list-inline mb-2 list-rating-sm">
                            ${rank}
                            ${evaluate_info}
                          </ul>
                          <p class="card-text mb-0 page-text-xxs text-secondary">${features[i].servicetypes}
                          </p>
                          ${open_status}
                          
                          <a target="_blank" href="${features[i].linkView}"
                              class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
                      </div>
                  </div>
              </div>
          </div>`;
        const infowindow = new google.maps.InfoWindow({
          content: infoMap,
        });
        const marker = new google.maps.Marker({
          position: features[i].position,
          icon: icons[features[i].type].icon,
          map: map,
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
  
  $( "#formContactUs" ).submit(function( event ) {
      event.preventDefault();
      var email = $("#contactEmail").val();
      var name = $("#contactNam").val();
      var message = $("#contactMessage").val();
      if(email !== "" && name != "" && message != ""){
          //this.submit();
          $(".notiPopup").addClass('show');
          $(".notiPopup .text-secondary").html('Message sent');
          $(".ico-noti-success").removeClass('ico-hidden');
      }else{
          $(".notiPopup").addClass('show');
          $(".notiPopup .text-secondary").html('Please enter your contact information');
          $(".ico-noti-error").removeClass('ico-hidden');
      }
  });
</script>