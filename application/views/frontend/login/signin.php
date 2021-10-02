<?php $this->load->view('frontend/includes/header_login_signup'); ?>
<main>
    <div class="page-signin">
        <div class="signin-wrapper">
            <div class="container-fluid px-lg-0">
                <div class="row col-mar-0">
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="signin-left">
                            <img src="assets/img/frontend/bg-signin.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-7 signin-box-right">
                        <div class="signin-right">
                            <h1 class="text-center page-title mb-20">Log in with your account</h1>
                            <div class="signup-form">
                                <form class="form-signin"  id="formLogin" method="POST" action="<?php echo base_url('customer-login'); ?>" >
                                    <div class="form-group mx-auto mb-3">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="inputEmail" placeholder="" name="customer_email" required >
                                    </div>
                                    <div class="mx-auto mb-3">
                                        <label for="inputPassword" class="form-label">Password
                                            <!--<img src="assets/img/frontend/ic-info-outline.png" alt="">-->
                                        </label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="inputPassword" placeholder=""  name="customer_password" required >
                                            <img src="assets/img/frontend/ic-eye.png" class="input-eye">
                                        </div>
                                        <div class="invalid-feedback">
                                            *Your password is incorrect. Please try again.
                                        </div>
                                    </div>

                                    <div class="mx-auto d-flex justify-content-between align-items-center mb-20">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberPass" name="is_remember" value="on">
                                            <label class="form-check-label" for="rememberPass">
                                                Remember me
                                            </label>
                                        </div>
                                        <a href="#forgotPasswordModal" data-bs-toggle="modal" class=" page-text-lg fw-bold">Forgot
                                            your password?</a>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mb-3 mt-lg-4">
                                        <button type="submit" class="btn btn-red px-3">Login</button>
                                    </div>
                                    <p class="text-center mb-2 mb-lg-4 text-black">Not have an account yet? <a href="<?php echo base_url('signup.html'); ?>" class="ms-3 text-black fw-bold">Sign up</a></p>
                                    <p class="text-center mt-3 mt-lg-0 position-relative or-line fw-bold"><span>Or</span></p>
                                    <div class="mx-auto text-center mb-3 sign-social">
                                        <a href="javascript:void(0);" class="btn btn-outline-red login-gg">
                                            <img src="assets/img/frontend/ic-google.png" class="icon-google" alt="icon google">
                                            Log in with Google
                                        </a>
                                        <a style="display:none;" href="javascript:void(0);" class="g-signin2 btn btn-outline-red" data-onsuccess="onSignIn">
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-outline-red mt-3 mt-lg-0" onclick="fbLogin();" id="fbLink">
                                            <img src="assets/img/frontend/ic-facebook.png" class="icon-fb" alt="icon fb">
                                            Log in with Facebook
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal forgot password -->
                        <div class="modal fade forgot-password" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-black height400">
                                    <div class="modal-header border-bottom-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h3 class="text-center mb-16 page-title-sm">Password assistance
                                        </h3>
                                        <p class="mb-0 text-center mb-32">Enter your username or email to recover your password. You will receive an email with instructions.</p>
                                        <form class="row">
                                            <div class="col-12 mx-auto mb-16 has-validation">
                                                <label for="inputForgotPassEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control is-invalid" id="inputForgotPassEmail">
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
            </div>
        </div>
    </div>
    <?php $this->load->view('frontend/includes/popup_noti'); ?>
</main>

<input type="hidden" value="<?php echo base_url('frontend/customer/loginFb'); ?>" id="loginFacebook">
<?php $this->load->view('frontend/includes/footer_login_signup'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/frontend/login/login.js'); ?>"></script>