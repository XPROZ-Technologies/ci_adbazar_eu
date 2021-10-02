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
                            <h2 class="text-center mb-10 page-title-sm v1">Sign up</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="signup-form">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <form class="signup-form-list row"   id="formRegister" method="POST" action="<?php echo base_url('customer-signup'); ?>"  >
                                <div class="col-lg-12 px-lg-0 mx-auto mb-20">
                                    <div class="form-group">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="customer_email" required >
                                    </div>
                                </div>
                                <div class="col-lg-12 px-lg-0 mx-auto mb-20">
                                    <div class="form-group">
                                        <label for="inputPassword" class="form-label">Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control inputPassword" id="inputPassword" placeholder="Password" name="customer_password" required  >
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
                                        <label for="inputRePassword" class="form-label">Confirm Password</label>
                                            <div class="position-relative">
                                                <input type="password" class="form-control inputPassword"
                                                    id="inputRePassword" placeholder="Confirm Password" name="confirm_password" required  >
                                                <img src="assets/img/frontend/ic-eye.png" class="input-eye">
                                            </div>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-center">
                                    <div class="form-check mx-auto">
                                        <input class="form-check-input" type="checkbox" id="gridCheck">
                                        <label class="form-check-label" for="gridCheck">
                                            Agree with our&nbsp<a class="fw-bold text-underline" href="javascript:void(0)">Term and Conditions</a>

                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-center mb-3 mt-lg-4">
                                    <button type="submit" class="btn btn-red px-3">Sign up</button>
                                </div>
                                </form>
                                <div class="p-0">
                                    <p class="text-center mb-3 text-black">Already have an account?<a
                                            href="signin.html" class="ms-3 text-black fw-500">Log in</a></p>
                                    <p class="text-center mt-3 mt-lg-0 position-relative or-line fw-bold"><span>Or</span></p>                                
                                    <div class="mx-auto text-center mb-3 sign-social signup">
                                    <a href="#" class="btn btn-outline-red">
                                        <img src="./assets/img/frontend/ic-google.png" class="icon-google" alt="icon google">
                                        Sign up with Google
                                    </a>
                                    <a href="#" class="btn btn-outline-red mt-3 mt-lg-0">
                                        <img src="./assets/img/frontend/ic-facebook.png" class="icon-fb" alt="icon fb">
                                        Sign in with Facebook</a>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal forgot password -->
        <div class="modal fade forgot-password" id="forgotPasswordModal" tabindex="-1"
            aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
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
<?php $this->load->view('frontend/includes/footer_login_signup'); ?>