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
              <h5 class="fw-bold animate__animated animate__fadeInLeft"><?php 
                if($language_id == 1){
                  echo $configs['HOME_BANNER_TEXT']; 
                }else if($language_id == 2){
                  echo $configs['HOME_BANNER_TEXT_CZ']; 
                }else if($language_id == 3){
                  echo $configs['HOME_BANNER_TEXT_DE']; 
                }else if($language_id == 4){
                  echo $configs['HOME_BANNER_TEXT_VI']; 
                }
                
              ?>
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
        <div class="container container-owl">
          <h2 class="page-heading fw-bold page-title"><?php echo $this->lang->line('services'); ?></h2>
          <div class="owl-carousel owl-customer-service">
            <?php for ($i = 0; $i < count($services); $i++) {
              $serviceUrl = base_url('service/' . makeSlug($services[$i]['service_slug']) . '-' . $services[$i]['id']) . '.html'; ?>
              <div class="item">
                <div class="card customer-service-item">
                  <a href="<?php echo $serviceUrl; ?>" class="customer-service-img c-img">
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
          <a href="<?php echo base_url('services.html'); ?>" class="btn btn-red discover_more"><?php echo $this->lang->line('discover_more'); ?></a>
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
                    <p><a href="<?php echo base_url('events.html'); ?>" class="btn btn-red discover_more"><?php echo $this->lang->line('discover_more'); ?></a></p>
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
        <div class="container container-owl">
          <h2 class="text-center page-title"><?php echo $this->lang->line('coupons'); ?></h2>
          <div class="owl-carousel owl-coupon">
            <!-- item coupon -->
            <?php foreach ($listCoupons as $indexCoupon => $itemCoupon) {
              $couponDetailUrl = base_url('coupon/' . makeSlug($itemCoupon['coupon_subject']) . '-' . $itemCoupon['id']) . '.html'; ?>
              <div class="item position-relative coupon-item-<?php echo $itemCoupon['id']; ?>">
                <a class="card customer-coupon-item" href="<?php echo $couponDetailUrl; ?>">
                  <p class="customer-coupon-img mb-0 c-img">
                    <img src="<?php echo COUPONS_PATH . $itemCoupon['coupon_image']; ?>" class="img-fluid" alt="<?php echo $itemCoupon['coupon_subject']; ?>">
                  </p>
                  <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                    <div class="customer-coupon-body">
                      <h6 class="card-title"><?php echo $itemCoupon['coupon_subject']; ?></h6>
                      <p class="card-text page-text-xs"><?php echo ddMMyyyy($itemCoupon['start_date'], 'M d, Y'); ?> to <?php echo ddMMyyyy($itemCoupon['end_date'], 'M d, Y'); ?></p>
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
                <a href="javascript:void(0)" class="btn btn-outline-red btn-outline-red-md btn-getnow get-coupon-in-list" data-customer="<?php echo $customer['id']; ?>" data-id="<?php echo $itemCoupon['id']; ?>" data-index="<?php echo $indexCoupon; ?>"><?php echo $this->lang->line('1310_get-now'); ?></a>
              </div>
            <?php } ?>
            <!-- item coupon -->
          </div>
          <div class="text-right">
            <a href="<?php echo base_url('coupons.html'); ?>" class="view-all"><?php echo $this->lang->line('1310_view-all'); ?></a>
          </div>
        </div>
      </section>
      <!-- End Customer Coupon -->
    <?php } ?>

    <?php if (!empty($home_video)) { ?>
      <!-- Customer Video -->
      <section class="customer-video">
        <div class="container">
          <div class="justify-content-center d-flex">
              <div class="customer-video-content">
                <iframe width="1000" height="500" src="https://www.youtube.com/embed/<?php echo getYoutubeIdFromUrl($home_video); ?>" title="Asia Dragon Bazar" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </section>
      <!-- End Customer Video -->
    <?php } ?>


    <!-- Customer Location -->
    <section class="customer-location" id="maps">
      <div class="container">
        <h2 class="page-heading page-title"><?php echo $this->lang->line('location'); ?></h2>
        <div class="row">
          <div class="col-lg-4">
            <div class="customer-location-dropdown">
              <div class="custom-select mb-20">
                <?php $this->Mconstants->selectObject($listServices, 'id', 'service_name', 'selectServiceMap', 0, true, $this->lang->line('all'), ' '); ?>
              </div>
            </div>
            <div class="customer-location-left">
              <div class="customer-location-list">

              </div>
              <div id="profilePagging"></div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="text-right mb-20">
              <div class="wrapper-search">
                <div class="d-flex search-box">
                  <a href="javascript:void(0)" class="search-box-icon"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                  <input class="form-control" type="text" placeholder="<?php echo $this->lang->line('search'); ?>" aria-label="Search" id="search_text" name="keyword" value="<?php echo $keyword; ?>">
                </div>
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
                    <form class="row g-3" action="<?php echo base_url('customer/send-contact-us'); ?>" id="formContactUs" method="POST">
                      <input name="customer_id" id="contactCustomer" type="hidden" value="<?php if (isset($customer['id'])) { echo $customer['id']; } else { echo 0; } ?>" />
                      <h3 class="fw-bold text-center mb-4"><?php echo $this->lang->line('contact_us'); ?></h3>
                      <div class="col-12">
                        <input type="text" class="form-control" name="contact_name" id="contactName" placeholder="Name" required>
                      </div>
                      <div class="col-12">
                        <input type="email" class="form-control" name="contact_email" id="contactEmail" placeholder="<?php echo $this->lang->line('email'); ?>" required>
                      </div>
                      <div class="col-12">
                        <textarea class="form-control" name="contact_message" id="contactMessage" rows="3" placeholder="Type your message here" required></textarea>
                      </div>
                      <div class="col-12 d-flex justify-content-center btn-submit">
                        <button type="submit" class="btn btn-red"><?php echo $this->lang->line('submit'); ?></button>
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
  var please_enter_your_contact_information = "<?php echo 'Please enter your contact information' ?>";
  var iconMap = "<?php echo (isset($configs['MARKER_MAP_IMAGE']) && !empty($configs['MARKER_MAP_IMAGE'])) ? CONFIG_PATH . $configs['MARKER_MAP_IMAGE'] : CONFIG_PATH . "iconmap.png" ?>";

  $("#formContactUs").submit(function(event) {
    event.preventDefault();
    var email = $("#contactEmail").val();
    var name = $("#contactName").val();
    var message = $("#contactMessage").val();
    var customer_id = $("#contactCustomer").val();
    
    if (email !== "" && name != "" && message != "") {
      //this.submit();
      $.ajax({
        type: "POST",
        url: $('#formContactUs').attr('action'),
        data: {
          contact_name: name,
          contact_email: email,
          contact_message: message,
          customer_id: customer_id
        },
        dataType: 'json',
        success: function(response) {
          if(response.code == 1){
            $(".notiPopup .text-secondary").html(response.message);
            $(".ico-noti-success").removeClass('ico-hidden');
           $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }else{
            $(".notiPopup .text-secondary").html(response.message);
            $(".ico-noti-error").removeClass('ico-hidden');
           $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }
        },
        error: function(response) {}
      });
    } else {
      $(".notiPopup .text-secondary").html(please_enter_your_contact_information);
      $(".ico-noti-error").removeClass('ico-hidden');
      $(".notiPopup").fadeIn('slow').fadeOut(5000);
    }
  });
</script>
