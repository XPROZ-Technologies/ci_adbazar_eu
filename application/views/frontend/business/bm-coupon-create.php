<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-event-create bm-coupon-create">
      <div class="create-top">
        <div class="container">
          <div class="w-938 text-center">
            <h3 class="fw-bold page-title-md mb-4"><?php echo $this->lang->line('create_new_coupon'); ?></h3>
          </div>
        </div>
      </div>

      <div class="create-upload">
        <div class="container">
          <div class="w-550">
            <div class="upload-wrap">
              <div class="drop-zone">
                <div class="drop-zone__prompt">
                  <img src="assets/img/frontend/ic-cloud.png" alt="ic-cloud image" class="img-fluid">
                  <p class="mb-2 text-black fw-500"><?php echo $this->lang->line('drop_files_to_upload_or_browse'); ?>
                  </p>
                  <span class="d-block page-text-xs text-black"><?php echo $this->lang->line('supports_jpeg_png_gif_jpg'); ?></span>
                </div>
                <input type="file" name="myFile" class="drop-zone__input" refference="couponImageUpload" accept="image/png, image/jpeg, image/GIF">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="create-event">
        <div class="container">
          <div class="w-550">
            <form action="<?php echo base_url('business-management/create-coupon'); ?>" class="row" id="formCreateCoupon" method="POST">
              <input type="hidden" name="business_profile_id" value="<?php echo $businessInfo['id']; ?>" />
              <input type="hidden" id="couponImageUpload" name="coupon_image_upload" value="" />
              <div class="col-12">
                <div class="form-group mb-3">
                  <label for="couponSubject" class="form-label"><?php echo $this->lang->line('subject'); ?></label>
                  <input type="text" class="form-control form-control-lg" id="couponSubject" name="coupon_subject">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3 form-group-datepicker">
                  <label for="couponDatetimepicker1" class="form-label"><?php echo $this->lang->line('start_date'); ?></label>
                  <div class="datepicker-wraper position-relative">
                    <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                    <input type="text" class="js-datepicker form-control form-control-lg datetimepicker-input" id="couponDatetimepicker1" name="start_date" data-toggle="datetimepicker" value="October 13, 2021" />
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3 form-group-datepicker">
                  <label for="couponDatetimepicker2" class="form-label"><?php echo $this->lang->line('end_date'); ?></label>
                  <div class="datepicker-wraper position-relative">
                    <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                    <input type="text" class="js-datepicker form-control form-control-lg datetimepicker-input" id="couponDatetimepicker2" name="end_date" data-toggle="datetimepicker" value="October 13, 2021" />
                  </div>
                </div>
              </div>

              <div class="col-6 col-lg-4">
                <div class="form-group mb-3 form-group-quantity">
                  <label class="d-block form-label" for="quantityCoupon"><?php echo $this->lang->line('amount_of_coupon'); ?></label>
                  <div class="d-flex">
                    <button type="button" class="minus">
                      <img src="assets/img/frontend/ic-minus.png" alt="icon minus">
                    </button>
                    <input type="number" class="form-control form-control-lg quantity" id="quantityCoupon" value="100" min="1" max="200" name="coupon_amount">
                    <button type="button" class="plus">
                      <img src="assets/img/frontend/ic-plus.png" alt="icon plus">
                    </button>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group mb-3">
                  <label for="coupon-desc" class="form-label"><?php echo $this->lang->line('description'); ?></label>
                  <textarea class="form-control form-control-lg" id="coupon-desc" rows="6" name="coupon_description"></textarea>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group d-flex justify-content-center action-btn">
                  <a href="javascript:void(0)" class="btn btn-red btn-create"><?php echo $this->lang->line('create'); ?></a>
                  <a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/coupons'); ?>" id="btnCancel" class="btn btn-outline-red"><?php echo $this->lang->line('cancel'); ?></a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>
<script>
  $(".js-datepicker").datetimepicker({
    format: "MMMM DD, YYYY",
    minDate: moment(),
    // maxDate: moment(),
    allowInputToggle: true,
    // inline: true,
    // debug: true,
    // allowMultidate: true,
    // multidateSeparator: ',',
    icons: {
      time: "bi bi-clock",
      date: "bi bi-calendar2-check-fillr",
      up: "bi bi-chevron-up",
      down: "bi bi-chevron-down",
      previous: "bi bi-chevron-left",
      next: "bi bi-chevron-right",
    },
  });
  $("body").on('click', '.btn-create', function() {
    $('.btn-create').prop('disabled', true);
    var form = $('#formCreateCoupon');
    var data = form.serializeArray();
    $.ajax({
      type: "POST",
      url: form.attr('action'),
      data: data,
      dataType: 'json',
      success: function(response) {
        if (response.code == 1) {
          $(".notiPopup .text-secondary").html(response.message);
          $(".ico-noti-success").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);

          $('#formCreateCoupon').trigger("reset");
        } else {
          $('.btn-create').prop('disabled', false);
          console.log(response.message);
          $(".notiPopup .text-secondary").html(response.message);
          $(".ico-noti-success").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);
        }
      },
      error: function(response) {
        $('.btn-create').prop('disabled', false);

        $(".notiPopup .text-secondary").html('<?php echo ERROR_COMMON_MESSAGE; ?>');
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
      }
    });
    return false;
  })
</script>