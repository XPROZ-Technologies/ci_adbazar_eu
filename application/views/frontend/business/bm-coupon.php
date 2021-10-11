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
                      <input class="form-control me-2" type="text" placeholder="<?php echo $this->lang->line('enter_code_here'); ?>" id="couponCodeValue">
                      <button class="btn btn-outline-red btn-check-coupon" type="button"><?php echo $this->lang->line('check'); ?></button>
                    </form>
                    <a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/create-coupon') ?>" class="btn btn-red btn-create-coupon"><?php echo $this->lang->line('create_new_coupon'); ?></a>
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
                      <span class="me-2 page-text-lg fw-bold"><?php echo $this->lang->line('filter_by'); ?></span>
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
                              <span class="customer-coupon-img c-img">
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
                                      <div class="badge badge-primary"><?php echo $this->lang->line('upcoming'); ?></div>
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
<input type="hidden" id="businessId" value="<?php echo $businessInfo['id'] ?>" />
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Expire Avail Coupon Modal -->

<div class="modal fade bm-coupon-modal bm-found" id="bmCouponAlertModalAvail" tabindex="-1" aria-labelledby="bmCouponAlertModalAvailLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
            <?php $we_found_your_code_ah1234do_y = $this->lang->line('we_found_your_code_ah1234do_y'); 
                $we_found_your_code_ah1234do_y = explode('<AH1234>', $we_found_your_code_ah1234do_y);
            ?>
                <p class="page-text-lg mb-0">
                <?php echo $we_found_your_code_ah1234do_y[0]; ?>
                   <b>AH1234</b> 
                </p>
                <p class="page-text-lg mb-0">
                <?php echo $we_found_your_code_ah1234do_y[1]; ?>
                </p>

                <div class="modal-footer border-top-0 justify-content-center p-0">
                    <button type="button" class="btn btn-red btn-ok btn-active-coupon"
                        data-bs-dismiss="modal"><?php echo $this->lang->line('yes'); ?></button>
                    <button type="button" class="btn btn-outline-red btn-ok"
                        data-bs-dismiss="modal">No</button>
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Avail Coupon Modal -->

<!-- Found Used Coupon Modal -->

<div class="modal fade bm-coupon-modal" id="bmCouponAlertModalUsed" tabindex="-1" aria-labelledby="bmCouponAlertModalUsedLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
            <?php $your_code_ah1234_has_been_used_all = $this->lang->line('your_code_ah1234_has_been_used'); 
                $your_code_ah1234_has_been_used = explode(' <AH1234> ', $your_code_ah1234_has_been_used_all);

                $your_code_ah1234_has_been_used2 = explode('. ', $your_code_ah1234_has_been_used_all);
            ?>
                <p class="page-text-lg mb-0">
                <?php echo $your_code_ah1234_has_been_used[0]; ?><b>AH1234</b> <?php echo $your_code_ah1234_has_been_used[1]; ?>
                </p>
                <p class="page-text-lg mb-0">
                <?php echo $your_code_ah1234_has_been_used2[1]; ?>
                    
                </p>


        <div class="modal-footer border-top-0 justify-content-center p-0">
          <button type="button" class="btn btn-red" data-bs-dismiss="modal">OK</button>


        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Used Coupon Modal -->

<!-- Not found coupon Modal -->
<div class="modal fade bm-coupon-modal" id="bmCouponAlertModalNone" tabindex="-1" aria-labelledby="bmCouponAlertModalNoneLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <p class="page-text-lg mb-0">
          We not found your code: <b class="couponCodeEntered">AH1234</b>
        </p>
        <p class="page-text-lg mb-0">
          Please try another code.
        </p>

        <div class="modal-footer border-top-0 justify-content-center p-0">
          <button type="button" class="btn btn-red btn-ok" data-bs-dismiss="modal" data-bs-dismiss="modal">OK</button>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Not found coupon Modal -->
<script>
  $('.btn-check-coupon').click(function(e) {
    var coupon_code = $("#couponCodeValue").val();
    var business_id = $("#businessId").val();
    $(".couponCodeEntered").html(coupon_code);
    if (coupon_code.length == 0) {
      $(".notiPopup .text-secondary").html("Please enter coupon");
      $(".ico-noti-error").removeClass('ico-hidden');
      $(".notiPopup").fadeIn('slow').fadeOut(4000);

      return false;
    }

    $.ajax({
      type: 'POST',
      url: '<?php echo base_url('business-management/check-coupon-code'); ?>',
      data: {
        coupon_code: coupon_code,
        business_id: business_id
      },
      dataType: "json",
      success: function(data) {
        if (data.code == 1) {
          //avail
          $("#bmCouponAlertModalAvail").modal("show");
        } else if (data.code == 2) {
          //not found
          $("#bmCouponAlertModalNone").modal("show");
        } else if (data.code == 3) {
          // used
          $("#bmCouponAlertModalUsed").modal("show");
        }
      },
      error: function(data) {
        //$(".notiPopup .text-secondary").html("Delete video failed");
        //$(".ico-noti-error").removeClass('ico-hidden');
        //$(".notiPopup").fadeIn('slow').fadeOut(4000);
        //redirect(false, '<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/gallery'); ?>');
      }
    });
  });

    //active coupon
    $('.btn-active-coupon').click(function(e) {
      var coupon_code = $("#couponCodeValue").val();
      var business_id = $("#businessId").val();
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('business-management/active-coupon-code'); ?>',
        data: {
          coupon_code: coupon_code,
          business_id: business_id
        },
        dataType: "json",
        success: function(data) {
          if (data.code == 1) {
            //avail
            $("#bmCouponAlertModalAvail").modal("hide");

            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-success").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);

            //reload(true);
          } else if (data.code == 2) {
            //not found
            $("#bmCouponAlertModalNone").modal("show");
          } else if (data.code == 3) {
            // used
            $("#bmCouponAlertModalUsed").modal("show");
          }


          //redirect(false, '<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/gallery'); ?>');
        },
        error: function(data) {
          //$(".notiPopup .text-secondary").html("Delete video failed");
          //$(".ico-noti-error").removeClass('ico-hidden');
          //$(".notiPopup").fadeIn('slow').fadeOut(4000);
          //redirect(false, '<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/gallery'); ?>');
        }
      });
    });
</script>