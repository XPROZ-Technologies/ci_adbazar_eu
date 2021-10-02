<?php $this->load->view('frontend/includes/header') ?>
    <main>
        <div class="page-customer-home">
            <?php if(count($listSlidersHome) > 0){ ?>
            <!-- Home Slider -->
            <section  class="customer-slider">
              <!-- <div class="container"> -->
                <div id="carouselCustomer" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach($listSlidersHome as $indexSlider => $homeSlider){ ?>
                            <button type="button" data-bs-target="#carouselCustomer" data-bs-slide-to="<?php echo $indexSlider; ?>" <?php if($indexSlider == 0){ echo 'class="active"'; } ?> aria-current="true" aria-label="Home Banner <?php echo ($indexSlider + 1); ?>"></button>
                        <?php } ?>
                    </div>
                    <div class="carousel-inner">
                        <!-- Slider Item -->
                        <?php foreach($listSlidersHome as $indexSlider => $homeSlider){ ?>
                            <div class="carousel-item <?php if($indexSlider == 0){ ?>active<?php } ?>">
                                <img src="<?php echo SLIDER_PATH.$homeSlider['slider_image']; ?>" class="d-block w-100" alt="<?php echo $configs['HOME_BANNER_TEXT']; ?>">
                                <div class="carousel-caption text-left">
                                    <div class="container">
                                        <h5 class="fw-bold animate__animated animate__fadeInLeft"><?php echo $configs['HOME_BANNER_TEXT']; ?></h5>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END. Slider Item -->
                    </div>
                </div>
              <!-- </div> -->
            </section>
            <!-- End. Home Slider -->
            <?php } ?>

            <?php if(!empty($services) && count($services) > 0){ ?>
                <!-- Customer Service -->
                <section class="home-service">
                    <div class="container">
                        <h2 class="page-heading fw-bold page-title text-center">Services</h2>
                        <div class="owl-carousel owl-customer-service">
                            <?php for($i = 0; $i < count($services); $i++){ $serviceUrl = base_url('service/'.makeSlug($services[$i]['service_slug']).'-'.$services[$i]['id']).'.html'; ?>
                                <!-- item service -->
                                <div class="item">
                                    <div class="card customer-service-item">
                                        <a href="<?php echo $serviceUrl; ?>" class="customer-service-img">
                                            <img src="<?php echo SERVICE_PATH.$services[$i]['service_image'] ?>" class="card-img-top img-fluid"
                                                alt="<?php echo $services[$i]['service_name']; ?>">
                                        </a>
                                        <div class="card-body text-center">
                                            <h5 class="card-title">
                                                <a href="<?php echo $serviceUrl; ?>"><?php echo $services[$i]['service_name']; ?></a>
                                            </h5>

                                        </div>
                                    </div>
                                </div>
                                <!-- END. item service -->
                            <?php } ?>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="<?php echo base_url('services.html'); ?>" class="btn btn-red">Discover more</a>
                        </div>
                    </div>
                </section>
                <!-- End Customer Service -->
            <?php } ?>

            <!-- Customer Coupon -->
            <?php if(count($listCoupons) > 0){ ?>
            <section class="home-coupon">
                <h2 class="text-center page-title">Coupons</h2>
                <div class="container">
                    <div class="owl-carousel owl-coupon">
                        <!-- coupon item -->
                        <?php foreach($listCoupons as $indexCoupon => $itemCoupon){ $couponDetailUrl = base_url('coupon/'.makeSlug($itemCoupon['coupon_subject']).'-'.$itemCoupon['id']).'.html'; ?>
                            <div class="item">
                                <div class="card customer-coupon-item">
                                    <a href="<?php echo $couponDetailUrl; ?>" class="customer-coupon-img">
                                        <img src="<?php echo COUPONS_PATH.$itemCoupon['coupon_image']; ?>" class="img-fluid" alt="<?php echo $itemCoupon['coupon_subject']; ?>">
                                    </a>
                                    <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                                        <div class="customer-coupon-body">
                                            <h6 class="card-title page-text-sm"><a href="<?php echo $couponDetailUrl; ?>"><?php echo $itemCoupon['coupon_subject']; ?></a></h6>
                                            <p class="card-text page-text-xs"><?php echo ddMMyyyy($itemCoupon['start_date']); ?> to <?php echo ddMMyyyy($itemCoupon['end_date']); ?></p>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="wraper-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar page-text-xs fw-500" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">0/<?php echo $itemCoupon['coupon_amount']; ?></div>
                                                    </div>
                                                </div>
                                                <a href="javascript:void(0)" class="btn btn-outline-red btn-outline-red-md btn-getnow">Get now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END. coupon item -->
                        
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="<?php echo base_url('coupons.html'); ?>" class="btn btn-red">View all</a>
                    </div>
                </div>
            </section>
            <?php } ?>
            <!-- End Customer Coupon -->
            
            <?php if(count($listSlidersEvent) > 0){ ?>
            <!-- Customer Event Slider -->
            <section class="home-event-slider">
                <div id="carouselCustomerEvent" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach($listSlidersEvent as $indexSlider => $eventSlider){ ?>
                            <button type="button" data-bs-target="#carouselCustomerEvent" data-bs-slide-to="<?php echo $indexSlider; ?>" <?php if($indexSlider  == 0){ echo 'class="active"'; } ?> aria-current="true" aria-label="Slider Event <?php echo ($indexSlider+1); ?>"></button>
                        <?php } ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach($listSlidersEvent as $indexSlider => $eventSlider){ ?>
                            <div class="carousel-item <?php if($indexSlider  == 0){ echo 'active'; } ?>">
                                <img src="<?php echo SLIDER_PATH.$eventSlider['slider_image']; ?>" class="d-block w-100" alt="">
                                <div class="carousel-caption">
                                    <div class="container">
                                        <h4 class="fw-bold page-title animate__animated animate__fadeInLeft"><?php echo $configs['EVENT_BANNER_TEXT']; ?></h4>
                                        <p><a href="#" class="btn btn-red">Discover more</a></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <!-- End Customer Event Slider -->
            <?php } ?>

            <!-- Customer Video -->
            <section class="customer-video">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="customer-video-content">
                                <!-- <a href="#" class="icon-video js-play-video">
                                    <img src="assets/img/frontend/ic-play-video.png" alt="icon play" class="img-fluid">
                                </a> -->
                                <iframe width="1280" height="720" src="https://www.youtube.com/embed/<?php echo getYoutubeIdFromUrl($configs['VIDEO_URL']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Customer Video -->

            <!-- Customer Location -->
            <section class="customer-location">
                <div class="container">
                    <div class="d-flex flex-column flex-lg-row justify-content-lg-between mb-4">
                        <h2 class="page-heading page-title">Location</h2>
                        <div class="col-lg-4 wrapper-search">
                            <form class="d-flex search-box">
                                <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.svg" alt="search icon"></a>
                                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="customer-location-left">
                                <div class="customer-location-dropdown">
                                    <div class="custom-select">
                                        <select>
                                            <option value="0" selected>All</option>
                                            <option value="1">Beauty salons</option>
                                            <option value="2">Wellnesses - Spas</option>
                                            <option value="3">Restaurants</option>
                                            <option value="4">Shops</option>
                                            <option value="5">Casinos</option>
                                            <option value="6">Hotels</option>
                                            <option value="7">Pharmacies</option>
                                            <option value="8">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="customer-location-list">
                                    <div class="card rounded-0 customer-location-item mb-2">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                <a href="#" class="customer-location-img"><img
                                                        src="assets/img/frontend/home-location1.svg" class="img-fluid"
                                                        alt="location image"></a>
                                            </div>
                                            <div class="col-9">
                                                <div class="card-body p-0">
                                                    <h6 class="card-title mb-1 page-text-xs"><a href="#" title="">Khai
                                                            Lam - Vietnamese Traditional Restaurant</a></h6>

                                                    <ul class="list-inline mb-2 list-rating-sm">
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star"></i></a></li>
                                                        <li class="list-inline-item me-0">(10)</li>
                                                    </ul>
                                                    <p class="card-text mb-0 page-text-xxs text-secondary">Restaurants
                                                    </p>
                                                    <a href="" class="customer-location-close">Closed</a>
                                                    <a href=""><img src="assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon"
                                                      alt="location image"></a>
                                                    <a href="#"
                                                        class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card rounded-0 customer-location-item mb-2">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                <a href="#" class="customer-location-img"><img
                                                        src="assets/img/frontend/home-location2.svg" class="img-fluid"
                                                        alt="location image"></a>
                                            </div>
                                            <div class="col-9">
                                                <div class="card-body p-0">
                                                    <h6 class="card-title mb-1 page-text-xs"><a href="#" title="">Khai
                                                            Lam - Vietnamese Traditional Restaurant</a></h6>

                                                    <ul class="list-inline mb-2 list-rating-sm">
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star"></i></a></li>
                                                        <li class="list-inline-item me-0">(10)</li>
                                                    </ul>
                                                    <p class="card-text mb-0 page-text-xxs text-secondary">Restaurants
                                                    </p>
                                                    <a href="" class="customer-location-close">Closed</a>
                                                    <a href=""><img src="assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon"
                                                      alt="location image"></a>
                                                    <a href="#"
                                                        class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card rounded-0 customer-location-item mb-2">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                <a href="#" class="customer-location-img"><img
                                                        src="assets/img/frontend/home-location3.svg" class="img-fluid"
                                                        alt="location image"></a>
                                            </div>
                                            <div class="col-9">
                                                <div class="card-body p-0">
                                                    <h6 class="card-title mb-1 page-text-xs"><a href="#" title="">Khai
                                                            Lam - Vietnamese Traditional Restaurant</a></h6>

                                                    <ul class="list-inline mb-2 list-rating-sm">
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star"></i></a></li>
                                                        <li class="list-inline-item me-0">(10)</li>
                                                    </ul>
                                                    <p class="card-text mb-0 page-text-xxs text-secondary">Restaurants
                                                    </p>
                                                    <a href="" class="customer-location-close">Closed</a>
                                                    <a href=""><img src="assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon"
                                                      alt="location image"></a>
                                                    <a href="#"
                                                        class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card rounded-0 customer-location-item mb-2">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                <a href="#" class="customer-location-img"><img
                                                        src="assets/img/frontend/home-location4.svg" class="img-fluid"
                                                        alt="location image"></a>
                                            </div>
                                            <div class="col-9">
                                                <div class="card-body p-0">
                                                    <h6 class="card-title mb-1 page-text-xs"><a href="#" title="">Khai
                                                            Lam - Vietnamese Traditional Restaurant</a></h6>

                                                    <ul class="list-inline mb-2 list-rating-sm">
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star-fill"></i></a></li>
                                                        <li class="list-inline-item me-0"><a href="#"><i
                                                                    class="bi bi-star"></i></a></li>
                                                        <li class="list-inline-item me-0">(10)</li>
                                                    </ul>
                                                    <p class="card-text mb-0 page-text-xxs text-secondary">Restaurants
                                                    </p>
                                                    <a href="" class="customer-location-close">Closed</a>
                                                    <a href=""><img src="assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon"
                                                      alt="location image"></a>
                                                    <a href="#"
                                                        class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <nav>
                                    <ul class="pagination justify-content-center mb-lg-0">
                                        <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="customer-location-right">
                              <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Customer Location -->

            <!-- About us -->
            <!-- <section class="home-about-us">
                <h2 class="text-center page-title">About us</h2>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="content">
                                <p class="text-center page-text-md">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula
                                    eget lacus viverra, quis gravida massa iaculis. Nulla luctus gravida nulla.
                                    Pellentesque sit amet fringilla nunc. Nam eget quam a lectus fringilla euismod.
                                    Praesent ut sollicitudin ante, vitae suscipit nulla. Duis efficitur ac augue nec
                                    porttitor. Aliquam erat volutpat.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
            <!-- End About us -->

            <!-- Customer Contact -->
            <section class="customer-contact">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class=" col-lg-9">
                          <div class="drop-shadow">
                            <div class="row g-0">
                              <div class="col-lg-6">
                                  <div class="customer-contact-left">
                                      <h3 class="fw-bold text-center mb-4">Contact Us </h3>
                                      <form class="row g-3" action="#">
                                          <div class="col-12">
                                              <input type="text" class="form-control" id="customerName"
                                                  placeholder="Name">
                                          </div>
                                          <div class="col-12">
                                              <input type="email" class="form-control" id="customerEmail"
                                                  placeholder="Email">
                                          </div>
                                          <div class="col-12">
                                              <textarea class="form-control" id="customerContente" rows="3"
                                                  placeholder="Type your message here"></textarea>
                                          </div>
                                          <div class="col-12 d-flex justify-content-center btn-submit">
                                              <button type="submit" class="btn btn-red">Submit</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                              <div class="col-lg-6 d-none d-lg-block">
                                  <div class="customer-contact-right">
                                    <img src="assets/img/frontend/contact-img.svg" class="img-fluid h-100" alt="slider image">
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
<?php $this->load->view('frontend/includes/footer'); ?>    