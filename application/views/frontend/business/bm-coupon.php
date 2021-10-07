<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-content">
      <div class="container">
        <?php $this->load->view('frontend/includes/bm_header'); ?>

        <div class="row">
          <div class="col-lg-3">
            <?php $this->load->view('frontend/includes/business_manage_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="um-right">
              <div class="um-coupon bm-coupon p-0">
                <div class="coupon-top">
                  <div class="d-flex flex-column flex-xl-row justify-content-xl-between">
                    <form class="d-flex mb-3 mb-xl-0">
                      <input class="form-control me-2" type="text" placeholder="Enter code here">
                      <button class="btn btn-outline-red" type="submit">Check</button>
                    </form>
                    <a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/create-coupon') ?>" class="btn btn-red btn-create-coupon">Create new coupon</a>
                  </div>
                </div>
                <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                  <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                  <input class="form-control w-100" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>">
                </form>
                <?php if (count($lists) > 0) { ?>
                  <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">

                    <div class="d-flex align-items-center inner-filter">
                      <!--
                      <span class="me-2 page-text-lg fw-bold">Filter by</span>
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
                      -->
                    </div>

                    <div class="d-flex align-items-center notification-sort">
                      <img src="assets/img/frontend/ic-sort.png" alt="sort icon" class="img-fluid me-2">
                      <div class="custom-select mb-0 choose-order">
                        <select>
                          <option value="desc" selected>Newest</option>
                          <option value="asc" <?php if (isset($order_by) && $order_by == 'asc') {
                                                echo 'selected="selected"';
                                              } ?>>Oldest</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="um-coupon-list grid-60">
                    <div class="row">
                      <?php foreach ($lists as $indexCoupon => $itemCoupon) {
                        $couponDetailUrl = base_url('coupon/' . makeSlug($itemCoupon['coupon_subject']) . '-' . $itemCoupon['id']) . '.html'; ?>
                        <div class="col-md-6">
                          <div class="position-relative">
                            <a href="<?php echo $couponDetailUrl; ?>" class="card customer-coupon-item um-coupon-item bm-coupon-item position-relative">
                              <span class="customer-coupon-img">
                                <?php
                                  $couponImg = COUPONS_PATH . NO_IMAGE;
                                  if (!empty($itemCoupon['coupon_image'])) {
                                    $couponImg = COUPONS_PATH . $itemCoupon['coupon_image'];
                                  }
                                ?>
                                <img src="<?php echo $couponImg; ?>" class="img-fluid" alt="<?php echo $itemCoupon['coupon_subject']; ?>">
                              </span>
                              <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                                <div class="customer-coupon-body">
                                  <h6 class="card-title page-text-sm"><span><?php echo $itemCoupon['coupon_subject']; ?></span></h6>
                                  <p class="card-text page-text-xs"><?php echo ddMMyyyy($itemCoupon['start_date'], 'M d, Y'); ?> to <?php echo ddMMyyyy($itemCoupon['end_date'], 'M d, Y'); ?></p>
                                  <div class="d-flex align-items-center justify-content-between">
                                    <div class="wraper-status">
                                      <div class="badge badge-primary">Upcoming</div>
                                      <!-- <div class="badge badge-primary">Upcoming</div> -->
                                      <!-- <div class="badge badge-cancel">End</div> -->
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </a>
                            <a href="<?php echo $couponDetailUrl; ?>" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="zero-event zero-box">
                    <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                    <p class="text-secondary page-text-lg">No coupons</p>
                  </div>
                <?php } ?>
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
                        <span class=""> Page</span>
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
    </div>
  </div>
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>