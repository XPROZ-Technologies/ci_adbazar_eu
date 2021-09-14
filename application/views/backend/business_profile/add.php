<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Save</button></li>
                    <li><a href="<?php echo base_url('sys-admin/business-profile'); ?>" class="btn btn-default">Cancel</a></li>
                </ul>
            </section>
            <section class="content">
                <?php echo form_open('sys-admin/business-profile/insert-update', array('id' => 'businessProfileForm')); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Customer Name <span class="required">*</span></label>
                                        <select class="form-control" name="customer_id" id="customer_id"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Business Name <span class="required">*</span></label>
                                        <input type="text" name="business_name" id="business_name" class="form-control hmdrequired" data-field="Business Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Slogan <span class="required">*</span></label>
                                        <input type="text" name="full_name" class="form-control hmdrequired" data-field="Slogan" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Business Email <span class="required">*</span></label>
                                        <input type="text" name="business_email" id="business_email" class="form-control hmdrequired" data-field="Business Email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Business Address <span class="required">*</span></label>
                                        <input type="text" name="business_address" class="form-control hmdrequired" data-field="Business Address" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Custom URL</label>
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default"><?php echo base_url('pages/'); ?></button>
                                            </div>
                                            <input type="text" name="business_url" class="form-control" id="business_url" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Country code <span class="required">*</span></label>
                                        <select class="form-control" name="country_code_id" id="country_code_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Phone number <span class="required">*</span></label>
                                        <input type="number" name="business_phone" class="form-control hmdrequired" data-field="Phone number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">WhatsApp number <span class="required">*</span></label>
                                        <input type="number" name="business_whatsapp" class="form-control hmdrequired" data-field="WhatsApp number" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" rows="4" name="business_description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Type of service <span class="required">*</span></label>
                                        <select class="form-control" name="service_id" id="serviceId"></select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Sub-categories <span class="required">*</span></label>
                                        <select class="form-control" id="businessServiceTypeIds" name="business_service_type_ids" multiple></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label" style="width: 100%;">Business Avatar<button type="button" class="btn btn-box-tool" id="btnAvatar"><i class="fa fa-upload"></i> Choose image</button></label>
                                        <img src="<?php echo BUSINESS_PROFILE_PATH.NO_IMAGE; ?>" id="imgAvatar" style="width: 280px;">
                                        <input type="text" hidden="hidden" id="logoImageAvatar" name="business_avatar">
                                        <input type="file" style="display: none;" id="logoFileAvatar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label" style="width: 100%;">Business Image Cover<button type="button" class="btn btn-box-tool" id="btnCover"><i class="fa fa-upload"></i> Choose image</button></label>
                                        <img src="<?php echo BUSINESS_PROFILE_PATH.NO_IMAGE; ?>" id="imgCover" style="width: 280px;">
                                        <input type="text" hidden="hidden" id="logoImageCover" name="business_image_cover" >
                                        <input type="file" style="display: none;" id="logoFileCover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box box-default">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Location Name</label>
                                            <select class="form-control" name="location_id" id="location_id"> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Expired Date</label>
                                            <input type="text" name="expired_date" id="expired_date" class="form-control">
                                            <input type="hidden" name="business_profile_location_id" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Opening hour <span class="required">*</span></h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php foreach($this->Mconstants->dayIds as $key => $text): ?>
                                    <div class="row opening_hour">
                                        <div class="col-sm-2 form-group">
                                            <label class="control-label"><?php echo $text ?></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" value="1" day-id="<?php echo $key ?>" name="opening_hours_status_id" class="js-switch"/>
                                            <span id="textDay_<?php echo $key ?>">Close</span>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                <input type="text" class="form-control datetimepicker-start" name="start_time" id="start_time_<?php echo $key ?>" placeholder="Close at" readonly>
                                                </div>
                                                <div class="col-sm-2" style="top: 7px;text-align: center;"><span>To</span></div>
                                                <div class="col-sm-5">
                                                <input type="text" class="form-control datetimepicker-end" name="end_time" id="end_time_<?php echo $key ?>" placeholder="Close at" readonly>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="day_id" value="<?php echo $key ?>">
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><button class="btn btn-primary submit" type="button">Save</button></li>
                    <li><a href="<?php echo base_url('sys-admin/business-profile'); ?>" class="btn btn-default" id="btnCancel">Cancel</a></li>
                    <input type="text" hidden="hidden" name="id" value="0">
                    <input type="text" hidden="hidden" id="urlGetCustomer" value="<?php echo base_url('sys-admin/customer/get-list') ?>">
                    <input type="text" hidden="hidden" id="urlGetService" value="<?php echo base_url('sys-admin/service/get-list') ?>">
                    <input type="text" hidden="hidden" id="urlGetServiceType" value="<?php echo base_url('sys-admin/service/get-list-service-type') ?>">
                    <input type="text" hidden="hidden" id="urlGetPhoneCode" value="<?php echo base_url('sys-admin/phone-code/get-list') ?>">
                    <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/upload'); ?>">
                    <input type="text" hidden="hidden" id="urlGetLocationNotInBusinessProfile" value="<?php echo base_url('sys-admin/location/get-location-not-in-business-profile') ?>">
                </ul>
                <?php echo form_close(); ?>
            </section>    
        </div> 
    </div>
<?php $this->load->view('backend/includes/footer'); ?>
<?php $this->load->view('backend/user/_lang'); ?>