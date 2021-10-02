<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-create">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="bm-create-content">
              <h3 class="fw-bold page-title-md text-center">Create a business</h3>
              <div class="bm-create-cover">
                <form action="<?php echo base_url('business-profile/create-business'); ?>" class="row create-form" method="POST" id="formCreateBusiness" enctype="multipart/form-data">
                  <div class="cover-top">
                    <div class="cover-wrap">
                      <div class="cover-avatar">
                        <img class="cover-picture img-fluid" id="cover-photo" src="assets/img/frontend/bm-cover-sample.png" />
                        <div class="cover-upload-btn" id="cover-upload-btn"></div>
                        <input class="cover-file-upload" id="cover-profile-upload" type="file" accept="image/*" name="business_image_cover" />
                      </div>
                      <div class="cover-icon" id="cover-icon">
                        <img src="assets/img/frontend/icon-camera.png" alt="icon-camera">
                        <span id="cover-text">Upload cover photo</span>
                      </div>
                    </div>
                  </div>
                  <div class="bm-create-profile">
                    <div class="general-top">
                      <div class="general-avatar">
                        <img class="general-picture js-profile-pic" src="assets/img/frontend/bm-profile-sample.png" />
                        <div class="general-upload-btn js-profile-upload-btn"></div>
                        <input class="general-file-upload js-profile-upload" type="file" accept="image/*" name="business_avatar" />
                      </div>
                      <div class="general-icon js-profile-icon">
                        <img src="assets/img/frontend/icon-camera.png" alt="icon-camera">
                        <span>Upload profile photo</span>
                      </div>
                    </div>
                  </div>

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
                        <input type="text" class="form-control form-control-lg" id="bm-slogan" aria-label="Business Slogan" name="business_slogan">
                        <!--<span class="text-secondary page-text-sm slogan-counter">0/100</span>-->
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
                      <input type="url" class="form-control form-control-lg" placeholder="adbazar.eu/" aria-label="Custom URL" name="business_url" id="business_url">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group mb-3">
                      <label class="form-label">Contry code<span class="text-danger required">*</span></label>
                      <div class="dropdown dropdown-country page-text-lg">
                        <input type="hidden" class="form-control" id="businessPhoneCode" name="business_phone_code" value="">
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
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item  disabled-item">
                          <div class="page-text-lg text-date">
                            Monday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn disabled">
                              <input id="checkbox4" type="checkbox" class="checkbox" disabled />
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
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker1" data-toggle="datetimepicker" data-target="#timePicker1" placeholder="Open at" disabled />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker2" data-toggle="datetimepicker" data-target="#timePicker2" placeholder="Open at" disabled />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Tuesday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn">
                              <input id="checkboxTuesday" type="checkbox" class="checkbox" checked />
                              <label for="checkboxTuesday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Open</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker3" data-toggle="datetimepicker" data-target="#timePicker3" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker4" data-toggle="datetimepicker" data-target="#timePicker4" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Wednesday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn">
                              <input id="checkboxWed" type="checkbox" class="checkbox" checked />
                              <label for="checkboxWed" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Open</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker5" data-toggle="datetimepicker" data-target="#timePicker5" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker6" data-toggle="datetimepicker" data-target="#timePicker6" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Thursday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn">
                              <input id="checkboxThursday" type="checkbox" class="checkbox" checked />
                              <label for="checkboxThursday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Open</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker7" data-toggle="datetimepicker" data-target="#timePicker7" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker8" data-toggle="datetimepicker" data-target="#timePicker8" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Friday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn">
                              <input id="checkboxFriday" type="checkbox" class="checkbox" checked />
                              <label for="checkboxFriday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Open</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker9" data-toggle="datetimepicker" data-target="#timePicker9" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker10" data-toggle="datetimepicker" data-target="#timePicker10" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Saturday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn">
                              <input id="checkboxSaturday" type="checkbox" class="checkbox" checked />
                              <label for="checkboxSaturday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Open</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker11" data-toggle="datetimepicker" data-target="#timePicker11" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker12" data-toggle="datetimepicker" data-target="#timePicker12" placeholder="Open at" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between open-hour-item">
                          <div class="page-text-lg text-date">
                            Sunday
                          </div>
                          <div class="d-flex flex-column flex-md-row align-items-md-center body-content">
                            <div class="d-flex align-items-center switch-btn">
                              <input id="checkboxSunday" type="checkbox" class="checkbox" checked />
                              <label for="checkboxSunday" class="switch">
                                <span class="switch-circle">
                                  <span class="switch-circle-inner"></span>
                                </span>
                                <span class="switch-left">Off</span>
                                <span class="switch-right">On</span>
                              </label>
                              <p class="mb-0 switch-text">Open</p>
                            </div>
                            <div class="d-flex align-items-center wrapper-time">
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker13" data-toggle="datetimepicker" data-target="#timePicker13" placeholder="Open at" />
                              </div>
                              <span class="text-to">to</span>
                              <div class="position-relative time-content">
                                <input type="text" class="form-control form-control-lg datetimepicker-input js-time-picker" id="timePicker14" data-toggle="datetimepicker" data-target="#timePicker14" placeholder="Open at" />
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
                      <div class="custom-select">
                        <select name="service_id" required>
                          <?php foreach ($listServices as $itemService) { ?>
                            <option value="<?php echo $itemService['id']; ?>"><?php echo $itemService['service_name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <!-- 
                  <div class="col-12">
                    <label class="form-label" for="sub-category">Sub-categories<span class="required text-danger">*</span></label>
                    <select name="sub-category" class="form-control form-control-lg js-tags-select" multiple="multiple">

                      <option value="Nails">Nails</option>

                      <option value="Hairs">Hairs</option>

                      <option value="Massage">Massage</option>

                      <option value="Permanent Makeup">Permanent Makeup</option>

                      <option selected value=Others>Others</option>

                    </select>

                  </div>
                  -->

                  <div class="col-12">
                    <div class="form-group d-flex justify-content-center action-btn">
                      <a href="javascript:void(0)"class="btn btn-red btn-create-business" >Create</a>
                      <a href="<?php echo base_url('business-profile/my-business-profile'); ?>" class="btn btn-outline-red">Cancel</a>
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
</script>