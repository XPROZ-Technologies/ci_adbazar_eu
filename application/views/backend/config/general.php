<?php $this->load->view('backend/includes/header'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php
        $button = '<button class="btn btn-primary submit">Update</button>';
        $this->load->view('backend/includes/breadcrumb', array("button" => $button));
        ?>
        <section class="content">
            <?php echo form_open('sys-admin/config/update/1', array('id' => 'configForm')); ?>
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
                                        <img src="<?php echo CONFIG_PATH . $listConfigs['LOGO_IMAGE_HEADER']; ?>" id="imgLogoHeader" style="width: 80px;">
                                        <input type="text" hidden="hidden" id="logoImageHeader" name="LOGO_IMAGE_HEADER" value="<?php echo $listConfigs['LOGO_IMAGE_HEADER']; ?>">
                                        <input type="file" style="display: none;" id="logoFileImageHeader">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="box box-default padding15">
                        <div class="box-header with-border">
                            <h3 class="box-title">Icon map</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label" style="width: 100%;">Marker Image<button type="button" class="btn btn-box-tool" id="btnMarkerMap"><i class="fa fa-upload"></i> Choose image</button></label>
                                        <img src="<?php echo CONFIG_PATH . $listConfigs['MARKER_MAP_IMAGE']; ?>" id="imgMarkerMap" style="width: 32px;">
                                        <input type="text" hidden="hidden" id="logoImageMarkerMap" name="MARKER_MAP_IMAGE" value="<?php echo $listConfigs['MARKER_MAP_IMAGE']; ?>">
                                        <input type="file" style="display: none;" id="logoFileMarkerMap">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-default padding15">
                        <!-- EN -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Home Banner Text - EN</h3>
                        </div>
                        <div class="box-body">
                            <textarea class="form-control" name="HOME_BANNER_TEXT"><?php echo $listConfigs['HOME_BANNER_TEXT']; ?></textarea>
                        </div>
                        <!-- VI -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Home Banner Text- VI</h3>
                        </div>
                        <div class="box-body">
                            <textarea class="form-control" name="HOME_BANNER_TEXT_VI"><?php echo $listConfigs['HOME_BANNER_TEXT_VI']; ?></textarea>
                        </div>
                        <!-- DE -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Home Banner Text - DE</h3>
                        </div>
                        <div class="box-body">
                            <textarea class="form-control" name="HOME_BANNER_TEXT_DE"><?php echo $listConfigs['HOME_BANNER_TEXT_DE']; ?></textarea>
                        </div>
                        <!-- VZ -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Home Banner Text - CZ</h3>
                        </div>
                        <div class="box-body">
                            <textarea class="form-control" name="HOME_BANNER_TEXT_CZ"><?php echo $listConfigs['HOME_BANNER_TEXT_CZ']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-default padding15">
                        <div class="box-header with-border">
                            <h3 class="box-title">Event Banner Text</h3>
                        </div>
                        <div class="box-body">
                            <textarea class="form-control" name="EVENT_BANNER_TEXT"><?php echo $listConfigs['EVENT_BANNER_TEXT']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-default padding15">
                        <div class="box-header with-border">
                            <h3 class="box-title">Admin Email</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Phone number <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="NOTIFICATION_EMAIL_ADMIN" value="<?php echo $listConfigs['NOTIFICATION_EMAIL_ADMIN']; ?>" data-field="Phone number">
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
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Phone number <span class="required">*</span></label>
                                                <input type="text" class="form-control hmdrequired" name="PHONE_NUMBER_FOOTER" value="<?php echo $listConfigs['PHONE_NUMBER_FOOTER']; ?>" data-field="Phone number">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Email <span class="required">*</span></label>
                                                <input type="text" class="form-control hmdrequired" name="EMAIL_FOOTER" value="<?php echo $listConfigs['EMAIL_FOOTER']; ?>" data-field="Email">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Address <span class="required">*</span></label>
                                                <input type="text" class="form-control hmdrequired" name="ADDRESS_FOOTER" value="<?php echo $listConfigs['ADDRESS_FOOTER']; ?>" data-field="Address">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label" style="width: 100%;">Logo footer<button type="button" class="btn btn-box-tool" id="btnLogoFooter"><i class="fa fa-upload"></i> Choose image</button></label>
                                                <img src="<?php echo CONFIG_PATH . $listConfigs['LOGO_FOOTER_IMAGE']; ?>" id="imgLogoFooter" style="width: 50%;">
                                                <input type="text" hidden="hidden" id="logoImageLogoFooter" name="LOGO_FOOTER_IMAGE" value="<?php echo $listConfigs['LOGO_FOOTER_IMAGE']; ?>">
                                                <input type="file" style="display: none;" id="logoFileLogoFooter">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Facebook Url <span class="required">*</span></label>
                                                <input type="text" class="form-control hmdrequired" name="FACEBOOK_URL" value="<?php echo $listConfigs['FACEBOOK_URL']; ?>" data-field="Facebook Url">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Instagram Url <span class="required">*</span></label>
                                                <input type="text" class="form-control hmdrequired" name="INSTAGRAM_URL" value="<?php echo $listConfigs['INSTAGRAM_URL']; ?>" data-field="Instagram Url">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Tiktok Url <span class="required">*</span></label>
                                                <input type="text" class="form-control hmdrequired" name="TIKTOK_URL" value="<?php echo $listConfigs['TIKTOK_URL']; ?>" data-field="Tiktok Url">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Twitter Url <span class="required">*</span></label>
                                                <input type="text" class="form-control hmdrequired" name="TWITTER_URL" value="<?php echo $listConfigs['TWITTER_URL']; ?>" data-field="Twitter Url">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label">Pinterest Url <span class="required">*</span></label>
                                                <input type="text" class="form-control hmdrequired" name="PINTEREST_URL" value="<?php echo $listConfigs['PINTEREST_URL']; ?>" data-field="Pinterest Url">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-default padding15" style="height: 461px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">Content Contact Us</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label" style="width: 100%;">ABOUT US Image<button type="button" class="btn btn-box-tool" id="btnContactUs"><i class="fa fa-upload"></i> Choose image</button></label>
                                        <img src="<?php echo CONFIG_PATH . $listConfigs['CONTACT_US_IMAGE']; ?>" id="imgContactUs" style="width: 280px;">
                                        <input type="text" hidden="hidden" id="logoImageContactUs" name="CONTACT_US_IMAGE" value="<?php echo $listConfigs['CONTACT_US_IMAGE']; ?>">
                                        <input type="file" style="display: none;" id="logoFileContactUs">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-default padding15">
                        <div class="box-header with-border">
                            <h3 class="box-title">Content Service</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label" style="width: 100%;">Service Image<button type="button" class="btn btn-box-tool" id="btnCoupons"><i class="fa fa-upload"></i> Choose image</button></label>
                                        <img src="<?php echo CONFIG_PATH . $listConfigs['SERVICE_IMAGE']; ?>" id="imgCoupons" style="width: 50%;">
                                        <input type="text" hidden="hidden" id="logoImageCoupons" name="SERVICE_IMAGE" value="<?php echo $listConfigs['SERVICE_IMAGE']; ?>">
                                        <input type="file" style="display: none;" id="logoFileCoupons">
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
                    <input type="text" hidden="hidden" id="aboundId" value="0">
                </ul>
            </div>
            <?php echo form_close(); ?>
        </section>
    </div>
</div>
<?php $this->load->view('backend/includes/footer'); ?>