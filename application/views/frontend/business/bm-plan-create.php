<?php $this->load->view('frontend/includes/header'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/css/BsMultiSelect.min.css" />
<main>
  <div class="page-business-manager">
    <div class="bm-create">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="bm-create-content">
              <h3 class="fw-bold page-title-md text-center">Create a business</h3>
              <div class="bm-create-cover">
                <!-- cover -->
                <div class="cover-top">
                  <div class="cover-wrap">
                    <div class="cover-avatar">
                      <img class="cover-picture img-fluid" id="cover-photo" src="assets/img/frontend/bm-cover-sample.png" />
                      <div class="cover-upload-btn" id="cover-upload-btn"></div>
                      <input class="cover-file-upload" id="cover-profile-upload" type="file" accept="image/*" name="business_image_cover" />
                    </div>
                    <div class="cover-icon" id="cover-icon">
                      <img src="assets/img/frontend/icon-camera.png" alt="icon-camera">
                      <span id="cover-text" class="text-decoration-underline">Upload cover photo</span>
                    </div>
                  </div>
                </div>
                <!-- END. cover -->
                <!-- avatar -->
                <div class="bm-create-profile">
                  <div class="general-top">
                    <div class="general-avatar">
                      <img class="general-picture js-profile-pic" src="assets/img/frontend/bm-profile-sample.png" />
                      <div class="general-upload-btn js-profile-upload-btn"></div>
                      <input class="general-file-upload js-profile-upload" type="file" accept="image/*" name="business_avatar" />
                    </div>
                    <div class="general-icon js-profile-icon">
                      <img src="assets/img/frontend/icon-camera.png" alt="icon-camera">
                      <span class="text-decoration-underline">Upload profile photo</span>
                    </div>
                  </div>
                </div>
                <!-- END. avatar -->
                <form action="<?php echo base_url('business-profile/create-business'); ?>" class="row create-form" method="POST" id="formCreateBusiness" enctype="multipart/form-data">
                  <input type="hidden" id="businessAvatarUpload" name="business_avatar_upload" value="" />
                  <input type="hidden" id="businessCoverUpload" name="business_cover_upload" value="" />
                  <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>" />
                  <div class="col-12">
                    <div class="form-group mb-3">
                      <label for="bm-name" class="form-label">Business Name<span class="text-danger required">*</span></label>
                      <input type="text" class="form-control form-control-lg" aria-label="Business name" name="business_name" id="business_name" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-3">
                      <label for="bm-slogan" class="form-label">Slogan</label>
                      <div class="slogan-wrap">
                        <input maxlength="100" type="text" class="form-control form-control-lg" id="bm-slogan" aria-label="Business Slogan" name="business_slogan">
                        <span class="text-secondary page-text-sm slogan-counter">0/100</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-3">
                      <label for="bm-email" class="form-label">Business Email<span class="text-danger required">*</span></label>
                      <input type="email" class="form-control form-control-lg" id="bm-email" aria-label="Business email" name="business_email" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-3">
                      <label for="bm-address" class="form-label">Business Address<span class="text-danger required">*</span></label>
                      <input type="text" class="form-control form-control-lg" id="bm-address" aria-label="Business address" name="business_address" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-3">
                      <label for="bm-url" class="form-label">Custom URL</label>
                      <div class="position-relative text-url">
                        <span>adbazar.eu/</span>
                        <input type="url" class="form-control form-control-lg" placeholder="" aria-label="Custom URL" name="business_url" id="business_url">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group mb-3">
                      <label class="form-label">Contry code<span class="text-danger required">*</span></label>
                      <div class="dropdown dropdown-country page-text-lg">
                        <input type="hidden" class="form-control" id="businessPhoneCode" name="country_code_id" value="0">
                        <a href="#" class="wrapper-btn dropdown-toggle current js-country" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                          <img src="assets/img/frontend/ger.png" alt="english flag" class="img-fluid me-2">
                          <span class="country-text">Germany</span>
                          <span class="country-code">+49</span>
                        </a>
                        <ul class="dropdown-menu js-list-country" aria-labelledby="countryDropdown">
                          <?php if (!empty($phoneCodes)) { ?>
                            <?php foreach ($phoneCodes as $itemPhoneCode) { ?>
                              <li class="" data-id="<?php echo $itemPhoneCode['id']; ?>"><a class="dropdown-item" href="javascript:void(0)" data-id="<?php echo $itemPhoneCode['id']; ?>"><img src="assets/img/iso_flags/<?php echo $itemPhoneCode['image']; ?>" alt="<?php echo $itemPhoneCode['country_name']; ?>" class="img-fluid me-2" data-id="<?php echo $itemPhoneCode['id']; ?>">
                                  <span class="country-text"><?php echo $itemPhoneCode['country_name']; ?></span>
                                  <span class="country-code">+<?php echo $itemPhoneCode['phonecode']; ?></span>
                                </a>
                              </li>
                            <?php } ?>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group mb-3">
                      <label for="bm-phone" class="form-label">Phone number<span class="text-danger required">*</span></label>
                      <input type="tel" class="form-control form-control-lg" id="bm-phone" aria-label="Phone number" name="business_phone">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group mb-3">
                      <label for="bm-whatapp" class="form-label">WhatsApp number<span class="text-danger required">*</span></label>
                      <input type="tel" class="form-control form-control-lg" id="bm-whatapp" aria-label="WhatsApp number" name="business_whatsapp" value="">
                    </div>
                  </div>

                  <!-- Opening hours -->
                  <div class="col-12">
                    <div class="form-group mb-3">
                      <label class="form-label">Opening hour<span class="text-danger required">*</span></label>
                      <div class="open-hour">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Monday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn disabled">
                              <input id="checkbox4" type="checkbox" class="checkbox" name="open_hours[0][opening_hours_status_id]" />
                              <label for="checkbox4" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Closed</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[0][start_time]" id="timePicker1" data-toggle="datetimepicker" data-target="#timePicker1" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[0][start_time]" id="timePicker2" data-toggle="datetimepicker" data-target="#timePicker2" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item ">
                          <div class="page-text-lg text-date">
                            Tuesday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn disabled">
                              <input id="checkboxTuesday" type="checkbox" class="checkbox" name="open_hours[1][opening_hours_status_id]" />
                              <label for="checkboxTuesday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Closed</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[1][start_time]" id="timePicker3" data-toggle="datetimepicker" data-target="#timePicker3" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[1][end_time]" id="timePicker4" data-toggle="datetimepicker" data-target="#timePicker4" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Wednesday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn disabled">
                              <input id="checkboxWed" type="checkbox" class="checkbox" name="open_hours[2][opening_hours_status_id]" />
                              <label for="checkboxWed" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Closed</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[2][start_time]" id="timePicker5" data-toggle="datetimepicker" data-target="#timePicker5" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[2][end_time]" id="timePicker6" data-toggle="datetimepicker" data-target="#timePicker6" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Thursday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn disabled">
                              <input id="checkboxThursday" type="checkbox" class="checkbox" name="open_hours[3][opening_hours_status_id]" />
                              <label for="checkboxThursday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Closed</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[3][start_time]" id="timePicker7" data-toggle="datetimepicker" data-target="#timePicker7" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[3][end_time]" id="timePicker8" data-toggle="datetimepicker" data-target="#timePicker8" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Friday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn disabled">
                              <input id="checkboxFriday" type="checkbox" class="checkbox" name="open_hours[4][opening_hours_status_id]" />
                              <label for="checkboxFriday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Closed</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[4][start_time]" id="timePicker9" data-toggle="datetimepicker" data-target="#timePicker9" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[4][end_time]" id="timePicker10" data-toggle="datetimepicker" data-target="#timePicker10" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Saturday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn disabled">
                              <input id="checkboxSaturday" type="checkbox" class="checkbox" name="open_hours[5][opening_hours_status_id]" />
                              <label for="checkboxSaturday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Closed</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[5][start_time]" id="timePicker11" data-toggle="datetimepicker" data-target="#timePicker11" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[5][end_time]" id="timePicker12" data-toggle="datetimepicker" data-target="#timePicker12" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Sunday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn disabled">
                              <input id="checkboxSunday" type="checkbox" class="checkbox" name="open_hours[6][opening_hours_status_id]" />
                              <label for="checkboxSunday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Closed</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[6][start_time]" id="timePicker13" data-toggle="datetimepicker" data-target="#timePicker13" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker"  disabled name="open_hours[6][end_time]" id="timePicker14" data-toggle="datetimepicker" data-target="#timePicker14" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>

                    </div>
                  </div>
                  <!--END. opening hours -->
                  <div class="col-12">
                    <div class="form-group mb-3">
                      <label for="bm-desc" class="form-label">Description</label>
                      <textarea class="form-control form-control-lg" id="bm-desc" rows="4" name="business_description"></textarea>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group mb-3">
                      <label class="form-label">Type of service <span class="required text-danger">*</span></label>
                      <div class="custom-select js-select-service">
                        <select name="service_id" required id="serviceId">
                          <?php foreach ($listServices as $itemService) { ?>
                            <option value="<?php echo $itemService['id']; ?>"><?php echo $itemService['service_name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>


                  <div class="col-12 serviceTypeBlock">
                    <label class="form-label" for="sub-category">Sub-categories<span class="required text-danger">*</span></label>
                    <select name="service_type_ids" id="serviceTypeId" class="form-control form-control-lg js-tags-select" multiple="multiple">
                      
                    </select>

                  </div>


                  <div class="col-12">
                    <div class="form-group d-flex justify-content-center action-btn">
                      <a href="javascript:void(0)" class="btn btn-red btn-create-business">Create</a>
                      <a href="<?php echo base_url('business/my-business-profile'); ?>" class="btn btn-outline-red">Cancel</a>
                    </div>
                  </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>
<script>
  $(".serviceTypeBlock").hide();

  $("body").on("click", ".js-list-country li a", function() {
    //alert($(this).data('id'));
    $("#businessPhoneCode").val($(this).data('id'));
  });


  $("body").on("click", ".btn-create-business", function() {
    $("#formCreateBusiness").submit();
  });

  $('#formCreateBusiness').on('focusout', 'input#business_name', function() {
    $('input#business_url').val(makeSlug($(this).val()));
  });

  $('#formCreateBusiness').on('keydown', 'input#business_url', function(e) {
    if (makeSlug(e)) e.preventDefault();
  }).on('keyup', 'input#business_url', function() {
    makeSlug($(this).val())
  });

  // Upload profile picture
  let readURL = function(input, element, dist) {
    if (input.files && input.files[0]) {
      let reader = new FileReader();

      reader.onload = function(e) {
        element.attr("src", e.target.result);
        if (dist.length > 0) {
          dist.val(e.target.result);
        }
      };

      reader.readAsDataURL(input.files[0]);
    }
  };

  // business image upload
  // avatar
  $(".js-profile-upload").on("change", function() {
    readURL(this, $(".js-profile-pic"), $('#businessAvatarUpload'));
  });

  $(".js-profile-upload-btn, .js-profile-icon, .js-camera-profile-icon").on("click", function() {
    $(".js-profile-upload").click();
  });

  // Business manager upload
  $("#cover-upload-btn, #cover-icon").on("click", function() {
    $("#cover-profile-upload").click();
  });

  $("#cover-profile-upload").on("change", function() {
    readURL(this, $("#cover-photo"), $('#businessCoverUpload'));
    $("#cover-text").text("Change cover photo");
  });


  $("#serviceTypeId").bsMultiSelect({
    useCssPatch: false,
    css: {
      choice_hover: '',
      picks_focus: '',
    }
  });


  // Select service
  $("body").on("click", ".js-select-service li", function() {
    var service_id = $(this).data('value');
    $.ajax({
      type: "POST",
      url: '<?php echo base_url('service/get-list-service-type'); ?>',
      data: {
        service_id: service_id
      },
      dataType: 'text',
      success: function(response) {
        $("#serviceTypeId").html(response);
        $("#serviceTypeId").bsMultiSelect("UpdateData");
        $(".serviceTypeBlock").show();
      },
      error: function(response) {}
    });

    

  });
</script>