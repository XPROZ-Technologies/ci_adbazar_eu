<?php $this->load->view('frontend/includes/header'); ?>
    <main>
        <div class="page-customer-coupon">
            <div class="customer-coupon">
                <div class="container">
                    <h2 class="page-heading page-title-md text-black mb-0 fw-bold">All coupons</h2>
                    <form class="d-flex search-box">
                        <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.svg" alt="search icon"></a>
                        <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                    </form>
                    <div
                        class="notification-wrapper-filter d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex align-items-center inner-filter">
                            <span class="me-2 page-text-lg">Filter by</span>
                            <div class="notification-filter">
                                <div class="custom-select">
                                    <select>
                                        <option value="0" selected>All</option>
                                        <option value="1">Personal</option>
                                        <option value="2">The Rice Bowl</option>
                                        <option value="3">Inspire Beauty Salon</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center notification-sort">
                            <img src="assets/img/frontend/ic-sort.svg" alt="sort icon" class="img-fluid me-2">
                            <div class="custom-select mb-0">
                                <select>
                                    <option value="0" selected>Newest</option>
                                    <option value="1">Oldest</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php if(count($serviceTypes) > 0){ ?>
                      <!-- service type -->
                      <div class="list-tags">
                          <ul class="list-unstyled list-inline">
                              <?php foreach($serviceTypes as $serviceTypeItem){ ?>
                                <li class="list-inline-item page-text-xs fw-500"><a href="javascript:void(0)"><?php echo $serviceTypeItem['service_type_name']; ?></a></li>
                              <?php } ?>
                          </ul>
                      </div>
                      <!-- END. service type -->
                    <?php } ?>

                    <div class="customer-coupon-content grid-60">
                        <div class="row">
                            <?php if(count($lists) > 0){ ?>
                            <!-- END. coupon item -->
                            <?php foreach($lists as $indexCoupon => $itemCoupon){ $couponDetailUrl = base_url('coupon/'.makeSlug($itemCoupon['coupon_subject']).'-'.$itemCoupon['id']).'.html'; ?>
                              <div class="col-md-6 col-xl-4">
                                  <div class="card customer-coupon-item">
                                      <a href="<?php echo $couponDetailUrl; ?>" class="customer-coupon-img">
                                          <img src="<?php echo COUPONS_PATH.$itemCoupon['coupon_image']; ?>" class="img-fluid" alt="coupon image">
                                      </a>
                                      <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                                          <div class="customer-coupon-body">
                                              <h6 class="card-title page-text-sm"><a href="<?php echo $couponDetailUrl; ?>"><?php echo $itemCoupon['coupon_subject']; ?></a></h6>
                                              <p class="card-text page-text-xs"><?php echo ddMMyyyy($itemCoupon['start_date']); ?> to <?php echo ddMMyyyy($itemCoupon['end_date']); ?></p>
                                              <div class="d-flex align-items-center justify-content-between">
                                                  <div class="wraper-progress">
                                                      <div class="progress">
                                                          <div class="progress-bar page-text-xs fw-500" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                              aria-valuemax="100" style="width: 75%;">0/<?php echo $itemCoupon['coupon_amount']; ?></div>
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
                            <?php }else{ ?>
                              <!-- empty coupon -->
                            <?php } ?>
                        </div>

                        <!-- Pagination -->
                        <input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
                          <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                              <div class="d-flex align-items-center pagination-left">
                                  <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500"><?php echo ($page - 1)*$perPage + 1; ?> – <?php echo ($page - 1)*$perPage + count($lists); ?></span> of <span class="fw-500"><?php echo number_format($rowCount); ?></span>
                                      results</p>
                                  <div class="page-text-sm mb-0 d-flex align-items-center">
                                      <span class="fw-500">10</span>
                                      <span class="ms-2">/</span>
                                      <div class="custom-select">
                                          <select class="selectPerPageLimit">
                                              <option value="0" selected>10</option>
                                              <option value="1">20</option>
                                              <option value="2">30</option>
                                              <option value="3">40</option>
                                              <option value="4">50</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="pagination-right">
                                  
                                  <nav>
                                      <?php echo $paggingHtml; ?>
                                  </nav>
                                  
                              </div>
                          </div>
                          <!-- END. Pagination -->

                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $this->load->view('frontend/includes/footer'); ?>