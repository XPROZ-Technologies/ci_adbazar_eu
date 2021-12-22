<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Save</button></li>
                    <li><a href="<?php echo base_url('sys-admin/staff'); ?>" class="btn btn-default">Cancel</a></li>
                </ul>
            </section>
            <section class="content">
                <?php echo form_open('sys-admin/staff/insert-update', array('id' => 'userForm')); ?>
                <div class="row">
                    <div class="col-sm-8 no-padding">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">User Name <span class="required">*</span></label>
                                        <input type="text" name="user_name" id="user_name" class="form-control hmdrequired" data-field="User Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Full Name <span class="required">*</span></label>
                                        <input type="text" name="full_name" class="form-control hmdrequired" data-field="Full Name" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Phone Number <span class="required">*</span></label>
                                        <input type="text" name="phone_number" class="form-control hmdrequired" data-field="Phone Number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text" name="email" id="email" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Gender</label>
                                        <?php $this->Mconstants->selectConstants('genders', 'gender_id', 0, true, '--Gender--'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Birth Day</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" class="form-control datepicker" name="birth_day" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Address <span class="required">*</span></label>
                                        <input type="text" class="form-control hmdrequired" name="address" data-field="Address" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Password <span class="required">*</span></label>
                                        <input type="text" id="newPass" name="user_pass" class="form-control hmdrequired"  data-field="Password" autocomplete="off">
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
                                <h3 class="box-title">Role <span class="required">*</span></h3>
                            </div>
                            <div class="box-body">
                                <?php $this->Mconstants->selectConstants('roles', 'role_id', 0, true, '--Role--'); ?>
                            </div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Status</h3>
                            </div>
                            <div class="box-body">
                                <?php $this->Mconstants->selectConstants('status', 'status_id'); ?>
                            </div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Avatar</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php $avatar = (set_value('avatar')) ? set_value('avatar') : NO_IMAGE; ?>
                                    <img src="<?php echo USER_PATH.$avatar; ?>" class="chooseImage" id="imgAvatar" style="width: 50%;display: block;left: 0;right: 0;margin: auto;">
                                    <input type="text" hidden="hidden" name="avatar" id="avatar" value="<?php echo $avatar; ?>">
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
                    <li><a href="<?php echo base_url('sys-admin/staff'); ?>" class="btn btn-default" id="btnCancel">Cancel</a></li>
                    <input type="text" hidden="hidden" name="id" value="0">
                </ul>
                <?php echo form_close(); ?>
            </section>
        </div>
    
    </div>
<?php $this->load->view('backend/includes/footer'); ?>
<?php $this->load->view('backend/user/_lang'); ?>
