<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php 
                $button = '<button class="btn btn-primary submit">Update</button>';
                $this->load->view('backend/includes/breadcrumb', array("button" => $button)); 
            ?>
            <section class="content">
                <?php echo form_open('backend/config/update/1', array('id' => 'configForm')); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Content header web</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Text Logo header <span class="required">*</span></label>
                                            <input type="text" class="form-control hmdrequired" name="TEXT_LOGO_HEADER" value="<?php echo $listConfigs['TEXT_LOGO_HEADER']; ?>" data-field="Text Logo đầu trang">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" style="width: 100%;">Logo header<button type="button" class="btn btn-box-tool" id="btnUpLogoHeader"><i class="fa fa-upload"></i> Chọn hình</button></label>
                                            <img src="<?php echo CONFIG_PATH.$listConfigs['LOGO_IMAGE_HEADER']; ?>" id="imgLogoHeader" style="width: 50%;">
                                            <input type="text" hidden="hidden" id="logoImageHeader" name="LOGO_IMAGE_HEADER" value="<?php echo $listConfigs['LOGO_IMAGE_HEADER']; ?>">
                                            <input type="file" style="display: none;" id="logoFileImageHeader">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Content footer web</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Facebook Url <span class="required">*</span></label>
                                            <input type="text" class="form-control hmdrequired" name="FACEBOOK_URL" value="<?php echo $listConfigs['FACEBOOK_URL']; ?>" data-field="Facebook Url">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Youtube Url <span class="required">*</span></label>
                                            <input type="text" class="form-control hmdrequired" name="YOUTUBE_URL" value="<?php echo $listConfigs['YOUTUBE_URL']; ?>" data-field="Youtube Url">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Content Coupons</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" style="width: 100%;">Coupons Image<button type="button" class="btn btn-box-tool" id="btnCoupons"><i class="fa fa-upload"></i> Choose image</button></label>
                                            <img src="<?php echo CONFIG_PATH.$listConfigs['COUPON_IMAGE']; ?>" id="imgCoupons" style="width: 50%;">
                                            <input type="text" hidden="hidden" id="logoImageCoupons" name="COUPON_IMAGE" value="<?php echo $listConfigs['COUPON_IMAGE']; ?>">
                                            <input type="file" style="display: none;" id="logoFileCoupons">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Content video</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Video Url <span class="required">*</span></label>
                                            <input type="text" class="form-control hmdrequired" name="VIDEO_URL" value="<?php echo $listConfigs['VIDEO_URL']; ?>" data-field="Video Url">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Content ABOUT US</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" style="width: 100%;">ABOUT US Image<button type="button" class="btn btn-box-tool" id="btnAboutUs"><i class="fa fa-upload"></i> Choose image</button></label>
                                            <img src="<?php echo CONFIG_PATH.$listConfigs['ABOUT_US_IMAGE']; ?>" id="imgAboutUs" style="width: 50%;">
                                            <input type="text" hidden="hidden" id="logoImageAboutUs" name="ABOUT_US_IMAGE" value="<?php echo $listConfigs['ABOUT_US_IMAGE']; ?>">
                                            <input type="file" style="display: none;" id="logoFileAboutUs">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Content Contact Us</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label" style="width: 100%;">ABOUT US Image<button type="button" class="btn btn-box-tool" id="btnContactUs"><i class="fa fa-upload"></i> Choose image</button></label>
                                            <img src="<?php echo CONFIG_PATH.$listConfigs['CONTACT_US_IMAGE']; ?>" id="imgContactUs" style="width: 50%;">
                                            <input type="text" hidden="hidden" id="logoImageContactUs" name="CONTACT_US_IMAGE" value="<?php echo $listConfigs['CONTACT_US_IMAGE']; ?>">
                                            <input type="file" style="display: none;" id="logoFileContactUs">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-inline pull-right margin-right-10">
                        <li><input class="btn btn-primary submit" type="submit" name="submit" value="Update"></li>
                        <input type="text" hidden="hidden" id="autoLoad" value="1">
                        <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/upload'); ?>">
                    </ul>
                </div>
                <?php echo form_close(); ?>
            </section>
        </div>
    </div>
<?php $this->load->view('backend/includes/footer'); ?>