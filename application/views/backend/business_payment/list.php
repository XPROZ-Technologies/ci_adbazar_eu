<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
            </section>
            <section class="content">
                <div class="box box-default">
                    <?php sectionTitleHtml('Filter'); ?>
                    <div class="box-body row-margin">
                        <?php echo form_open('backend/businesspayment'); ?>
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <input type="text" name="search_text" class="form-control" value="<?php echo set_value('search_text'); ?>" placeholder="Payment Name, Payment Address">
                            </div>
                            <div class="col-sm-2 form-group">
                                <?php $this->Mconstants->selectObject($listBusinessProfiles, 'id', 'business_name', 'business_profile_id', set_value('business_profile_id'), true, '--choose--', ' select2'); ?>
                            </div>
                            <div class="col-sm-2 form-group">
                                <?php $this->Mconstants->selectConstants('paymentGatewayIds', 'payment_gateway_id', set_value('payment_gateway_id'), true, '--Payment Gateway--'); ?>
                            </div>
                            <div class="col-sm-2 form-group">
                                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Search">
                                <input type="text" hidden="hidden" name="page_id" id="pageId" value="<?php echo set_value('page_id'); ?>">
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="box box-success">
                    <?php sectionTitleHtml($title, isset($paggingHtml) ? $paggingHtml : ''); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>Payment Name</th>
                                <th>Payment Address</th>
                                <th>Business Profile</th>
                                <th>Payment Gateway</th>
                                <th>Payment Company</th>
                                <th>Payment Company Vat</th>
                                <th>Payment Amount</th>
                                <th>Payment Vat</th>
                                <th>Payment Total</th>
                                <th>Payment Currency</th>
                            </tr>
                            </thead>
                            <tbody id="">
                            <?php $i = 0;
                            foreach($lisBusinessPayments as $s){
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $s['payment_name']; ?></td>
                                    <td><?php echo $s['payment_address']; ?></td>
                                    <td><?php echo $this->Mbusinessprofiles->getFieldValue(array('id' =>$s['business_profile_id']), 'business_name', ''); ?></td>
                                    <td><?php echo $this->Mconstants->paymentGatewayIds[$s['payment_gateway_id']]; ?></td>
                                    <td><?php echo $s['payment_company_id']; ?></td>
                                    <td><?php echo $s['payment_compnay_vat_id']; ?></td>
                                    <td><?php echo priceFormat($s['payment_amount'], true); ?></td>
                                    <td><?php echo priceFormat($s['payment_vat'], true); ?></td>
                                    <td><?php echo priceFormat($s['payment_total'], true); ?></td>
                                    <td><?php echo $s['payment_currency']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php $this->load->view('backend/includes/pagging_footer'); ?>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('backend/includes/footer'); ?>