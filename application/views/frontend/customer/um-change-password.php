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
                    <h3 class="page-title-md text-center"><?php echo $this->lang->line('set_up_your_new_password'); ?></h3>
                    <div class="form-group mb-3">
                      <label for="profilePassword" class="form-label">Current
                        Password<span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg" id="profilePassword" name="current_password" required >
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="input-eye">
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <label for="profileNewPassword" class="form-label">New Password<span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg" id="profileNewPassword" name="new_password" required >
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="input-eye">
                        <div class="tooltip-signup">
                          <p>Your password has to meet the following requirements: </p>
                          <ul>
                              <li>At least 8 characters—the more characters, the better.</li>
                              <li>At least 1 uppercase letter.</li>
                              <li>A mixture of letters and numbers.</li>
                          </ul>
                      </div>
                      </div>
                    </div>
                    <div class="form-group mb-3" id="confirmPassBlock">
                      <label for="profileConfirmPassword" class="form-label"><?php echo $this->lang->line('confirm'); ?>
                      <span class="required text-danger">*</span></label>
                      <div class="position-relative">
                        <input type="password" class="form-control form-control-lg" id="profileConfirmPassword" name="repeat_password" required >
                        <img src="assets/img/frontend/ic-eye.png" alt="icon-show-pass" class="input-eye">
                        <div class="invalid-feedback"><?php echo $this->lang->line('your_password_does_not_match_please_try_again'); ?></div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-red btn-save-changes"><?php echo $this->lang->line('save_changes'); ?></button>
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