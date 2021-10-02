<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-user-manager page-um-change-pass">
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
              <div class="um-change-password">
                <div class="justify-content-center">
                  <form class="um-change-form">
                    <h3 class="page-title-md text-center">Set up your new password</h3>
                    <div class="form-group mb-3">
                      <label for="profilePassword" class="form-label">Current
                        Password<span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg" id="profilePassword">
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="icon-show-pass">
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <label for="profileNewPassword" class="form-label">New
                        Password<span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg" id="profileNewPassword">
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="icon-show-pass">
                      </div>
                    </div>
                    <div class="form-group mb-3 has-validation">
                      <label for="profileConfirmPassword" class="form-label">Confirm
                        New Password<span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg is-invalid" id="profileConfirmPassword">
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="icon-show-pass">
                        <div class="invalid-feedback">Your password does not match,
                          please try again.</div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-red btn-save-changes">Save
                        changes</button>
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