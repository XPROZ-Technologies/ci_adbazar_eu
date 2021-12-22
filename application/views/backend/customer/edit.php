<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Update</button></li>
                    <li><a href="<?php echo base_url('sys-admin/customer'); ?>" class="btn btn-default">Cancel</a></li>
                </ul>
            </section>
            <section class="content">
            <?php if($id > 0){ ?>
                <?php echo form_open('sys-admin/customer/insert-update', array('id' => 'customerForm')); ?>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">First Name <span class="required">*</span></label>
                                        <input type="text" name="customer_first_name" class="form-control hmdrequired" data-field="First Name" autocomplete="off" value="<?php echo $customer['customer_first_name']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Last Name <span class="required">*</span></label>
                                        <input type="text" name="customer_last_name" class="form-control hmdrequired" data-field="First Name" autocomplete="off" value="<?php echo $customer['customer_last_name']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Country code <span class="required">*</span></label>
                                        <select class="form-control" name="customer_phone_code" id="country_code_id">
                                            <?php if(isset($phonecode['id'])): ?>
                                            <option value="<?php echo $phonecode['id'] ?>"><?php echo $phonecode['country_name'].'  +'.$phonecode['phonecode']; ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Phone <span class="required">*</span></label>
                                        <input type="number" name="customer_phone" class="form-control hmdrequired" data-field="Phone" autocomplete="off" value="<?php echo $customer['customer_phone']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Email <span class="required">*</span></label>
                                        <input type="text" name="customer_email" class="form-control hmdrequired" data-field="Email" autocomplete="off" value="<?php echo $customer['customer_email']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Occupation</label>
                                        <input type="text" name="customer_occupation" class="form-control" autocomplete="off" value="<?php echo $customer['customer_occupation']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Gender</label>
                                        <?php $this->Mconstants->selectConstants('genders', 'customer_gender_id', $customer['customer_gender_id'], true, '-- Gender --'); ?>
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
                                            <input type="text" class="form-control datepicker" name="customer_birthday" value="<?php echo ddMMyyyy($customer['customer_birthday']); ?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Address <span class="required">*</span></label>
                                        <input type="text" name="customer_address" class="form-control hmdrequired" data-field="Address" autocomplete="off" value="<?php echo $customer['customer_address']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Password </label>
                                        <input type="text" id="newPass" name="customer_password" class="form-control"autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Retype password</label>
                                        <input type="text" id="rePass" class="form-control" autocomplete="off">
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
                                <input type="checkbox" value="<?php echo $customer['free_trial']; ?>" class="js-switch" name="free_trial" <?php if($customer['free_trial'] == 2) echo ' checked disabled'; ?>/>
                            </div>
                        </div>
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Avatar</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <img src="<?php echo CUSTOMER_PATH.$customer['customer_avatar']; ?>" class="chooseImage" id="imgAvatar" style="width: 50%;display: block;left: 0;right: 0;margin: auto;">
                                    <input type="text" hidden="hidden" name="customer_avatar" id="avatar" value="<?php echo $customer['customer_avatar']; ?>">
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
                    <li><button class="btn btn-primary submit" type="button">Update</button></li>
                    <li><a href="<?php echo base_url('sys-admin/customer'); ?>" class="btn btn-default" id="btnCancel">Cancel</a></li>
                    <input type="text" hidden="hidden" id="urlGetPhoneCode" value="<?php echo base_url('sys-admin/phone-code/get-list') ?>">
                    <input type="text" hidden="hidden" name="id" value="<?php echo $customer['id']; ?>">
                </ul>
                <?php echo form_close(); ?>
            <?php } else { ?> 
                <?php $this->load->view('backend/includes/notice'); ?>
            <?php } ?>
            </section>
        </div>
    </div>
<?php $this->load->view('backend/includes/footer'); ?>
<script>
    var rePassText = "<?php echo 'Password does not match.' ?>"; 
    var phoneCode = "<?php echo 'Please select a phone code number.' ?>"; 
    var emailText = "<?php echo 'Invalid email' ?>"; 
</script>