<footer class="page-footer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6 page-footer-left">
                            <div class="page-footer-info">
                                <a href="index.html">
                                    <img src="assets/img/frontend/footer-logo.svg" alt="logo" class="img-fluid footer-logo">
                                </a>
                                <ul class="list-unstyled page-text-md">
                                    <li><img src="assets/img/frontend/ic-telephone.svg" alt="icon ic-telephone">+420 938 934 389</li>
                                    <li><img src="assets/img/frontend/ic-email.svg" alt="icon mail">asiadragonbazar@adbazar.eu</li>
                                    <li><img src="assets/img/frontend/ic-place.svg" alt="icon place">Svatý Kříž 281, 35002 Cheb,
                                        Czech Republic</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="page-footer-right">
                                <h3 class="text-center page-title-sm">Follow us</h3>
                                <ul class="list-unstyled list-inline list-social">
                                    <li class="list-inline-item"><a href="#" ><img src="assets/img/frontend/ic-fb-footer.svg" alt="icon fb"></a></li>
                                    <li class="list-inline-item"><a href="#"><img src="assets/img/frontend/ic-instagram-footer.svg" alt="ic-instagram"></a></li>
                                    <li class="list-inline-item"><a href="#"><img src="assets/img/frontend/ic-music-footer.svg" alt="icon music"></a></li>
                                    <li class="list-inline-item"><a href="#"><img src="assets/img/frontend/ic-twitter-footer.svg" alt="icon twitter"></a></li>
                                    <li class="list-inline-item"><a href="#"><img src="assets/img/frontend/ic-pinterest.svg" alt="icon pinterest"></a></li>
                                </ul>
                                <img src="assets/img/frontend/paypal.jpeg" alt="paypal-img" class="img-fluid d-block mx-auto img-paypal">
                                <ul class="list-unstyled list-inline page-text-md list-links">
                                    <li class="list-inline-item"><a href="#">Term of use</a></li>
                                    <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!--<script src="assets/js/frontend/commons/jquery.slim.min.js"></script>-->
    <script src="assets/js/frontend/commons/jquery-3.6.0.min.js"></script>
    <script src="assets/js/frontend/commons/owl.carousel.min.js"></script>
    <script src="assets/js/frontend/commons/moment.min.js"></script>
    <script src="assets/js/frontend/commons/tempusdominus-bootstrap-4.min.js"></script>
    <script src="assets/js/frontend/commons/jquery.nice-select.min.js"></script>
    <script src="assets/js/frontend/commons/ckeditor.js"></script>
    <script src="assets/js/frontend/commons/bootstrap.bundle.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD53XNjfZqrg7twWutFv3rIgnhGvT_Exik&callback=initMap&libraries=&v=weekly" async></script>
    <script src="assets/js/frontend/commons/google.js"></script>
    <script src="assets/js/frontend/commons/main.js?version=4"></script>
    <script src="assets/js/frontend/common.js"></script>
    <?php if(isset($scriptFooter)) outputScript($scriptFooter); ?>
</body>

</html>

<!-- Modal saved coupon -->
<div class="modal fade" id="savedCouponModal" tabindex="-1" aria-labelledby="savedCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-bottom-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h4 class="text-center fw-bold page-title-sm">Successfully Saved!</h4>
          <div class="d-flex justify-content-center">
            <a href="#" class="btn btn-red">View My Coupons</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- End Modal saved coupon -->