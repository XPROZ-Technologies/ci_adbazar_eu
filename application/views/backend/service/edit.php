<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><button class="btn btn-primary submit">Update</button></li>
                    <li><a href="<?php echo base_url('backend/service'); ?>" class="btn btn-default">Cancel</a></li>
                </ul>
            </section>
            <section class="content">
            <?php if($id > 0){ ?>
                <?php echo form_open('backend/service/update', array('id' => 'serviceForm')); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h2 class="box-title">Service</h2>
                            </div>
                            <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Service name <span class="required">*</span></label>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <?php foreach($this->Mconstants->languageTexts as $key => $text): ?>
                                            <li class="<?php echo $key == 'en' ? 'active':''; ?>">
                                                <a href="#service-name-<?php echo $key ?>-tab" role="tab" data-toggle="tab"><?php echo $text ?></a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <!-- Tab panes -->
                                        <br>
                                        <div class="tab-content">
                                            <?php foreach($this->Mconstants->languageTexts as $key => $text): ?>
                                            <div class="tab-pane fade <?php echo $key == 'en' ? 'active':''; ?> in" id="service-name-<?php echo $key ?>-tab">
                                                <div class="form-group">
                                                    <input type="text" name="service_name_<?php echo $key ?>" id="service_name_<?php echo $key ?>" class="form-control hmdrequired" value="<?php echo $service['service_name_'.$key.''] ?>" data-field="Service Name <?php echo $text ?>" autocomplete="off">
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Display order <span class="required">*</span></label>
                                        <?php $this->Mconstants->selectNumber(0, 100, 'display_order', $service['display_order'], true); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Status <span class="required">*</span></label>
                                        <?php $this->Mconstants->selectConstants('status', 'service_status_id', $service['service_status_id']); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Highlights</label>
                                        <?php $this->Mconstants->selectConstants('isHot', 'is_hot', $service['is_hot']); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Service image <span class="required">*</span></label>
                                        <?php $avatar = $service['service_image'] ? $service['service_image'] : NO_IMAGE; ?>
                                        <img src="<?php echo SERVICE_PATH.$avatar; ?>" class="chooseImage" id="imgAvatar" style="width: 50%;display: block;left: 0;right: 0;margin: auto;">
                                        <input type="text" hidden="hidden" name="service_image" id="service_image" value="<?php echo $avatar; ?>">
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
                    </div>
                    <div class="col-sm-6">
                        <div class="box box-default padding15">
                            <div class="box-header with-border">
                                <h2 class="box-title">Service type</h2>
                            </div>
                            <div class="box-body">
                                <table class="table table-hover table-bordered">
                                    <thead class="theadNormal">
                                    <tr>
                                        <th>
                                            <div class="text-center">
                                                <span>Service type</span>
                                            </div>
                                            <ul class="nav nav-tabs" role="tablist">
                                                <?php foreach($this->Mconstants->languageTexts as $key1 => $text): ?>
                                                <li class="service_type_title_all service_type_title_<?php echo $key1; ?> <?php echo $key1 == 'en' ? 'active':''; ?>">
                                                    <a href=".service-type-name-<?php echo $key1 ?>-tab" role="tab" data-toggle="tab"><?php echo $text ?></a>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </th>
                                        <th>Display order</th>
                                        <th style="width: 60px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyServiceTypes">
                                        <?php foreach($serviceTypes as $st): ?>
                                            <tr class="htmlServiceTypes">
                                                <td>
                                                <div class="tab-content">
                                                    <?php foreach($this->Mconstants->languageTexts as $key2 => $text): ?>
                                                        <div class="tab-pane fade <?php echo $key2 == 'en' ? 'active':''; ?> service_type_title_all_content in service-type-name-<?php echo $key2; ?>-tab" data-key="<?php echo $key2; ?>">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control service_type_name_text_<?php echo $key2; ?>" readonly value="<?php echo $st['service_type_name_'.$key2]; ?>">
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                </td>
                                                <td><?php echo $st['display_order'] ?></td>
                                                <td service-type-id="<?php echo $st['id'] ?>">
                                                    <a href="javascript:void(0)" class="link_edit"  status-id="<?php echo  $st['status_id'] ?>" service-type-id="<?php echo  $st['id'] ?>" title="Update"><i class="fa fa-pencil"></i></a>&nbsp;
                                                    <?php if(empty($st['service_type_id'])): ?>
                                                    <a href="javascript:void(0)" status-id="<?php echo  $st['status_id'] ?>" class="link_delete" title="Delete"><i class="fa fa-times"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    	<tr id="trData">
                                            <td>
                                                <div class="tab-content">
                                                    <?php foreach($this->Mconstants->languageTexts as $key2 => $text): ?>
                                                    <div class="service_type_name tab-pane fade <?php echo $key2 == 'en' ? 'active':''; ?> in service-type-name-<?php echo $key2 ?>-tab" data-key="<?php echo $key2 ?>">
                                                        <div class="form-group">
                                                            <input type="text" name="service_type_name_<?php echo $key2 ?>" id="service_type_name_<?php echo $key2 ?>" class="form-control clearAllText" data-field="Service Type Name <?php echo $text ?>" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </td>
                                    		<td>
                                                <?php $this->Mconstants->selectNumber(0, 100, 'display_order_0', 1, true); ?>
                                    		</td>
                                    		<td class="actions" service-type-id="0">
                                                <a href="javascript:void(0)" id="link_add"  status-id="0" title="Cập nhật"><i class="fa fa-save"></i></a>&nbsp;
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
                    <li><a href="<?php echo base_url('backend/service'); ?>" class="btn btn-default" id="btnCancel">Cancel</a></li>
                    <input type="text" hidden="hidden" name="id" value="<?php echo $id; ?>">
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
    var serviceTypeNameText = "<?php echo 'Please enter the name of the service type.'; ?>";
</script>
