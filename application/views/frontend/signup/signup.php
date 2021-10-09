<?php $this->load->view('frontend/includes/header_login_signup'); ?>
<main>
    <div class="page-signup">
        <div class="signup-img">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <a href="<?php echo base_url(HOME_URL); ?>">
                            <img src="assets/img/frontend/img-setup.png" alt="signup-img" class="img-fluid">
                        </a>
                        <h2 class="text-center mb-10 page-title-sm v1"><?php echo $this->lang->line('sign_up'); ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="signup-form">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form class="signup-form-list row" id="formRegister" method="POST" action="<?php echo base_url('customer-signup'); ?>">
                            <div class="col-lg-12 px-lg-0 mx-auto mb-20">
                                <div class="form-group">
                                    <label for="inputEmail" class="form-label"><?php echo $this->lang->line('email'); ?></label>
                                    <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo $this->lang->line('email'); ?>" name="customer_email" required>
                                </div>
                            </div>
                            <div class="col-lg-12 px-lg-0 mx-auto mb-20">
                                <div class="form-group">
                                    <label for="inputPassword" class="form-label"><?php echo $this->lang->line('password'); ?></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control inputPassword" id="inputPassword" placeholder="<?php echo $this->lang->line('password'); ?>" name="customer_password" required>
                                        <img src="assets/img/frontend/ic-eye.png" class="input-eye">
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
                            </div>

                            <div class="col-lg-12 px-lg-0 mx-auto mb-20 mb-lg-4">
                                <div class="form-group">
                                    <label for="inputRePassword" class="form-label"><?php echo $this->lang->line('confirm_password'); ?></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control inputPassword" id="inputRePassword" placeholder="<?php echo $this->lang->line('confirm_password'); ?>" name="confirm_password" required>
                                        <img src="assets/img/frontend/ic-eye.png" class="input-eye">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-center">
                                <div class="form-check mx-auto">
                                    <input class="form-check-input" type="checkbox" id="gridCheck" checked >
                                    <label class="form-check-label" for="gridCheck">
                                        <?php echo $this->lang->line('agree_with_our_terms_and_conditions'); ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center mb-3 mt-lg-4">
                                <button type="submit" class="btn btn-red px-3"><?php echo $this->lang->line('sign_up'); ?></button>
                            </div>

                            <div class="p-0">
                                <p class="text-center mb-3 text-black"><?php echo $this->lang->line('already_have_an_account'); ?><a href="<?php echo base_url('login.html'); ?>" class="ms-3 text-black fw-500"><?php echo $this->lang->line('login'); ?></a></p>
                                <p class="text-center mt-3 mt-lg-0 position-relative or-line fw-bold"><span><?php echo $this->lang->line('or_sign_up_with_your_social_network'); ?></span></p>
                                <div class="mx-auto text-center mb-3 sign-social signup">
                                    <a href="javascript:void(0);" class="btn btn-outline-red login-gg">
                                        <img src="./assets/img/frontend/ic-google.png" class="icon-google" alt="icon google">
                                        <?php echo $this->lang->line('sign_up_with_google'); ?>
                                    </a>
                                    <a style="display:none;" href="javascript:void(0);" class="g-signin2 btn btn-outline-red" data-onsuccess="onSignIn">
                                        <a href="javascript:void(0);" class="btn btn-outline-red mt-3 mt-lg-0" onclick="fbLogin();" id="fbLink">
                                            <img src="./assets/img/frontend/ic-facebook.png" class="icon-fb" alt="icon fb">
                                            <?php echo $this->lang->line('sign_up_with_facebook'); ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
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
                        <div class="col-12 mx-auto mb-4 has-validation">
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
</main>
<input type="hidden" value="<?php echo base_url('frontend/customer/loginFb'); ?>" id="loginFacebook">
<?php $this->load->view('frontend/includes/footer_login_signup'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/frontend/login/login.js'); ?>"></script>
<script>
    $( "#formRegister" ).submit(function( event ) {
        event.preventDefault();

        if($('#gridCheck').is(':checked')){
            this.submit();
        }else{
            $(".notiPopup .text-secondary").html('Please agree with our term and condition!');
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);
        }
    });
</script>