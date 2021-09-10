<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><a href="<?php echo base_url('backend/user/add'); ?>" class="btn btn-primary">Add staff</a></li>
                </ul>
            </section>
            <section class="content">
                <div class="box box-default">
                    <?php sectionTitleHtml('Filter'); ?>
                    <div class="box-body row-margin">
                        <?php echo form_open('backend/service'); ?>
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <input type="text" name="search_text" class="form-control" value="<?php echo set_value('search_text'); ?>" placeholder="Service Name">
                            </div>
                            <div class="col-sm-2 form-group">
                                <?php $this->Mconstants->selectConstants('status', 'status_id', set_value('status_id'), true, '--Status--'); ?>
                            </div>
                            <div class="col-sm-4 form-group">
                                <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Search">
                                <input type="text" hidden="hidden" name="page_id" id="pageId" value="<?php echo set_value('page_id'); ?>">
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="box box-success">
                    <?php sectionTitleHtml($title, isset($paggingHtml) ? $paggingHtml : ''); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th style="width:120px;">Service Image</th>
                                <th>Service Name</th>
                                <th style="width:120px;">Status</th>
                                <th style="width:200px;">Action</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyService">
                            <?php $i = 0;
                             $labelCss = $this->Mconstants->labelCss;
                            foreach($listServices as $s){
                                $i++; ?>
                                <tr id="service_<?php echo $s['id']; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><img width="60px" src="<?php echo SERVICE_PATH.$s['service_image']; ?>"></td>
                                    <td><a href="<?php echo base_url('backend/service/edit/'.$s['id']); ?>"><?php echo $s['service_name']; ?></a></td>
                                    <td><span class="<?php echo $labelCss[$s['service_status_id']]; ?>"><?php echo $this->Mconstants->status[$s['service_status_id']]; ?></span></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_delete btn btn-xs btn-default" data-id="<?php echo $s['id']; ?>" status-id="0" title="Remove">Remove</a>
                                        <?php if($s['service_status_id'] == STATUS_ACTIVED){ 
                                        ?> 
                                            <a href="javascript:void(0)" class="link_deactive btn btn-xs btn-danger" data-id="<?php echo $s['id']; ?>" status-id="1" title="Deactive">Deactive</a>
                                        <?php } else { ?> 
                                            <a href="javascript:void(0)" class="link_active btn btn-xs btn-success" data-id="<?php echo $s['id']; ?>" status-id="2" title="Active">Active</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php $this->load->view('backend/includes/pagging_footer'); ?>
                </div>
            </section>
        </div>
    </div>
    <input type="text" hidden="hidden" id="changeStatusUrl" value="<?php echo base_url('backend/service/changeStatus'); ?>">
<?php $this->load->view('backend/includes/footer'); ?>
<script>
    var removeText = "<?php echo 'Do you really want to delete ?' ?>";
    var deactiveText = "<?php echo 'You want to lock this service ?' ?>";
    var activeText = "<?php echo 'You want to activate this service ?' ?>";
</script>