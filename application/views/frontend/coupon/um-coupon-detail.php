<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-bp-coupon-detail page-um-coupon-detail">
    <div class="bp-coupon-back mb-3 mb-md-4">
      <div class="container">
        <a href="<?php echo $backUrl; ?>" class="text-dark text-decoration-underline">
          <img src="assets/img/frontend/icon-goback.png" alt="icon-goback" class="img-fluid me-1">
          <?php echo $this->lang->line('go_back'); ?>
        </a>
      </div>
    </div>

    <div class="bp-coupon-detail um-coupon-detail">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="detail-left">
              <img src="<?php echo $detailInfo['coupon_image']; ?>" alt="<?php echo $detailInfo['coupon_subject']; ?>" class="img-fluid">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="detail-right">
              <div class="card rounded-0 border-0 detail-right-item">
                <div class="card-body">
                  <h5 class="card-title page-text-lg fw-bold">
                    <?php echo $detailInfo['coupon_subject']; ?>
                  </h5>
                  <div class="row g-0 align-items-lg-center">
                    <p class="col-lg-7 card-text mb-0 page-text-xs"><?php echo ddMMyyyy($detailInfo['start_date'], 'M d, Y'); ?> - <?php echo ddMMyyyy($detailInfo['end_date'], 'M d, Y'); ?></p>
                    <div class="col-lg-5">
                      <div class="d-flex align-items-center ">
                        <?php if (!empty($customerCoupon)) { ?>
                          <!-- Saved -->
                          <span class="page-text-sm me-1"><?php echo $this->lang->line('Status'); ?>:</span>
                          <?php if ($customerCoupon['customer_coupon_status_id'] == STATUS_ACTIVED) { ?>
                            <span class="badge badge-approved">Valid</span>
                          <?php } else { ?>
                            <span class="badge badge-declined">Invalid</span>
                          <?php } ?>
                        <?php } else { ?>
                          <!-- Not saved -->
                          <div class="wraper-progress">
                            <div class="progress">
                              <div class="progress-bar page-text-xs fw-500" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="progress-text"><span class="progress-first"><?php echo $detailInfo['coupon_amount_used']; ?></span>/<span class="progress-last"><?php echo $detailInfo['coupon_amount']; ?></span></span></div>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <?php if (!empty($customerCoupon)) { ?>
                    <!-- Logged In - Coupon Saved -->
                    <div class="coupon-code"><?php echo $customerCoupon['customer_coupon_code']; ?></div>
                    <p class="text-danger text-desc"><?php echo $this->lang->line('please_show_your_coupon_to_the'); ?></p>
                  <?php } else { ?>
                    <!-- Not Saved -->
                    <button type="button" class="btn btn-red w-100 btn-getnow btn-get-coupon mb-80"><?php echo $this->lang->line('get_now'); ?></button>
                    <button type="button" disabled="" class="btn btn-outline-red btn-outline-red-disabled w-100 btn-getnow btn-saved btn-hidden">Saved</button>
                  <?php } ?>
                  <div class="d-flex align-items-center detail-horizontal">
                    <div class="horizontal-img">
                      <img src="<?php echo BUSINESS_PROFILE_PATH . $businessInfo['business_avatar']; ?>" alt="image coupon detail" class="img-fluid">
                    </div>
                    <div class="horizontal-body">
                      <h6 class="card-title page-text-lg mb-0"><?php echo $businessInfo['business_name']; ?></h6>
                      <p class="my-3 card-text page-text-sm"><?php echo $businessInfo['business_phone']; ?></p>
                      <p class="mb-0 card-text page-text-sm"><?php echo $businessInfo['business_address']; ?></p>
                    </div>
                  </div>
                  <?php if (!empty($customerCoupon) && $customerCoupon['customer_coupon_status_id'] == STATUS_ACTIVED) { ?>
                    <!-- Logged In - Coupon Saved -->
                    <div class="btn-remove d-flex justify-content-end">
                      <a href="#removeCouponModal" data-bs-toggle="modal" class="fw-bold"><?php echo $this->lang->line('remove'); ?></a>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-3 mt-lg-0">
          <div class="col-12">
            <div class="description">
              <h5 class="mb-3 mb-md-4 page-text-lg fw-bold"><?php echo $this->lang->line('conditions_and_descriptions'); ?></h5>
              <p><?php echo nl2br($detailInfo['coupon_description']); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal confirm remove -->
  <div class="modal fade v1" id="removeCouponModal" tabindex="-1" aria-labelledby="removeCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-medium">
      <div class="modal-content">
        <div class="modal-body">
          <p class="text-center page-text-lg"><?php echo $this->lang->line('are_you_sure_want_to_remove_th'); ?>
            <b><?php echo $detailInfo['coupon_subject']; ?></b>?
          </p>
          <div class="d-flex justify-content-center">
            <a href="javascript:void(0)" class="btn btn-red btn-yes btn-remove-coupon" data-bs-dismiss="modal"><?php echo $this->lang->line('yes'); ?></a>
            <a href="javascript:void(0)" class="btn btn-outline-red btn-cancel" data-bs-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal confirm remove -->
</main>
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Modal removed coupon -->
<div class="modal fade" id="removedCouponModal" tabindex="-1" aria-labelledby="removedCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h4 class="text-center fw-bold page-title-sm"><?php echo $this->lang->line('cancel'); ?>Successfully removed!</h4>
        <div class="d-flex justify-content-center">
          <a href="javascript:void(0)" class="btn btn-outline-red btn-cancel btn-close-removed" ><?php echo $this->lang->line('closed'); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal removed coupon -->

<script>
  $('.btn-get-coupon').click(function() {
    var button = $(this);
    var url = $("#baseUrl").data('href');
    var customer_id = <?php echo $customer['id']; ?>;
    var redirectUrl = $("#redirectUrl").val();

    if(customer_id == 0) {
        redirect(false, url + 'login.html?requiredLogin=1&redirectUrl=' + redirectUrl);
    }


    $.ajax({
      type: "POST",
      url: '<?php echo base_url('customer-get-coupon'); ?>',
      data: {
        coupon_id: <?php echo $detailInfo['id']; ?>,
        customer_id: customer_id
      },
      dataType: "json",
      success: function(response) {
        if (response.code == 1) {
          button.addClass('btn-hidden');
          $('.btn-saved').removeClass('btn-hidden');
          $("#savedCouponModal").modal("show");
        }

      },
      error: function(response) {
        // showNotification($('input#errorCommonMessage').val(), 0);
        // $('.submit').prop('disabled', false);
      }
    });
  });

  $('.btn-remove-coupon').click(function() {
    $.ajax({
      type: "POST",
      url: '<?php echo base_url('customer-remove-coupon'); ?>',
      data: {
        coupon_id: <?php echo $detailInfo['id']; ?>,
        customer_id: <?php echo $customer['id']; ?>
      },
      dataType: "json",
      success: function(response) {
        if (response.code == 1) {
          $("#removedCouponModal").modal("show");
        }

      },
      error: function(response) {
        // showNotification($('input#errorCommonMessage').val(), 0);
        // $('.submit').prop('disabled', false);
      }
    });
  });

  $('.btn-close-removed').click(function() {
    $("#removedCouponModal").modal("hide");
    redirect(true);
  });
</script>