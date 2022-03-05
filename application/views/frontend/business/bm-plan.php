<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <?php $this->load->view('frontend/includes/bm_top_header'); ?>

    <div class="bm-plan">
      <div class="bm-plan-top">
        <div class="container">
          <h2 class="text-center page-title-md"><?php echo $this->lang->line('you_will_need_to_make_a_paymen'); ?></h2>
          <div class="d-flex flex-column flex-md-row justify-content-center align-items-center paypal">
            <p class="mb-0 text-secondary fw-500 page-title-xs"><?php echo $this->lang->line('secured_payment_through_paypal'); ?></p>
            <img src="assets/img/frontend/bm-paypal.png" alt="paypal image" class="img-fluid">
          </div>
          <?php if($customerInfo['free_trial'] == 0){ ?>
          <p class="page-title-sm fw-bold text-center text-primary mb-0"><?php echo $this->lang->line('3-month_free_trial_is_availabl'); ?></p>
          <?php  } ?>
          <!-- Change currency -->
          <div class="d-flex align-items-center justify-content-center currency-wrap">
            <span class="fw-500"><?php echo $this->lang->line('currency'); ?></span>
            <div class="d-flex align-items-center justify-content-center switch-btn">
              <input id="checkbox_currency" type="checkbox" class="checkbox" checked />
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
                  <div class="card text-center bm-plan-item selected-plan">
                    <div class="card-header">
                      <div class="container-radio">
                        <input type="radio" name="bm-plan" id="plan1" class="plan-input-radio monthlyPlan" checked value="1" />
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
                  <div class="card text-center bm-plan-item">
                    <div class="card-header">
                      <div class="container-radio">
                        <input type="radio" name="bm-plan" id="plan2" class="plan-input-radio annualPlan" value="2" />
                        <span class="checkmark"></span>
                      </div>
                      <span class="text-header fw-bold"><?php echo $this->lang->line('annual_payment'); ?></span>
                    </div>

                    <div class="card-body plan-card fw-500">
                      <div class="month text-success">
                        <span class="text-month fw-bold"><span class="main_price_annual">11990 CZK</span><?php echo $this->lang->line('czk_year'); ?></span>
                        <small class="page-text-sm fw-500"><?php echo $this->lang->line('bill_save'); ?><span class="bill_save">291 CZK</span><?php echo $this->lang->line('bill_month'); ?></small>
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
                          <p class="mb-1 text-payment"><?php echo $this->lang->line('as_one_payment_of'); ?> <span class="main_price_annual">11990 CZK</span>
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
              <input type="hidden" name="business_plan" id="businessPlan" value="1" />
              <input type="hidden" name="isTrial" id="isTrial" value="false" />
              <input type="hidden" name="tokenDraft" value="<?php echo uniqid(strtotime(date('Ymd H:i:s'))); ?>" id="tokenDraft" />
            </form>
            <div class="bm-plan-trail">
              <div class="d-flex justify-content-end">
                <div class="d-flex flex-column align-items-end">
                    <div class="d-flex align-items-center">
                        <?php if($customerInfo['free_trial'] == 0){ ?>
                          <a data-isTrial="1" class="btn btn-red btn-red-md btn-trail mb-3 mb-md-0 btn-select-plan"><?php echo $this->lang->line('start_3-month_free_trial'); ?></a>
                        <?php } ?>
                        <!-- <a data-isTrial="true"  class="btn btn-outline-red btn-outline-red-md btn-no-trail btn-select-plan">
                          <?php echo $this->lang->line('no_i_don’t_need_a_free_trial'); ?>
                        </a> -->
                        <!--<a data-isTrial="true" href="<?php echo base_url('business-profile/create-new-business?plan=1&isTrial=true&tokenDraft='.uniqid(strtotime(date('Ymd H:i:s')))); ?>" class="btn btn-outline-red btn-outline-red-md btn-no-trail">-->
                        <?php if($customerInfo['free_trial'] == 0){ ?>
                          <a data-isTrial="0" href="javascript:void(0);" class="btn btn-outline-red btn-outline-red-md btn-no-trail">
                            <?php echo $this->lang->line('no_i_don’t_need_a_free_trial'); ?>
                          </a>
                        <?php }else{ ?>
                          <a data-isTrial="0" class="btn btn-red btn-red-md btn-trail mb-3 mb-md-0 btn-no-trail"><?php echo $this->lang->line('proceed_to_checkout'); ?></a>
                          <a style="line-height: 21px;margin-left:10px;" href="<?php echo base_url('my-business-profile'); ?>" class="btn btn-trail btn-outline-red btn-outline-red-md">
                            Cancel
                          </a>
                        <?php } ?>
                    </div>
                    <?php if($customerInfo['free_trial'] == 0){ ?>
                      <p class="text-danger text-center page-text-sm align-items-center fw-500"><?php echo $this->lang->line('you_will_not_be_charged_anythi'); ?> </p>
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
    var select_plan = $('input[name=bm-plan]:checked').val();
    var token_draf = $('input#tokenDraft').val();
    var url = '<?php echo base_url('business-profile/create-new-business'); ?>';
    window.location.href = url + '?plan=' + select_plan + '&isTrial=0' + '&tokenDraft=' + token_draf;
  });

  $("body").on("change", "#checkbox_currency", function() {
      console.log('change');
      if($(this).is(":checked")){
        //CZK
        $(".main_price").html("1290 CZK");
        $(".main_price_annual").html("11990 CZK");
        $(".bill_save").html('291 CZK');
        $(".monthlyPlan").val("1");
        $(".annualPlan").val("2");
      }else{
        //EUR
        $(".main_price").html("51.99 EUR");
        $(".main_price_annual").html("499.99 EUR");
        $(".bill_save").html('8 EUR');
        $(".monthlyPlan").val("3");
        $(".annualPlan").val("4");
      }
  });
</script>
