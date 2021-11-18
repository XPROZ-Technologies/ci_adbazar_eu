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
                                <h3 class="box-title">Video</h3>
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
                                    <div class="col-sm-12">
                                    <input type="text" class="form-control hmdrequired" name="VIDEO_URL" value="<?php echo $listConfigs['VIDEO_URL']; ?>" data-field="Video Url">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-inline pull-right margin-right-10">
                        <li><input class="btn btn-primary submit" type="submit" name="submit" value="Update"></li>
                        <input type="text" hidden="hidden" id="autoLoad" value="1">
                        <input type="text" hidden="hidden" id="aboundId" value="1">
                        <input type="text" hidden="hidden" id="general" value="0">
                    </ul>
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('backend/includes/footer'); ?>