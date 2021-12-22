<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-bp-account">
    <div class="bp-account">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 v1">
            <div class="bp-account-left">
              <h1 class="text-center page-title mb-20"><?php echo $this->lang->line('sign_in_with_your_account'); ?></h1>
              <div class="signup-form">
                <form class="form-signin" id="formLogin" method="POST" action="<?php echo base_url('customer-login'); ?>">
                  <div class="form-group mx-auto mb-16 pb-lg-3">
                    <label for="inputEmail" class="form-label"><?php echo $this->lang->line('email'); ?></label>
                    <input type="email" class="form-control" id="inputEmail" name="customer_email" placeholder="<?php echo $this->lang->line('email'); ?>" required>
                  </div>
                  <div class="mx-auto mb-16">
                    <label for="inputPassword" class="form-label"><?php echo $this->lang->line('password'); ?></label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="<?php echo $this->lang->line('password'); ?>" name="customer_password" required >
                  </div>

                  <div class="mx-auto d-flex justify-content-between align-items-center mb-20">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox"  id="rememberPass" name="is_remember" value="on" >
                      <label class="form-check-label" for="rememberPass">
                      <?php echo $this->lang->line('remember_me'); ?>
                      </label>
                    </div>
                    <a href="#forgotPasswordModal" data-bs-toggle="modal" class=" page-text-lg fw-bold"><?php echo $this->lang->line('forgot_your_password'); ?></a>
                  </div>
                  <div class="col-12 d-flex justify-content-center mb-3 mt-lg-4">
                    <button type="submit" class="btn btn-red px-3"><?php echo $this->lang->line('sign-in1635566199'); ?> </button>
                  </div>
                  <p class="text-center mb-2 mb-lg-4 text-black"><?php echo $this->lang->line('not_have_an_account_yet'); ?> <a href="<?php echo base_url('signup.html'); ?>" class="ms-3 text-black fw-bold"><?php echo $this->lang->line('sign_up'); ?></a></p>
                  <p class="text-center mt-3 mt-lg-0">
                  <p class="text-center mt-3 mt-lg-0 position-relative or-line fw-bold"><span><?php echo $this->lang->line('or1635566199'); ?></span></p>
                  </p>
                  <div class="mx-auto text-center mb-3 sign-social">
                    <a href="#" class="btn btn-outline-red login-gg">
                      <img src="assets/img/frontend/ic-google.png" class="icon-google" alt="icon google">
                      <?php echo $this->lang->line('sign_up_with_google'); ?>
                    </a>
                    <a style="display:none;" href="javascript:void(0);" class="g-signin2 btn btn-outline-red" data-onsuccess="onSignIn">
                                        </a>
                    <a href="#" class="btn btn-outline-red" onclick="fbLogin();" id="fbLink">
                      <img src="assets/img/frontend/ic-facebook.png" class="icon-fb" alt="icon fb">
                      <?php echo $this->lang->line('sign_up_with_facebook'); ?></a>
                  </div>
                  <input type="hidden" name="redirectOldUrl" value="<?php echo $redirectOldUrl; ?>" />
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-6 v2 d-flex flex-column justify-content-center align-items-end">
            <div class="bp-account-right">
              <a href="<?php echo base_url('join-as-guest?event='.$event_id) ?>" class="btn btn-red btn-join-as-guest"><?php echo $this->lang->line('continue_as_guest'); ?></a>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal forgot password -->
      <div class="modal fade forgot-password" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content text-black">
            <div class="modal-header border-bottom-0">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h3 class="text-center mb-4 pb-lg-2 page-title-sm"><?php echo $this->lang->line('password_assistance'); ?>
              </h3>
              <p class="mb-0 text-center mb-32"><?php echo $this->lang->line('enter_your_username_or_email_to_recover_your_password_you_will_receive_an_email_with_instructions'); ?></p>
              <form class="row">
                <div class="col-12 mx-auto mb-4">
                  <label for="inputForgotPassEmail" class="form-label"><?php echo $this->lang->line('email'); ?></label>
                  <input type="email" class="form-control" id="inputForgotPassEmail">
                  <div class="invalid-feedback">
                  <?php echo $this->lang->line('your_email_is_incorrect_please_try_again'); ?>
                  </div>
                </div>

                <div class="col-12 d-flex justify-content-center mb-2">
                  <button type="submit" class="btn btn-red"><?php echo $this->lang->line('submit'); ?></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal forgot password -->
    </div>
  </div>
</main>

<input type="hidden" value="<?php echo base_url('frontend/customer/loginFb'); ?>" id="loginFacebook">
<?php $this->load->view('frontend/includes/footer'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/frontend/login/login.js'); ?>"></script>

<!-- Modal cannot create -->
<div class="modal fade" id="eventJoinAsGuest" tabindex="-1" aria-labelledby="bmCannotCreateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="page-text-lg text-center"><?php echo $this->lang->line('this-function-will-be-availabl1635566199'); ?></p>
        <a href="<?php echo base_url('signup.html'); ?>" class="btn btn-red btn-contact-ad"><?php echo $this->lang->line('sign_up'); ?></a>
      </div>
    </div>
  </div>
</div>
<!-- End Modal cannot create -->

<script>
  $('.btn-join-as-guest').click(function() {
    // $("#eventJoinAsGuest").modal('show');
  });
</script>