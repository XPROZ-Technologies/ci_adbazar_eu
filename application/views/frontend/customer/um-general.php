<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-user-manager page-um-general">
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
              <div class="um-general">
                <div class="general-top">
                  <div class="general-avatar">
                    <img class="general-picture js-profile-pic" src="assets/img/frontend/um-profile-picture.png" />
                    <div class="general-upload-btn js-profile-upload-btn"></div>
                    <input class="general-file-upload js-profile-upload" type="file" accept="image/*" />
                  </div>
                  <div class="general-icon">
                    <img src="assets/img/frontend/icon-camera.png" alt="icon-camera">
                    <span>Change profile picture</span>
                  </div>
                </div>

                <div class="general-form">
                  <form class="row">
                    <div class="col-md-6">
                      <div class="form-group mb-3">
                        <label for="profileFirstName" class="form-label">First Name<span class="required">*</span></label>
                        <input type="text" class="form-control" id="profileFirstName">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group mb-3">
                        <label for="profileLastName" class="form-label">Last Name<span class="required">*</span></label>
                        <input type="text" class="form-control" id="profileLasttName">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group mb-3">
                        <label for="profileEmail" class="form-label">Email<span class="required">*</span></label>
                        <input type="email" class="form-control" id="profileEmail" placeholder="acbcd122334@gmail.com">
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group mb-3">
                        <div class="form-group mb-3 form-group-datepicker">
                          <label for="datetimepicker1" class="form-label">Date of birth</label>
                          <div class="datepicker-wraper position-relative">
                            <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                            <input type="text" class="js-datepicker form-control form-control-lg datetimepicker-input" id="datetimepicker1" data-toggle="datetimepicker" data-target="#datetimepicker1" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group mb-3">
                        <label for="profileGender" class="form-label">Gender</label>
                        <div class="custom-select">
                          <select id="profileGender">
                            <option value="0" selected>Male</option>
                            <option value="1">Female</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group mb-3">
                        <label class="form-label">Contry code</label>
                        <div class="dropdown dropdown-country page-text-lg">
                          <a href="#" class="wrapper-btn dropdown-toggle current js-lang" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                            <img src="assets/img/frontend/ger.png" alt="english flag" class="img-fluid me-2">
                            <span class="country-text">Germany</span>
                          </a>
                          <ul class="dropdown-menu js-list-lang" aria-labelledby="languageDropdown">
                            <li class="selected"><a class="dropdown-item" href="#"><img src="assets/img/frontend/ger.png" alt="germany flag" class="img-fluid me-2">
                                <span class="country-text">Germany</span>
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#">
                                <img src="assets/img/frontend/en.png" alt="english flag" class="img-fluid me-2">
                                <span class="country-text">English</span>
                              </a>
                            </li>
                            <li><a class="dropdown-item" href="#"><img src="assets/img/frontend/vn.png" alt="vietnam flag" class="img-fluid me-2">
                                <span class="country-text">Vietnam</span>
                              </a></li>

                            <li><a class="dropdown-item" href="#">
                                <img src="assets/img/frontend/cre.png" alt="czech flag" class="img-fluid me-2">
                                <span class="country-text">Czech</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-5">
                      <div class="form-group mb-3">
                        <label class="form-label">Contry code</label>
                        <div class="dropdown dropdown-country page-text-lg">
                          <a href="#" class="wrapper-btn dropdown-toggle current js-country" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                            <img src="assets/img/frontend/ger.png" alt="english flag" class="img-fluid me-2">
                            <span class="country-text">Germany</span>
                            <span class="country-code">+49</span>
                          </a>
                          <ul class="dropdown-menu js-list-country" aria-labelledby="countryDropdown">
                            <li class="selected"><a class="dropdown-item" href="#"><img src="assets/img/frontend/ger.png" alt="germany flag" class="img-fluid me-2">
                                <span class="country-text">Germany</span>
                                <span class="country-code">+49</span>
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="#">
                                <img src="assets/img/frontend/en.png" alt="english flag" class="img-fluid me-2">
                                <span class="country-text">English</span>
                                <span class="country-code">+11</span>
                              </a>
                            </li>
                            <li><a class="dropdown-item" href="#"><img src="assets/img/frontend/vn.png" alt="vietnam flag" class="img-fluid me-2">
                                <span class="country-text">Vietnam</span>
                                <span class="country-code">+84</span>
                              </a></li>

                            <li><a class="dropdown-item" href="#">
                                <img src="assets/img/frontend/cre.png" alt="czech flag" class="img-fluid me-2">
                                <span class="country-text">Czech</span>
                                <span class="country-code">+69</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-7">
                      <div class="form-group mb-3">
                        <label for="profilePhone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="profilePhone">
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group mb-3">
                        <label for="profileOccupation" class="form-label">Occupation</label>
                        <input type="text" class="form-control" id="profileOccupation">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group mb-3">
                        <label for="profilePlace" class="form-label">Place<span class="required">*</span></label>
                        <input type="text" class="form-control" id="profilePlace">
                      </div>
                    </div>

                    <div class="col-12 text-center">
                      <button type="submit" class="btn btn-red btn-save-changes m-auto">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Toast -->
    <div class="toast-container position-fixed">
      <!-- Remove class show below to hidden toast -->
      <div class="toast um-toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header border-bottom-0">
          <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          <p class="text-center text-secondary">Your information has been succesfully saved.</p>
          <img src="assets/img/frontend/ic-check-mask.png" alt="ic-check-mask" class="d-block mx-auto img-fluid">
        </div>
      </div>
    </div>
    <!-- End toast -->
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>