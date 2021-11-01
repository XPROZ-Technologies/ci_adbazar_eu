<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-content">
      <div class="container">
        <?php $this->load->view('frontend/includes/bm_header'); ?>
        <?php 
          $expiredDate = strtotime(ddMMyyyy($businessInfo['expired_date'], 'Y-m-d'));
          $currentDate = strtotime(date('Y-m-d'));
          $isExpired = 0;
          if($currentDate > $expiredDate) {
            $isExpired = 1;
          }
        ?>
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
                      
                    <div class="card text-center bm-plan-item selected-plan <?php if($isExpired == 1){ ?>expire-plan<?php } ?>">
                      <div class="card-header">
                        <!-- <div class="container-radio">
                                                        <input type="radio" name="bm-plan" id="plan1"
                                                            class="plan-input-radio" checked />
                                                        <span class="checkmark"></span>
                                                    </div> -->
                        <span class="text-header fw-bold"><?php if($planInfo['plan_type_id'] == 1){ echo $this->lang->line('monthly_payment'); }else{ echo $this->lang->line('annual_payment'); } ?></span>
                      </div>

                      <div class="card-body plan-card fw-500">
                        <div class="month text-success">
                          <span class="text-month fw-bold"><?php echo $planInfo['plan_amount']; ?> <?php if($planInfo['plan_currency_id'] == 1){ echo "CZK"; }else{ echo "EUR"; } ?> <?php echo $this->lang->line('czk_month'); ?></span>
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
                <?php if($businessInfo['is_trial'] == 1){ ?>
                  <p class="mb-0 page-text-lg fw-500 text-center text-notice text-danger">
                    <?php echo $this->lang->line('you_are_actively_using_your_3-'); ?>
                  </p>
                <?php } ?>
                <?php if($isExpired == 1 && $businessInfo['is_trial'] == 0){ ?>
                  <p class="mb-0 page-text-lg fw-500 text-center text-notice text-danger">
                    Your payment has expired.<br>
                    Please make a payment to continue using our service.
                  </p>
                <?php }else if($isExpired == 0){ ?>
                  <p class="mb-0 page-text-lg fw-500 text-center text-notice text-danger">
                    <?php echo dateDifference(date('Y-m-d'), ddMMyyyy($businessInfo['expired_date'], 'Y-m-d')); ?> days left till your next payment term.
                  </p>
                <?php } ?>
                <!--
                <div class="d-flex align-items-center justify-content-center switch-btn disabled">
                  <input id="checkbox4" type="checkbox" class="checkbox" disabled >
                  <lsabel for="checkbox4" class="switch">
                    <span class="switch-circle">
                      <span class="switch-circle-inner"></span>
                    </span>
                    <span class="switch-left">Off</span>
                    <span class="switch-right">On</span>
                  </label>
                  <p class="mb-0 switch-text"><?php echo $this->lang->line('auto_renewal'); ?></p>
                </div>
                -->
                <!-- New Button -->
                <?php if($businessInfo['business_status_id'] == 2 && !empty($businessInfo['subscription_id']) && $isExpired == 0){ ?>
                <div class="d-flex justify-content-center reservation-config">
                  <div class="d-flex align-items-center switch-btn">
                    <input id="reservation-config" type="checkbox" class="checkbox" <?php if ($businessInfo['is_annual_payment'] == 1) {
                                                                                      echo "checked";
                                                                                    } ?>>
                    <label for="reservation-config" class="switch">
                      <span class="switch-circle">
                        <span class="switch-circle-inner"></span>
                      </span>
                      <span class="switch-left">Off</span>
                      <span class="switch-right">On</span>
                    </label>
                    <p class="mb-0 switch-text"><?php echo $this->lang->line('auto_renewal'); ?></p>
                  </div>
                </div>
                <?php } ?>

                <div class="text-center actions-btn">
                  <?php if($businessInfo['business_status_id'] == 3){ ?>
                    <a href="<?php echo base_url('business-profile/continue-payment?plan='.$businessInfo['plan_id'].'&businessId='.$businessInfo['id']); ?>" class="btn btn-red"><?php echo $this->lang->line('make_a_payment'); ?></a>
                  <?php } ?>
                  <?php if($businessInfo['business_status_id'] == 2 && !empty($businessInfo['subscription_id']) && $isExpired == 0){ ?>
                    <input type="hidden" id="subscriptionId" value="<?php echo $businessInfo['subscription_id']; ?>" />
                    <input type="hidden" id="businessId" value="<?php echo $businessInfo['id']; ?>" />
                    <input type="hidden" id="customerId" value="<?php echo $customer['id']; ?>" />
                    <a href="javascript:void(0)" class="btn btn-outline-red btn-cancel-subscription"><?php echo $this->lang->line('cancel_subscription'); ?></a>
                  <?php } ?>
                  <!--<a href="javascript:void(0)" class="fw-500 text-decoration-underline"><?php echo $this->lang->line('switch_plan'); ?></a>-->
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
  $('.btn-cancel-subscription').click(function(e) {
      var business_id = $("#businessId").val();
      var subscription_id = $("#subscriptionId").val();
      var customer_id = $("#customerId").val();

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('business-profile/cancel-subscription'); ?>',
        data: {
          business_id: business_id,
          subscription_id: subscription_id,
          customer_id: customer_id
        },
        dataType: "json",
        success: function(data) {
          if (data.code == 1) {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-success").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          } else {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }
          redirect(true);
        },
        error: function(data) {
          $(".notiPopup .text-secondary").html('<?php echo ERROR_COMMON_MESSAGE; ?>');
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);

          redirect(true);
        }
      });

    });

    $("#reservation-config").on('change', function() {
      var statusReservation = 1
      var urlPost = '<?php echo base_url('business-profile/suspend-subscription'); ?>';
      if ($(this).is(":checked")) {
        statusReservation = 2;
        var urlPost = '<?php echo base_url('business-profile/active-subscription'); ?>';
      }

      var business_id = $("#businessId").val();
      var subscription_id = $("#subscriptionId").val();
      var customer_id = $("#customerId").val();

      $.ajax({
        type: 'POST',
        url: urlPost,
        data: {
          business_id: business_id,
          subscription_id: subscription_id,
          customer_id: customer_id
        },
        dataType: "json",
        success: function(data) {
          if (data.code == 1) {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-success").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          } else {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }
          redirect(true);
        },
        error: function(data) {
          $(".notiPopup .text-secondary").html('<?php echo ERROR_COMMON_MESSAGE; ?>');
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);

          redirect(true);
        }
      });

    });
</script>