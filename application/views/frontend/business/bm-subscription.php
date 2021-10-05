<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-content">
      <div class="container">
        <div class="content-top">
          <h2 class="page-title-md text-center fw-bold">Manage my business</h2>
        </div>
        <div class="row">
          <div class="col-lg-3">
            <?php $this->load->view('frontend/includes/business_manage_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="bm-right">
              <div class="bm-subscription">
                <h3 class="page-title-xs text-center">My current subscription plan</h3>
                <div class="w-540">
                  <label for="plan1" class="label-plan">
                    <div class="card text-center bm-plan-item selected-plan">
                      <div class="card-header">
                        <!-- <div class="container-radio">
                                                        <input type="radio" name="bm-plan" id="plan1"
                                                            class="plan-input-radio" checked />
                                                        <span class="checkmark"></span>
                                                    </div> -->
                        <span class="text-header fw-bold">MONTHLY PAYMENT</span>
                      </div>

                      <div class="card-body plan-card fw-500">
                        <div class="month text-success">
                          <span class="text-month fw-bold">1299 CZK/ Month</span>
                        </div>
                        <ul class="list-text fw-500">
                          <li>Create Business profile</li>
                          <li>Show on map</li>
                          <li>Marketing</li>
                        </ul>
                        <div class="page-text-lg description">
                          <div class="wrapper-text">
                            <p class="mb-1 text-bill text-primary">Billed anually
                            </p>
                            <p class="mb-1 text-payment">As one payment of 1299 CZK
                            </p>
                          </div>
                          <p class="mb-0 text-warning text-vat">VAT and local taxes
                            may apply</p>
                        </div>
                      </div>
                    </div>
                  </label>
                </div>
                <p class="mb-0 page-text-lg fw-500 text-center text-notice text-danger">
                  You are actively using your one-month free trial. <br> There are 15 days left till your first payment is required.
                </p>
                <div class="d-flex align-items-center justify-content-center switch-btn disabled">
                  <input id="checkbox4" type="checkbox" class="checkbox" disabled="">
                  <label for="checkbox4" class="switch">
                    <span class="switch-circle">
                      <span class="switch-circle-inner"></span>
                    </span>
                    <span class="switch-left">Off</span>
                    <span class="switch-right">On</span>
                  </label>
                  <p class="mb-0 switch-text">Auto renewal</p>
                </div>

                <div class="text-center actions-btn">
                  <a href="#" class="btn btn-red">Make a payment</a>
                  <a href="#" class="btn btn-outline-red">Cancel subscription</a>
                  <a href="bm-subscription-switch.html" class="fw-500 text-decoration-underline">Switch plan</a>
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