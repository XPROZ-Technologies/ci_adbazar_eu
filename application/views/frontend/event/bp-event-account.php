<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-bp-account">
    <div class="bp-account">
      <div class="container">
        <div class="row">
          <div class="col-lg-1"></div>
          <div class="col-lg-6">
            <div class="bp-account-left">
              <h1 class="text-center page-title mb-20">Sign in with your account</h1>
              <div class="signup-form">
                <form class="form-signin" id="formLogin" method="POST" action="<?php echo base_url('customer-login'); ?>">
                  <div class="form-group mx-auto mb-16 pb-lg-3">
                    <label for="inputEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="customer_email" placeholder="Email" required>
                  </div>
                  <div class="mx-auto mb-16">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="customer_password" required >
                  </div>

                  <div class="mx-auto d-flex justify-content-between align-items-center mb-20">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox"  id="rememberPass" name="is_remember" value="on" >
                      <label class="form-check-label" for="rememberPass">
                        Remember me
                      </label>
                    </div>
                    <a href="#forgotPasswordModal" data-bs-toggle="modal" class=" page-text-lg fw-bold">Forgot
                      your password?</a>
                  </div>
                  <div class="col-12 d-flex justify-content-center mb-3 mt-lg-4">
                    <button type="submit" class="btn btn-red px-3">Sign in</button>
                  </div>
                  <p class="text-center mb-2 mb-lg-4 text-black">Not have an account yet? <a href="<?php echo base_url('signup.html'); ?>" class="ms-3 text-black fw-bold">Sign up</a></p>
                  <p class="text-center mt-3 mt-lg-0">
                  <p class="text-center mt-3 mt-lg-0 position-relative or-line fw-bold"><span>Or</span></p>
                  </p>
                  <div class="mx-auto text-center mb-3 sign-social">
                    <a href="#" class="btn btn-outline-red login-gg">
                      <img src="assets/img/frontend/ic-google.png" class="icon-google" alt="icon google">
                      Log in with Google
                    </a>
                    <a style="display:none;" href="javascript:void(0);" class="g-signin2 btn btn-outline-red" data-onsuccess="onSignIn">
                                        </a>
                    <a href="#" class="btn btn-outline-red mt-3 mt-lg-0" onclick="fbLogin();" id="fbLink">
                      <img src="assets/img/frontend/ic-facebook.png" class="icon-fb" alt="icon fb">
                      Log in with Facebook</a>
                  </div>
                  <input type="hidden" name="redirectOldUrl" value="<?php echo $redirectOldUrl; ?>" />
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-1"></div>
          <div class="col-lg-4 d-flex flex-column justify-content-center align-items-center has-border">
            <div class="bp-account-right">
              <a href="javascript:void(0)" class="btn btn-red btn-join-as-guest">Continue as Guest</a>
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
              <h3 class="text-center mb-4 pb-lg-2 page-title-sm">Password assistance
              </h3>
              <p class="mb-0 text-center mb-32">Enter your username or email to recover your password. You will receive an email with instructions.</p>
              <form class="row">
                <div class="col-12 mx-auto mb-4">
                  <label for="inputForgotPassEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" id="inputForgotPassEmail">
                  <div class="invalid-feedback">
                    *Your email is incorrect. Please try again.
                  </div>
                </div>

                <div class="col-12 d-flex justify-content-center mb-2">
                  <button type="submit" class="btn btn-red">Submit</button>
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
        <p class="page-text-lg text-center">This function will be available soon. Please Sign Up to join the event</p>
        <a href="<?php echo base_url('signup.html'); ?>" class="btn btn-red btn-contact-ad">Sign Up</a>
      </div>
    </div>
  </div>
</div>
<!-- End Modal cannot create -->

<script>
  $('.btn-join-as-guest').click(function() {
    $("#eventJoinAsGuest").modal('show');
  });
</script>