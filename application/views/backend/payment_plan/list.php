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
                        <?php echo form_open('backend/paymentplan'); ?>
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <input type="text" name="search_text" class="form-control" value="<?php echo set_value('search_text'); ?>" placeholder="Plan Name">
                            </div>
                            <div class="col-sm-2 form-group">
                                <?php $this->Mconstants->selectConstants('planTypeIds', 'plan_type_id', set_value('plan_type_id'), true, '--Plan Type--'); ?>
                            </div>
                            <div class="col-sm-2 form-group">
                                <?php $this->Mconstants->selectConstants('planCurrencyIds', 'plan_currency_id', set_value('plan_currency_id'), true, '--Plan Currency--'); ?>
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
                                <th>Plan Name</th>
                                <th>Plan Type</th>
                                <th>Plan Currency</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyPaymentPlan">
                            <?php $i = 0;
                            foreach($lisPaymentPlans as $s){
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $s['plan_name']; ?></td>
                                    <td><?php echo $this->Mconstants->planTypeIds[$s['plan_type_id']]; ?></td>
                                    <td><?php echo $this->Mconstants->planCurrencyIds[$s['plan_currency_id']]; ?></td>
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