<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-user-manager">
    <!-- Customer Tab Header -->
    <?php $this->load->view('frontend/includes/customer_tab_header'); ?>

    <div class="um-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <!-- Customer Menu Sidebar -->
            <?php $this->load->view('frontend/includes/customer_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="um-right">
              <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                <input class="form-control w-100" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>">
              </form>
              <div class="um-coupon">
                <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">
                  <div class="d-flex align-items-center inner-filter">
                    <span class="me-2 page-text-lg fw-bold">Filter by</span>
                    <div class="notification-filter">
                      <div class="custom-select choose-business">
                        <select>
                          <option value="0" selected>All</option>
                          <?php if ($businessProfiles) {
                            foreach ($businessProfiles as $itemBusiness) { ?>
                              <option value="<?php echo $itemBusiness['id']; ?>" <?php if (isset($business) && $itemBusiness['id'] == $business) {
                                                                                    echo 'selected="selected"';
                                                                                  } ?>><?php echo $itemBusiness['business_name']; ?></option>
                          <?php }
                          } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center notification-sort">
                    <img src="assets/img/frontend/ic-sort.png" alt="sort icon" class="img-fluid me-2">
                    <div class="custom-select mb-0 choose-order">
                      <select>
                        <option value="desc">Newest</option>
                        <option value="asc" <?php if (isset($order_by) && $order_by == 'asc') {
                                              echo 'selected="selected"';
                                            } ?>>Oldest</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="list-tags">
                  <ul class="list-unstyled list-inline">
                    <?php if (!empty($serviceTypes)) {
                      for ($i = 0; $i < count($serviceTypes); $i++) { ?>
                        <li class="list-inline-item page-text-xs fw-500 selected"><a href="<?php echo $basePagingUrl; ?>"><?php echo $serviceTypes[$i]['service_type_name']; ?></a></li>
                    <?php }
                    } ?>
                  </ul>
                </div>
                <?php if (count($lists) > 0) { ?>
                  <!-- coupon list -->
                  <div class="um-coupon-list grid-60">
                    <div class="row">
                      <!-- coupon item -->
                      <?php foreach ($lists as $indexCoupon => $itemCoupon) {
                        $couponDetailUrl = base_url('coupon/' . makeSlug($itemCoupon['coupon_subject']) . '-' . $itemCoupon['id']) . '.html'; ?>
                        <div class="col-md-6">
                          <div class="card customer-coupon-item um-coupon-item position-relative">
                            <a href="<?php echo $couponDetailUrl; ?>" class="customer-coupon-img">
                              <img src="<?php echo COUPONS_PATH . $itemCoupon['coupon_image']; ?>" class="img-fluid" alt="<?php echo $itemCoupon['coupon_subject']; ?>">
                            </a>
                            <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                              <div class="customer-coupon-body">
                                <h6 class="card-title page-text-sm"><a href="<?php echo $couponDetailUrl; ?>"><?php echo $itemCoupon['coupon_subject']; ?></a></h6>
                                <p class="card-text page-text-xs"><?php echo ddMMyyyy($itemCoupon['start_date']); ?> to <?php echo ddMMyyyy($itemCoupon['end_date']); ?></p>
                                <div class="d-flex align-items-center justify-content-between">
                                  <div class="wraper-status <?php echo $itemCoupon['customer_coupon_status_id']; ?>">
                                    <?php if (isset($itemCoupon['customer_coupon_status_id']) && $itemCoupon['customer_coupon_status_id'] == STATUS_ACTIVED) { ?>
                                      <span class="badge badge-approved">Valid</span>
                                    <?php } else { ?>
                                      <span class="badge badge-declined">Invalid</span>
                                    <?php } ?>
                                  </div>
                                  <a href="<?php echo $couponDetailUrl; ?>" class="btn btn-outline-red btn-outline-red-md btn-viewcode">View code</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                      <!-- END. coupon item -->
                    </div>
                  </div>
                  <!-- END. coupon list -->
                <?php } ?>
              </div>
            </div>

            <?php if (count($lists) > 0) { ?>
              <!-- Pagination -->
              <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                <div class="d-flex align-items-center pagination-left">
                  <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500"><?php echo ($page - 1) * $perPage + 1; ?> – <?php echo ($page - 1) * $perPage + count($lists); ?></span> of <span class="fw-500"><?php echo number_format($rowCount); ?></span>
                    results</p>
                  <div class="page-text-sm mb-0 d-flex align-items-center">
                    <div class="custom-select choose-perpage">
                      <select>
                        <option value="10" <?php if (isset($per_page) && $per_page == 20) {
                                              echo 'selected';
                                            } ?>>10</option>
                        <option value="20" <?php if (isset($per_page) && $per_page == 20) {
                                              echo 'selected';
                                            } ?>>20</option>
                        <option value="30" <?php if (isset($per_page) && $per_page == 30) {
                                              echo 'selected';
                                            } ?>>30</option>
                        <option value="40" <?php if (isset($per_page) && $per_page == 40) {
                                              echo 'selected';
                                            } ?>>40</option>
                        <option value="50" <?php if (isset($per_page) && $per_page == 50) {
                                              echo 'selected';
                                            } ?>>50</option>
                      </select>
                    </div>
                    <span class="ms-2">/</span>
                    <span class="">Page</span>
                  </div>
                </div>
                <div class="pagination-right">
                  <!-- Page pagination -->
                  <nav>
                    <?php echo $paggingHtml; ?>
                  </nav>
                  <!-- End Page pagination -->
                </div>
              </div>
              <!-- END. Pagination -->
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>