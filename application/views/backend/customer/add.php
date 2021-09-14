<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Save</button></li>
                    <li><a href="<?php echo base_url('sys-admin/customer'); ?>" class="btn btn-default">Cancel</a></li>
                </ul>
            </section>
            <section class="content">
                <?php echo form_open('sys-admin/customer/insert-update', array('id' => 'customerForm')); ?>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">First Name <span class="required">*</span></label>
                                        <input type="text" name="customer_first_name" class="form-control hmdrequired" data-field="First Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Last Name <span class="required">*</span></label>
                                        <input type="text" name="customer_last_name" class="form-control hmdrequired" data-field="First Name" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Phone <span class="required">*</span></label>
                                        <input type="number" name="customer_phone" class="form-control hmdrequired" data-field="Phone" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Email <span class="required">*</span></label>
                                        <input type="text" name="customer_email" class="form-control hmdrequired" data-field="Email" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Occupation</label>
                                        <input type="text" name="customer_occupation" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Gender</label>
                                        <?php $this->Mconstants->selectConstants('genders', 'customer_gender_id', 0, true, '-- Gender --'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Birthday</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker" name="customer_birthday" value="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Address <span class="required">*</span></label>
                                        <input type="text" name="customer_address" class="form-control hmdrequired" data-field="Address" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Password <span class="required">*</span></label>
                                        <input type="text" id="newPass" name="customer_password" class="form-control hmdrequired"  data-field="Password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Retype password <span class="required">*</span></label>
                                        <input type="text" id="rePass" class="form-control hmdrequired" data-field="Retype password" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="javascript:void(0)" class="btn btn-primary" id="generatorPass">Generator Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Free Trial</h3>
                            </div>
                            <div class="box-body">
                                <input type="checkbox" value="1" class="js-switch" name="free_trial"/>
                            </div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Avatar</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php $avatar = (set_value('avatar')) ? set_value('avatar') : NO_IMAGE; ?>
                                    <img src="<?php echo CUSTOMER_PATH.$avatar; ?>" class="chooseImage" id="imgAvatar" style="width: 50%;display: block;left: 0;right: 0;margin: auto;">
                                    <input type="text" hidden="hidden" name="customer_avatar" id="avatar" value="<?php echo $avatar; ?>">
                                </div>
                                <div class="progress" id="fileProgress" style="display: none;">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <input type="file" style="display: none;" id="inputFileImage">
                                <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/upload'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><button class="btn btn-primary submit" type="button">Save</button></li>
                    <li><a href="<?php echo base_url('sys-admin/customer'); ?>" class="btn btn-default" id="btnCancel">Cancel</a></li>
                    <input type="text" hidden="hidden" name="id" value="0">
                </ul>
                <?php echo form_close(); ?>
            </section>
        </div>
    </div>
<?php $this->load->view('backend/includes/footer'); ?>