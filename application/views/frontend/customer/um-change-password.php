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
                  <form class="um-change-form" action="<?php echo base_url('customer-change-password'); ?>" method="POST" id="formChangePass">
                    <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>" />
                    <h3 class="page-title-md text-center">Set up your new password</h3>
                    <div class="form-group mb-3">
                      <label for="profilePassword" class="form-label">Current
                        Password<span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg" id="profilePassword" name="current_password" required >
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="icon-show-pass">
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <label for="profileNewPassword" class="form-label">New
                        Password<span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg" id="profileNewPassword" name="new_password" required >
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="icon-show-pass">
                      </div>
                    </div>
                    <div class="form-group mb-3" id="confirmPassBlock">
                      <label for="profileConfirmPassword" class="form-label">Confirm
                        New Password<span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg" id="profileConfirmPassword" name="repeat_password" required >
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="icon-show-pass">
                        <div class="invalid-feedback">Your password does not match,
                          please try again.</div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-red btn-save-changes">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>
<script>
  $( "#formChangePass" ).submit(function( event ) {
    event.preventDefault();
    var new_pass = $("#profileNewPassword").val();
    var repeat_pass = $("#profileConfirmPassword").val();
    var flag = true;
    if(new_pass !== repeat_pass){
      $("#profileConfirmPassword").addClass('is-invalid');
      $("#confirmPassBlock").addClass('has-validation');
      flag = false;
    } else {
      $("#profileConfirmPassword").removeClass('is-invalid');
      $("#confirmPassBlock").removeClass('has-validation');
      flag = true;
    }
    if(flag == true){
      this.submit();
    }
    
  });
</script>