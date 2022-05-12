<?php $this->load->view('frontend/includes/header'); ?>
<?php 
  $expiredDate = strtotime(ddMMyyyy($businessInfo['expired_date'], 'Y-m-d'));
  $currentDate = strtotime(date('Y-m-d'));
  $isExpired = 0;
  if($currentDate > $expiredDate) {
    $isExpired = 1;
  }
?>
<main>
  <div class="page-business-manager">
    <?php $this->load->view('frontend/includes/bm_top_header'); ?>

    <div class="bm-plan">
      <div class="bm-plan-top">
        <div class="container">
          <h2 class="text-center page-title-md" style="font-size: 28px;line-height:1.5;">Switch subscription plan</h2>
          <?php if($isExpired == 0){ ?>
            <p class="page-title-sm fw-bold text-center text-danger mb-0">Your business plan (<?php if($planInfo['plan_type_id'] == 1){ echo 'Monthly payment'; }else{ echo 'Annual payment'; } ?>) will be expired on <?php echo $dateExpired; ?></p>
          <?php } ?>
          <div class="d-flex flex-column flex-md-row justify-content-center align-items-center paypal">
            <p class="mb-0 text-secondary fw-500 page-title-xs"><?php echo $this->lang->line('secured_payment_through_paypal'); ?></p>
            <img src="assets/img/frontend/bm-paypal.png" alt="paypal image" class="img-fluid">
          </div>
          <!-- Change currency -->
          <div class="d-flex align-items-center justify-content-center currency-wrap">
            <span class="fw-500"><?php echo $this->lang->line('currency'); ?></span>
            <div class="d-flex align-items-center justify-content-center switch-btn">
              <input id="checkbox_currency" type="checkbox" class="checkbox" <?php if($planInfo['plan_currency_id'] == 1){ echo 'checked'; } ?> />
              <label for="checkbox_currency" class="switch">
                <span class="switch-circle">
                  <span class="switch-circle-inner"></span>
                </span>
                <span class="switch-left">EUR</span>
                <span class="switch-right">CZK</span>
              </label>
            </div>
          </div>
          <!-- END. Change currency -->
        </div>
      </div>

      <div class="bm-plan-list">
        <div class="container">
          <div class="list-plan-inner grid-60">
            <div class="row align-items-center">
              <!-- Month payment plan -->
              <div class="col-lg-6">
                <label for="plan1" class="label-plan">
                  <div class="card text-center bm-plan-item <?php if($planInfo['plan_type_id'] == 1){ echo 'selected-plan'; } ?>">
                    <div class="card-header">
                      <div class="container-radio">
                        <input type="radio" name="bm-plan" id="plan1" class="plan-input-radio monthlyPlan" <?php if($planInfo['plan_type_id'] == 1){ echo 'checked'; } ?> value="<?php if($planInfo['plan_currency_id'] == 1){ echo '1'; }else{ echo '3'; } ?>" />
                        <span class="checkmark"></span>
                      </div>
                      <span class="text-header fw-bold"><?php echo $this->lang->line('monthly_payment'); ?></span>
                    </div>

                    <div class="card-body plan-card fw-500">
                      <div class="month text-success">
                        <span class="text-month fw-bold"><span class="main_price">1290 CZK</span><?php echo $this->lang->line('czk_month'); ?></span>
                      </div>
                      <ul class="list-text fw-500">
                        <li><?php echo $this->lang->line('create_business_profile'); ?></li>
                        <li><?php echo $this->lang->line('show_on_map'); ?></li>
                        <li><?php echo $this->lang->line('marketing'); ?></li>
                      </ul>
                      <div class="page-text-lg description">
                        <div class="wrapper-text">
                          <p class="mb-1 text-bill text-primary"><?php echo $this->lang->line('billed_monthly'); ?>
                          </p>
                          <p class="mb-1 text-payment"><?php echo $this->lang->line('as_one_payment_of'); ?> <span class="main_price">1290 CZK</span>
                          </p>
                        </div>
                        <p class="mb-0 text-warning text-vat"><?php echo $this->lang->line('vat_and_local_taxes_may_apply'); ?></p>
                      </div>
                    </div>
                  </div>
                </label>
              </div>
              <!-- END. Month payment plan -->

              <!-- Year payment plan -->
              <div class="col-lg-6">
                <label for="plan2" class="label-plan">
                  <div class="card text-center bm-plan-item <?php if($planInfo['plan_type_id'] == 2){ echo 'selected-plan'; } ?>">
                    <div class="card-header">
                      <div class="container-radio">
                        <input type="radio" name="bm-plan" id="plan2" class="plan-input-radio annualPlan" <?php if($planInfo['plan_type_id'] == 2){ echo 'checked'; } ?> value="<?php if($planInfo['plan_currency_id'] == 1){ echo '2'; }else{ echo '4'; } ?>" />
                        <span class="checkmark"></span>
                      </div>
                      <span class="text-header fw-bold"><?php echo $this->lang->line('annual_payment'); ?></span>
                    </div>

                    <div class="card-body plan-card fw-500">
                      <div class="month text-success">
                        <span class="text-month fw-bold"><span class="main_price_annual">499.99 EUR</span><?php echo $this->lang->line('czk_year'); ?></span>
                        <small class="page-text-sm fw-500"><?php echo $this->lang->line('bill_save'); ?><span class="bill_save">8 EUR</span><?php echo $this->lang->line('bill_month'); ?></small>
                      </div>
                      <ul class="list-text fw-500">
                        <li><?php echo $this->lang->line('create_business_profile'); ?></li>
                        <li><?php echo $this->lang->line('show_on_map'); ?></li>
                        <li><?php echo $this->lang->line('marketing'); ?></li>
                      </ul>
                      <div class="page-text-lg description">
                        <div class="wrapper-text">
                          <p class="mb-1 text-bill text-primary"><?php echo $this->lang->line('billed_anually'); ?>
                          </p>
                          <p class="mb-1 text-payment"><?php echo $this->lang->line('as_one_payment_of'); ?> <span class="main_price_annual">499.99 EUR</span>
                          </p>
                        </div>
                        <p class="mb-0 text-warning text-vat"><?php echo $this->lang->line('vat_and_local_taxes_may_apply'); ?></p>
                      </div>
                    </div>
                  </div>
                </label>
              </div>
              <!-- END. Year payment plan -->
            </div>
            <form action="<?php echo base_url('business-profile/submit-select-plan'); ?>" method="POST" id="formSelectPlan">
              <input type="hidden" name="currentPlanId" id="currentPlanId" value="<?php echo $planInfo['id']; ?>" />
              <input type="hidden" name="business_plan" id="businessPlan" value="<?php echo $planInfo['id']; ?>" />
              <input type="hidden" name="businessId" id="businessId" value="<?php echo $businessInfo['id']; ?>" />
              <input type="hidden" name="customerId" id="customerId" value="<?php echo $customer['id']; ?>" />
            </form>
            <div class="bm-plan-trail">
              <div class="d-flex justify-content-end">
                <div class="d-flex flex-column align-items-end">
                    <div class="d-flex align-items-center">
                          <a data-isTrial="0" class="btn btn-red btn-red-md btn-trail mb-3 mb-md-0 btn-no-trail">Checkout</a>
                          <a style="line-height: 21px;margin-left:10px;" href="<?php echo base_url('my-business-profile'); ?>" class="btn btn-outline-red btn-trail btn-outline-red-md">
                            Cancel
                          </a>
                    </div>
                    <?php if($isExpired == 0){ ?>
                      <p class="text-danger text-center page-text-sm align-items-center fw-500">You will not be charged anything until <?php echo $dateExpired; ?>. </p>
                    <?php } ?>
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

  <?php 
    if($planInfo['plan_currency_id'] == 1){
      ?>
        $(".main_price").html("983ß CZK");
        $(".main_price_annual").html("9909 CZK");
        $(".bill_save").html('191 CZK');
        $(".monthlyPlan").val("1");
        $(".annualPlan").val("2");
      <?php
    }else{
      ?>
        $(".main_price").html("51.99 EUR");
        $(".main_price_annual").html("499.99 EUR");
        $(".bill_save").html('8 EUR');
        $(".monthlyPlan").val("3");
        $(".annualPlan").val("4");
      <?php
    }
  ?>
  $("body").on("click", ".btn-select-plan", function() {
    var select_plan = $('input[name=bm-plan]:checked').val();
    console.log(select_plan);
    var isTrial = $(this).attr('data-isTrial');
    if (select_plan === "1" || select_plan === "2" || select_plan === "3" || select_plan === "4") {
      $('#businessPlan').val(select_plan);
      $('#isTrial').val(isTrial||'0');
      $('#formSelectPlan').submit();
    } else {
      $(".notiPopup .text-secondary").html('<?php echo $this->lang->line("221121_plan_not_exist"); ?>');
      $(".ico-noti-error").removeClass('ico-hidden');
      $(".notiPopup").fadeIn('slow').fadeOut(5000);
    }
  });

  $("body").on("click", ".btn-no-trail", function() {
    var currentPlan = $("input#currentPlanId").val();
    var businessId = $("input#businessId").val();
    var customerId = $("input#customerId").val();
    var select_plan = $('input[name=bm-plan]:checked').val();
    var url = '<?php echo base_url('business-profile/switch-payment/'); ?>';
    if(currentPlan == select_plan){
      $(".notiPopup .text-secondary").html("Please select another plan");
      $(".ico-noti-error").removeClass('ico-hidden');
      $(".notiPopup").fadeIn('slow').fadeOut(7000);
    }else{
      window.location.href = url + '?plan=' + select_plan + '&businessId=' + businessId + '&customerId=' + customerId;
    }
   
  });

  $("body").on("change", "#checkbox_currency", function() {
      console.log('change');
      if($(this).is(":checked")){
        //CZK
        //console.log('CZK');
        $(".main_price").html("983 CZK");
        $(".main_price_annual").html("9909 CZK");
        $(".bill_save").html('191 CZK');
        $(".monthlyPlan").val("1");
        $(".annualPlan").val("2");
      }else{
        //EUR
        //console.log('EUR');
        $(".main_price").html("51.99 EUR");
        $(".main_price_annual").html("499.99 EUR");
        $(".bill_save").html('8 EUR');
        $(".monthlyPlan").val("3");
        $(".annualPlan").val("4");
      }
  });
</script>
