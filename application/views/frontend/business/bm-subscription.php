<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-content">
      <div class="container">
        <?php $this->load->view('frontend/includes/bm_header'); ?>

        <div class="row">
          <div class="col-lg-3">
            <?php $this->load->view('frontend/includes/business_manage_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="bm-right">
              <div class="bm-subscription">
                <h3 class="page-title-xs text-center"><?php echo $this->lang->line('my_current_subscription_plan'); ?></h3>
                <div class="w-540">
                  <label for="plan1" class="label-plan">
                    <div class="card text-center bm-plan-item selected-plan">
                      <div class="card-header">
                        <!-- <div class="container-radio">
                                                        <input type="radio" name="bm-plan" id="plan1"
                                                            class="plan-input-radio" checked />
                                                        <span class="checkmark"></span>
                                                    </div> -->
                        <span class="text-header fw-bold"><?php echo $this->lang->line('monthly_payment'); ?></span>
                      </div>

                      <div class="card-body plan-card fw-500">
                        <div class="month text-success">
                          <span class="text-month fw-bold"><?php echo $planInfo['plan_amount']; ?> <?php echo $this->lang->line('czk_month'); ?></span>
                        </div>
                        <ul class="list-text fw-500">
                          <li><?php echo $this->lang->line('create_business_profile'); ?></li>
                          <li><?php echo $this->lang->line('show_on_map'); ?></li>
                          <li><?php echo $this->lang->line('marketing'); ?></li>
                        </ul>
                        <div class="page-text-lg description">
                          <div class="wrapper-text">
                            <p class="mb-1 text-bill text-primary">Billed <?php if($planInfo['plan_type_id'] == 1){ echo "monthly"; }else{ echo "annual"; } ?>
                            </p>
                            <p class="mb-1 text-payment"><?php echo $this->lang->line('as_one_payment_of'); ?> <?php echo $planInfo['plan_amount']; ?> <?php if($planInfo['plan_currency_id'] == 1){ echo "CZK"; }else{ echo "EUR"; } ?>
                            </p>
                          </div>
                          <p class="mb-0 text-warning text-vat">VAT and local taxes may apply</p>
                        </div>
                      </div>
                    </div>
                  </label>
                </div>
                <!--
                <p class="mb-0 page-text-lg fw-500 text-center text-notice text-danger">
                  <?php echo $this->lang->line('you_are_actively_using_your_3-'); ?>
                </p>
                -->
                <div class="d-flex align-items-center justify-content-center switch-btn disabled">
                  <input id="checkbox4" type="checkbox" class="checkbox" disabled="">
                  <label for="checkbox4" class="switch">
                    <span class="switch-circle">
                      <span class="switch-circle-inner"></span>
                    </span>
                    <span class="switch-left">Off</span>
                    <span class="switch-right">On</span>
                  </label>
                  <p class="mb-0 switch-text"><?php echo $this->lang->line('auto_renewal'); ?></p>
                </div>

                <div class="text-center actions-btn">
                  <a href="#" class="btn btn-red"><?php echo $this->lang->line('make_a_payment'); ?></a>
                  <a href="#" class="btn btn-outline-red"><?php echo $this->lang->line('cancel_subscription'); ?></a>
                  <a href="bm-subscription-switch.html" class="fw-500 text-decoration-underline"><?php echo $this->lang->line('switch_plan'); ?></a>
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