<footer class="page-footer">
        <div class="container">
          <div class="row align-items-center d-flex">
              <div class="col-lg-3">
                  <div class="page-footer-info">
                      <a href="<?php echo base_url(HOME_URL); ?>">
                          <img src="<?php echo CONFIG_PATH . $configs['LOGO_FOOTER_IMAGE']; ?>" alt="logo" class="img-fluid footer-logo">
                      </a>
                  </div>
              </div>
              <div class="col-lg-6">
                <div class="page-footer-info">
                    <ul class="list-unstyled">
                        <li><img src="assets/img/frontend/ic-telephone.png" alt="icon ic-telephone"><?php echo $configs['PHONE_NUMBER_FOOTER']; ?></li>
                        <li><img src="assets/img/frontend/ic-email.png" alt="icon mail"><?php echo $configs['EMAIL_FOOTER']; ?></li>
                        <li><img src="assets/img/frontend/ic-place.png" alt="icon place"><?php echo $configs['ADDRESS_FOOTER']; ?></li>
                    </ul>
                </div>
            </div>
              <div class="col-lg-3">
                  <div class="page-footer-right">
                      <h3 class="text-center page-title-sm"><?php echo $this->lang->line('follow_us'); ?></h3>
                      <ul class="list-unstyled list-inline list-social">
                          <li class="list-inline-item"><a href="<?php echo $configs['FACEBOOK_URL']; ?>" ><img src="assets/img/frontend/ic-fb-footer.png" alt="icon fb"></a></li>
                          <li class="list-inline-item"><a href="<?php echo $configs['INSTAGRAM_URL']; ?>"><img src="assets/img/frontend/ic-instagram-footer.png" alt="ic-instagram"></a></li>
                          <li class="list-inline-item"><a href="<?php echo $configs['TIKTOK_URL']; ?>"><img src="assets/img/frontend/ic-music-footer.png" alt="icon music"></a></li>
                          <li class="list-inline-item"><a href="<?php echo $configs['TWITTER_URL']; ?>"><img src="assets/img/frontend/ic-twitter-footer.png" alt="icon twitter"></a></li>
                          <li class="list-inline-item"><a href="<?php echo $configs['PINTEREST_URL']; ?>"><img src="assets/img/frontend/ic-pinterest.png" alt="icon pinterest"></a></li>
                      </ul>
                      <img src="assets/img/frontend/paypal-logo.png" alt="paypal-img" class="img-fluid d-block mx-auto img-paypal">
                      <ul class="list-unstyled list-inline page-text-md list-links mb-0">
                          <li class="list-inline-item"><a href="<?php echo base_url('term-of-use.html'); ?>"><?php echo $this->lang->line('term_of_use'); ?></a></li>
                          <li class="list-inline-item"><a href="<?php echo base_url('privacy-policy.html'); ?>"><?php echo $this->lang->line('privacy_policy'); ?></a></li>
                      </ul>
                  </div>
              </div>
          </div>
        </div>
    </footer>
    
    <!--<script src="assets/js/frontend/commons/jquery.slim.min.js"></script>-->
    <script src="assets/js/frontend/commons/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    
    <script src="assets/js/frontend/commons/owl.carousel.min.js"></script>
    <script src="assets/js/frontend/commons/moment.min.js"></script>
    <!-- <script src="assets/js/frontend/commons/tempusdominus-bootstrap-4.min.js"></script> -->
    <script src="assets/js/frontend/commons/bootstrap.min.js"></script>
    <script src="assets/js/frontend/commons/bootstrap-datetimepicker.js"></script>
    <script src="assets/js/frontend/commons/jquery.nice-select.min.js"></script>
    <!-- <script src="assets/js/frontend/commons/ckeditor.js"></script> -->
    <script src="assets/vendor/plugins/ckeditor/ckeditor.js"></script>
    <script src="assets/vendor/plugins/ckeditor/samples/js/sample.js"></script>
    <script src="assets/js/frontend/commons/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="assets/js/frontend/commons/google.js?version=<?php echo time(); ?>"></script>
    <script src="assets/js/frontend/commons/main.js?version=<?php echo time(); ?>"></script>
    <script src="assets/vendor/plugins/lib/main.js?version=<?php echo time(); ?>"></script>
    <script src="assets/js/frontend/common.js?version=<?php echo time(); ?>"></script>
    <script src="assets/js/frontend/home/list.js?version=<?php echo time(); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/js/BsMultiSelect.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/frontend/login/login.js'); ?>"></script>
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
    <script>
        var textView = '<?php echo $this->lang->line('1310_view'); ?>';
    </script>
    <?php if(isset($scriptFooter)) outputScript($scriptFooter); ?>
</body>

</html>
<?php $this->load->view('frontend/includes/popup_noti'); ?>
<input type="hidden" value="<?php echo base_url('frontend/home/getListProfile'); ?>" id="urlGetListProfile">
<input type="hidden" value="<?php echo base_url('frontend/customer/logout'); ?>" id="logoutFacebook">
<input type="hidden" value="<?php echo current_url(); ?>" id="redirectUrl">
<input type="hidden" value="<?php echo BUSINESS_PROFILE_PATH ?>" id="pathProfileBusiness"> 
<input type="hidden" value="<?php echo BUSINESS_PROFILE_URL ?>" id="urlProfileBusiness">
<!-- Modal saved coupon -->
<div class="modal fade" id="savedCouponModal" tabindex="-1" aria-labelledby="savedCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h4 class="text-center fw-bold page-title-sm"><?php echo $this->lang->line('successfully_saved'); ?></h4>
        <div class="d-flex justify-content-center">
          <a href="<?php echo base_url('customer/my-coupons'); ?>" class="btn btn-red"><?php echo $this->lang->line('view_my_coupons'); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal saved coupon -->

<!-- Modal Register Success -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="page-title-xs text-center"><?php echo $this->lang->line('you_have_been_successfully_registered_for_the'); ?></h3>
                <p class="text-secondary text-center"><?php echo $this->lang->line('we_are_looking_forward_to_seeing_you'); ?>
                </p>
                <div class="btn-view-event">
                    <a href="<?php echo base_url('customer/my-events'); ?>" class="btn btn-red"><?php echo $this->lang->line('view_my_event'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Register Success -->

    