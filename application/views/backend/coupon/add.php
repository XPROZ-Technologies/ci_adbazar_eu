<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Save</button></li>
                    <li><a href="<?php echo base_url('sys-admin/coupon'); ?>" class="btn btn-default">Cancel</a></li>
                </ul>
            </section>
            <section class="content">
                <?php echo form_open('sys-admin/coupon/insert-update', array('id' => 'couponForm')); ?>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Business Profile <span class="required">*</span></label>
                                        <select class="form-control" name="business_profile_id" id="business_profile_id"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Subject <span class="required">*</span></label>
                                        <input type="text" name="coupon_subject" id="coupon_subject" class="form-control hmdrequired" data-field="Subject" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Amount <span class="required">*</span></label>
                                        <input type="number" name="coupon_amount" class="form-control hmdrequired" value="0" data-field="Amount" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Start Date <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" name="start_date" id="start_date" class="form-control hmdrequired" data-field="Start Date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">End Date <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" name="end_date" id="end_date" class="form-control hmdrequired" data-field="End Date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <textarea rows="9"  class="form-control" name="coupon_description"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box box-default">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="control-label" style="width: 100%;">Image<button type="button" class="btn btn-box-tool" id="btnImage"><i class="fa fa-upload"></i> Choose image</button></label>
                                    <img src="<?php echo COUPONS_PATH.NO_IMAGE; ?>" id="imgImage" style="width: 280px;">
                                    <input type="text" hidden="hidden" id="logoImageImage" name="coupon_image">
                                    <input type="file" style="display: none;" id="logoFileImage">
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><button class="btn btn-primary submit" type="button">Save</button></li>
                    <li><a href="<?php echo base_url('sys-admin/coupon'); ?>" class="btn btn-default" id="btnCancel">Cancel</a></li>
                    <input type="text" hidden="hidden" name="id" value="0">
                    <input type="text" hidden="hidden" id="urlGetBusinessProfile" value="<?php echo base_url('sys-admin/coupon/get-list-business-profile') ?>">
                    <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/upload'); ?>">
                </ul>
                <?php echo form_close(); ?>
            </section>    
        </div> 
    </div>
<?php $this->load->view('backend/includes/footer'); ?>
<?php $this->load->view('backend/coupon/_lang'); ?>