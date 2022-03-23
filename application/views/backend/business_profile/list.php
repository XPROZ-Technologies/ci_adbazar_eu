<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
                <ul class="list-inline">
                    <li><a href="<?php echo base_url('sys-admin/business-profile-add'); ?>" class="btn btn-primary">Add Business Profile</a></li>
                </ul>
            </section>
            <section class="content">
                <div class="box box-default">
                    <?php sectionTitleHtml('Filter'); ?>
                    <div class="box-body row-margin">
                        <?php echo form_open('sys-admin/business-profile'); ?>
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
                                    <th>Business Name</th>
                                    <th>Customer Name</th>
                                    <th>Location Name</th>
                                    <th>Service Name</th>
                                    <th>Business Phone</th>
                                    <th>Business Whatsapp</th>
                                    <th>Business Address</th>
                                    <th style="width:120px;">Status</th>
                                    <th style="width:250px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyBusinessProfile">
                            <?php $i = 0;
                                $labelCss = $this->Mconstants->labelCss;
                                foreach($listProfiles as $s){
                                    $i++; 
                                    $fullName = $this->Mcustomers->getFieldValue(array('id' => $s['customer_id']), 'concat(customer_first_name, " ", customer_last_name)', '');
                                    $serviceName = $this->Mservices->getFieldValue(array('id' => $s['service_id']), 'service_name_en', '');

                                    $businessInLocation = $this->Mbusinessprofiles->getBusinessInLocation($s['id']);
                            ?>
                                <tr id="business_profile_<?php echo $s['id']; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><a href="<?php echo base_url('sys-admin/business-profile-update/'.$s['id']); ?>"><?php echo $s['business_name']; ?></a></td>
                                    <td><?php echo $fullName; ?></td>
                                    <td><?php echo isset($businessInLocation['location_name']) ? $businessInLocation['location_name']:''; ?></td>
                                    <td><?php echo $serviceName; ?></td>
                                    <td><?php echo $s['business_phone']; ?></td>
                                    <td><?php echo $s['business_whatsapp']; ?></td>
                                    <td><?php echo $s['business_address']; ?></td>
                                    <td><span class="<?php echo $labelCss[$s['business_status_id']]; ?>"><?php echo $this->Mconstants->status[$s['business_status_id']]; ?></span></td>
                                    <td class="actions">
                                        <input type="checkbox" value="<?php echo $s['is_hot']; ?>"  data-id="<?php echo $s['id']; ?>" class="js-switch"<?php if($s['is_hot'] == 2) echo ' checked'; ?>/>
                                        <a href="javascript:void(0)" class="link_delete btn btn-xs btn-default" data-id="<?php echo $s['id']; ?>" status-id="0" title="Remove">Remove</a>
                                        <?php if($s['business_status_id'] == STATUS_ACTIVED){ 
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
    <input type="text" hidden="hidden" id="changeStatusUrl" value="<?php echo base_url('sys-admin/business-profile/change-status'); ?>">
    <input type="text" hidden="hidden" id="updateIsHotUrl" value="<?php echo base_url('sys-admin/business-profile/is-hot'); ?>">
<?php $this->load->view('backend/includes/footer'); ?>
<script>
    var removeText = "<?php echo 'Do you really want to delete ?' ?>";
    var deactiveText = "<?php echo 'You want to lock this service ?' ?>";
    var activeText = "<?php echo 'You want to activate this service ?' ?>";
</script>