<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-profile">
    <?php $this->load->view('frontend/includes/business_top_header'); ?>

    <div class="bp-tabs">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <?php $this->load->view('frontend/includes/business_nav_sidebar'); ?>
          </div>
          <div class="col-lg-8">
            <div class="bp-tabs-right">
              <div class="bp-coupon grid-60">
                <div class="d-flex justify-content-end">
                  <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                    <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();" ><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>" >
                  </form>
                </div>
                <?php if (count($lists) > 0) { ?>
                  <div class="bp-coupon-list">
                    <div class="row">
                      <?php foreach ($lists as $indexCoupon => $itemCoupon) {
                        $couponDetailUrl = base_url('coupon/' . makeSlug($itemCoupon['coupon_subject']) . '-' . $itemCoupon['id']) . '.html'; ?>
                        <div class="col-md-6  coupon-item-<?php echo $itemCoupon['id']; ?>">

                          <div class="position-relative">
                            <a class="card customer-coupon-item" href="<?php echo $couponDetailUrl; ?>">
                              <p class="customer-coupon-img mb-0">
                                <img src="<?php echo COUPONS_PATH . $itemCoupon['coupon_image']; ?>" class="img-fluid" alt="<?php echo $itemCoupon['coupon_subject']; ?>">
                              </p>
                              <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                                <div class="customer-coupon-body">
                                  <h6 class="card-title"><span><?php echo $itemCoupon['coupon_subject']; ?></span></h6>
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
                            <a href="javascript:void(0)" class="btn btn-outline-red btn-outline-red-md btn-getnow get-coupon-in-list" data-customer="<?php echo $customer['id']; ?>" data-id="<?php echo $itemCoupon['id']; ?>">Get now</a>
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