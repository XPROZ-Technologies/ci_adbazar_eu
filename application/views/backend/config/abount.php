<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <?php 
                $button = '<button type="submit" class="btn btn-primary submit">Update</button>';
                $this->load->view('backend/includes/breadcrumb', array("button" => $button)); 
            ?>
            <section class="content">
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h3 class="box-title">Content about us</h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <?php echo form_open('sys-admin/config/change-language-abount', array('id' => 'languageForm')); ?>
                                                <select class="form-control" name="language_id" id="languageId" onchange="this.form.submit()">
                                                    <?php foreach($this->Mconstants->languageIds as $k => $item): ?>
                                                        <option value="<?php echo $k ?>"  <?php echo $configAbountUs['language_id'] == $k ? 'selected':''; ?>><?php echo $item; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <input type="hidden" name="UrlOld" value="<?php echo $this->uri->uri_string(); ?>"/>
                                                <input type="submit" hidden="hidden" name="" value=""/>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_open('sys-admin/config/update/1', array('id' => 'configForm')); ?>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label class="control-label" style="width: 100%;">About us image banner<button type="button" class="btn btn-box-tool" id="btnUpAboutUsImageBanner"><i class="fa fa-upload"></i> Chọn hình</button></label>
                                        <img src="<?php echo CONFIG_PATH.$listConfigs['ABOUT_US_IMAGE_BANNER']; ?>" id="imgAboutUsImageBanner" style="width: 80px;">
                                        <input type="text" hidden="hidden" id="logoAboutUsImageBanner" name="ABOUT_US_IMAGE_BANNER" value="<?php echo $listConfigs['ABOUT_US_IMAGE_BANNER']; ?>">
                                        <input type="file" style="display: none;" id="logoFileAboutUsImageBanner">
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" style="width: 100%;">About us image content 1<button type="button" class="btn btn-box-tool" id="btnUpAboutUsImage1"><i class="fa fa-upload"></i> Chọn hình</button></label>
                                                <img src="<?php echo CONFIG_PATH.$listConfigs['ABOUT_US_CHILD_IMAGE_1']; ?>" id="imgAboutUsImage1" style="width: 80px;">
                                                <input type="text" hidden="hidden" id="logoAboutUsImage1" name="ABOUT_US_CHILD_IMAGE_1" value="<?php echo $listConfigs['ABOUT_US_CHILD_IMAGE_1']; ?>">
                                                <input type="file" style="display: none;" id="logoFileAboutUsImage1">
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="control-label">About us content 1</label>
                                                <textarea class="form-control" name="ABOUT_US_CHILD_TEXT_1" rows="10"><?php echo $listConfigs['ABOUT_US_CHILD_TEXT_1']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <label class="control-label">About us content 2</label>
                                                <textarea class="form-control" name="ABOUT_US_CHILD_TEXT_2" rows="10"><?php echo $listConfigs['ABOUT_US_CHILD_TEXT_2']; ?></textarea>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label" style="width: 100%;">About us image content 2<button type="button" class="btn btn-box-tool" id="btnUpAboutUsImage2"><i class="fa fa-upload"></i> Chọn hình</button></label>
                                                <img src="<?php echo CONFIG_PATH.$listConfigs['ABOUT_US_CHILD_IMAGE_2']; ?>" id="imgAboutUsImage2" style="width: 80px;">
                                                <input type="text" hidden="hidden" id="logoAboutUsImage2" name="ABOUT_US_CHILD_IMAGE_2" value="<?php echo $listConfigs['ABOUT_US_CHILD_IMAGE_2']; ?>">
                                                <input type="file" style="display: none;" id="logoFileAboutUsImage2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="control-label">About us</label>
                                        <textarea class="form-control" name="ABOUT_US_TEXT" rows="10"><?php echo $listConfigs['ABOUT_US_TEXT']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-inline pull-right margin-right-10">
                        <li><input class="btn btn-primary submit" type="submit" name="submit" value="Update"></li>
                        <input type="text" hidden="hidden" id="autoLoad" value="1">
                        <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/upload'); ?>">
                        <input type="text" hidden="hidden" id="aboundId" value="1">
                    </ul>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('backend/includes/footer'); ?>