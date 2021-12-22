<?php $this->load->view('frontend/includes/header'); ?>
<main>
    <div class="page-business-manager">
        <div class="bm-create">
            <div class="container">
                <div class="bm-bill">
                    <div class="w-869">
                        <form action="<?php echo base_url('business-profile/bm-payment'); ?>">
                            <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>"/>
                            <input type="hidden" name="plan" value="<?php echo $plan ?>"/>
                            <div class="form-bill">
                                <h3 class="text-center page-title text-bill"><?php echo $this->lang->line('billing_title'); ?></h3>
                                <div class="form-group mb-3">
                                    <label for="bm-bill-name"
                                           class="form-label"><?php echo $this->lang->line('business_name_input'); ?>
                                        <span class="required text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="bm-bill-name">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bm-bill-address"
                                           class="form-label"><?php echo $this->lang->line('address_input'); ?><span
                                                class="required text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="bm-bill-address">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bm-bill-id"
                                           class="form-label"><?php echo $this->lang->line('business_id_input'); ?></label>
                                    <input type="text" class="form-control form-control-lg" id="bm-bill-id">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bm-bill-vat"
                                           class="form-label"><?php echo $this->lang->line('vat_id_input'); ?></label>
                                    <input type="text" class="form-control form-control-lg" id="bm-bill-vat">
                                </div>
                            </div>
                            <div class="summary-bill">
                                <h3 class="text-center page-title text-sumary"><?php echo $this->lang->line('summay_order_title') ?></h3>

                                <div class="w-669">
                                    <div class="summary-bill-wrap">
                                        <div class="d-flex justify-content-between fw-500 summary-bill-item">
                                                <span class="page-text-lg">
                                                    <?php echo $this->lang->line('summay_order_price') ?>
                                                </span>
                                            <span class="page-text-lg text-danger price"><?php echo $planPrice ?> <?php echo $planCurrency; ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between fw-500 summary-bill-item">
                                                <span class="page-text-lg">
                                                    <?php echo $this->lang->line('summay_order_vat') ?> (<?php echo $planPriceVatPercent ?>%)
                                                </span>
                                            <span class="page-text-lg text-danger price"><?php echo $planPriceVat ?> <?php echo $planCurrency; ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between fw-500 summary-bill-item">
                                                <span class="page-text-lg">
                                                    <?php echo $this->lang->line('summay_order_total') ?>
                                                </span>
                                            <span class="page-text-lg text-danger price"><?php echo $planPriceTotal ?> <?php echo $planCurrency; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center actions-btn">
                                <a id="paypal-button-view" href="<?php echo $payurl ?>"
                                       class="btn btn-red"><?php echo $this->lang->line('checkout_paypal'); ?></a>

                                <a href="<?php echo $cancelUrl ?>"
                                   class="btn btn-outline-red"><?php echo $this->lang->line('cancel'); ?></a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>