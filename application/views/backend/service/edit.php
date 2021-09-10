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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Service name <span class="required">*</span></label>
                                        <input type="text" name="service_name" id="service_name" class="form-control hmdrequired" data-field="Service name" autocomplete="off" value="<?php echo $service['service_name'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Display order <span class="required">*</span></label>
                                        <?php $this->Mconstants->selectNumber(0, 100, 'display_order', $service['display_order'], true); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Display order <span class="required">*</span></label>
                                        <?php $this->Mconstants->selectConstants('status', 'service_status_id', $service['service_status_id']); ?>
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
                                        <th>Service type</th>
                                        <th>Display order</th>
                                        <th style="width: 60px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyServiceTypes">
                                        <?php foreach($serviceTypes as $st): ?>
                                            <tr class="htmlServiceTypes">
                                                <td><?php echo $st['service_type_name'] ?></td>
                                                <td><?php echo $st['display_order'] ?></td>
                                                <td service-type-id="<?php echo $st['id'] ?>">
                                                    <a href="javascript:void(0)" class="link_edit" title="Update"><i class="fa fa-pencil"></i></a>&nbsp;
                                                    <?php if(empty($st['service_type_id'])): ?>
                                                    <a href="javascript:void(0)" class="link_delete" title="Delete"><i class="fa fa-times"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    	<tr id="trData">
                                            <td>
                                                <input type="text" name="service_type_name" id="service_type_name" class="form-control">
                                            </td>
                                    		<td>
                                                <?php $this->Mconstants->selectNumber(0, 100, 'display_order_0', 1, true); ?>
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
