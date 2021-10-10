<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Update</button></li>
                    <li><a href="<?php echo base_url('sys-admin/business-profile'); ?>" class="btn btn-default">Cancel</a></li>
                </ul>
            </section>
            <section class="content">
            <?php if($id > 0){ ?>
                <?php echo form_open('sys-admin/business-profile/insert-update', array('id' => 'businessProfileForm')); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Customer Name <span class="required">*</span></label>
                                        <select class="form-control" name="customer_id" id="customer_id">
                                            <?php if(isset($customer['id']) && $customer['id'] > 0): ?>
                                            <option value="<?php echo $customer['id'] ?>"><?php echo $customer['customer_first_name'].' '.$customer['customer_last_name']; ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Business Name <span class="required">*</span></label>
                                        <input type="text" name="business_name" id="business_name" class="form-control hmdrequired" data-field="Business Name" autocomplete="off" value="<?php echo $profile['business_name'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Slogan <span class="required">*</span></label>
                                        <input type="text" name="business_slogan" class="form-control hmdrequired" data-field="Slogan" autocomplete="off" value="<?php echo $profile['business_slogan'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Business Email <span class="required">*</span></label>
                                        <input type="text" name="business_email" id="business_email" class="form-control hmdrequired" data-field="Business Email" autocomplete="off" value="<?php echo $profile['business_email'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Business Address <span class="required">*</span></label>
                                        <input type="text" name="business_address" class="form-control hmdrequired" data-field="Business Address" autocomplete="off" value="<?php echo $profile['business_address'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Custom URL <span class="required">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default"><?php echo base_url(BUSINESS_PROFILE_URL); ?></button>
                                            </div>
                                            <input type="text" name="business_url" class="form-control" id="business_url" value="<?php echo $profile['business_url'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Country code <span class="required">*</span></label>
                                        <select class="form-control" name="country_code_id" id="country_code_id"> 
                                            <?php if(isset($phonecode['id']) && $phonecode['id'] > 0): ?>
                                                <option value="<?php echo $phonecode['id'] ?>"><?php echo $phonecode['country_name'].'  +'.$phonecode['phonecode']; ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Phone number <span class="required">*</span></label>
                                        <input type="number" name="business_phone" class="form-control hmdrequired" data-field="Phone number" autocomplete="off" value="<?php echo $profile['business_phone'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">WhatsApp number <span class="required">*</span></label>
                                        <input type="number" name="business_whatsapp" class="form-control hmdrequired" data-field="WhatsApp number" autocomplete="off" value="<?php echo $profile['business_whatsapp'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" rows="4" name="business_description"><?php echo $profile['business_description'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Type of service <span class="required">*</span></label>
                                        <select class="form-control" name="service_id" id="serviceId">
                                            <option value="<?php echo $service['id'] ?>"><?php echo $service['service_name_en']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Sub-categories <span class="required">*</span></label>
                                        <select class="form-control" id="businessServiceTypeIds" name="business_service_type_ids" multiple>
                                            <?php foreach($servicetypes as $c){ ?>
                                                <option value="<?php echo $c['id'] ?>" <?php if(in_array($c['id'], $businessservicetypes)) echo ' selected="selected"'; ?>><?php echo $c['service_type_name_en']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label" style="width: 100%;">Business Avatar<button type="button" class="btn btn-box-tool" id="btnAvatar"><i class="fa fa-upload"></i> Choose image</button></label>
                                        <img src="<?php echo BUSINESS_PROFILE_PATH.$profile['business_avatar']; ?>" id="imgAvatar" style="width: 240px;">
                                        <input type="text" hidden="hidden" id="logoImageAvatar" name="business_avatar" value="<?php echo BUSINESS_PROFILE_PATH.$profile['business_avatar']; ?>">
                                        <input type="file" style="display: none;" id="logoFileAvatar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label" style="width: 100%;">Business Image Cover<button type="button" class="btn btn-box-tool" id="btnCover"><i class="fa fa-upload"></i> Choose image</button></label>
                                        <img src="<?php echo BUSINESS_PROFILE_PATH.$profile['business_image_cover']; ?>" id="imgCover" style="width: 240px;">
                                        <input type="text" hidden="hidden" id="logoImageCover" name="business_image_cover" value="<?php echo BUSINESS_PROFILE_PATH.$profile['business_image_cover']; ?>">
                                        <input type="file" style="display: none;" id="logoFileCover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <?php 
                                $locationName = ''; $locationId = 0; $expiredDate = ''; $businessProfileLocationId = 0;
                                if(!empty($businessInLocation)) {
                                    $locationName = $businessInLocation['location_name'];
                                    $locationId = $businessInLocation['id']; 
                                    $expiredDate = ddMMyyyy($businessInLocation['expired_date'], 'd/m/Y H:i');
                                    $businessProfileLocationId = $businessInLocation['business_profile_location_id'];
                                }
                            ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Location Name</label>
                                            <select class="form-control" name="location_id" id="location_id"> 
                                                <option value="<?php echo $locationId ?>"><?php echo $locationName; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Expired Date</label>
                                            <input type="text" name="expired_date" id="expired_date" class="form-control" value="<?php echo $expiredDate ?>">
                                            <input type="hidden" name="business_profile_location_id" value="<?php echo $businessProfileLocationId ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Opening hour <span class="required">*</span></h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php foreach($openinghours as $oh): ?>
                                    <div class="row opening_hour">
                                        <div class="col-sm-2 form-group">
                                            <label class="control-label"><?php echo $this->Mconstants->dayIds[$oh['day_id']]; ?></label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" value="<?php echo $oh['opening_hours_status_id'] ?>" day-id="<?php echo $oh['day_id'] ?>" name="opening_hours_status_id" class="js-switch" <?php if($oh['opening_hours_status_id'] == '2') echo ' checked'; ?>/>
                                            <span id="textDay_<?php echo $oh['day_id'] ?>"><?php echo $oh['opening_hours_status_id'] == 2 ? 'Open':'Close';  ?></span>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                <input type="text" class="form-control datetimepicker-start" name="start_time" id="start_time_<?php echo $oh['day_id'] ?>" placeholder="Close at" <?php echo $oh['opening_hours_status_id'] == 1 ? 'readonly':'';  ?> value="<?php echo !empty($oh['start_time']) ? ddMMyyyy($oh['start_time'], 'H:i'): ''; ?>">
                                                </div>
                                                <div class="col-sm-2" style="top: 7px;text-align: center;"><span>To</span></div>
                                                <div class="col-sm-5">
                                                <input type="text" class="form-control datetimepicker-end" name="end_time" id="end_time_<?php echo $oh['day_id'] ?>" placeholder="Close at" <?php echo $oh['opening_hours_status_id'] == 1 ? 'readonly':'';  ?> value="<?php echo !empty($oh['end_time']) ? ddMMyyyy($oh['end_time'], 'H:i'): ''; ?>">
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="day_id" value="<?php echo $oh['day_id'] ?>">
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Photo</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" id="btnUpImage"><i class="fa fa-upload"></i> Choose photo</button>
                                </div>
                            </div>
                            <div class="box-body">
                                <ul class="list-inline" id="ulImages">
                                    <?php foreach($businessphotos as $img){ ?>
                                        <li><a href="<?php echo BUSINESS_PROFILE_PATH.$img['photo_image']; ?>" target="_blank"><img src="<?php echo BUSINESS_PROFILE_PATH.$img['photo_image']; ?>" style="width:80px!important"></a><i class="fa fa-times"></i></li>
                                    <?php } ?>
                                </ul>
                                <img src="" style="display: none;" id="photoImage">
                                <input type="file" style="display: none;" id="inputFileImage">
                            </div>
                        </div>

                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Video Youtube</h3>
                                
                            </div>
                            <div class="box-body">
                            <table class="table table-hover table-bordered">
                                    <thead class="theadNormal">
                                    <tr>
                                        <th>Link Youtube</th>
                                        <th style="width: 60px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyYoutube">
                                        <?php foreach($businessvideos as $v): ?>
                                            <tr class="htmlYoutube">
                                                <td><input class="form-control" name="video_url" value="<?php echo $v['video_url'] ?>"></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="link_play" title="Play" video-code="<?php echo $v['video_code'] ?>"><i class="fa fa-youtube-play"></i></a>
                                                    <a href="javascript:void(0)" class="link_delete" title="Delete"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    	<tr id="trData">
                                            <td>
                                                <input type="text" class="form-control" id="linkYoutube">
                                            </td>
                                    		<td class="actions" service-type-id="0">
                                                <a href="javascript:void(0)" id="link_add" title="Cập nhật"><i class="fa fa-save"></i></a>&nbsp;
                                                <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                            </td>
                                    	</tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <ul class="list-inline pull-right margin-right-10">
                    <li><button class="btn btn-primary submit" type="button">Update</button></li>
                    <li><a href="<?php echo base_url('sys-admin/business-profile'); ?>" class="btn btn-default" id="btnCancel">Cancel</a></li>
                    <input type="text" hidden="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="text" hidden="hidden" id="urlGetCustomer" value="<?php echo base_url('sys-admin/customer/get-list') ?>">
                    <input type="text" hidden="hidden" id="urlGetService" value="<?php echo base_url('sys-admin/service/get-list') ?>">
                    <input type="text" hidden="hidden" id="urlGetServiceType" value="<?php echo base_url('sys-admin/service/get-list-service-type') ?>">
                    <input type="text" hidden="hidden" id="urlGetPhoneCode" value="<?php echo base_url('sys-admin/phone-code/get-list') ?>">
                    <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/upload'); ?>">
                    <input type="text" hidden="hidden" id="urlGetLocationNotInBusinessProfile" value="<?php echo base_url('sys-admin/location/get-location-not-in-business-profile') ?>">
                </ul>
                <?php echo form_close(); ?>
            <?php } else { ?> 
                <?php $this->load->view('backend/includes/notice'); ?>
            <?php } ?>
            </section>    
        </div> 
    </div>
    <?php $this->load->view('backend/business_profile/_common'); ?>
<?php $this->load->view('backend/includes/footer'); ?>
