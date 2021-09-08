<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header">
                <h1><?php echo $title; ?></h1>
            </section>
            <section class="content">
                <div class="box box-success">
                    
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th style="width:120px">Display order</th>
                                <th>Image <span class="required">*</span></th>
                                <th>URL</th>
                                <th style="width:100px">Action</th>
                            </tr>
                            </thead>
                            <tbody id="tbodySlider">
                            <?php
                            foreach($listSliders as $key => $bt){ ?>
                                <tr id="slider_<?php echo $bt['id']; ?>">
                                    <td class="text-center" id='display_order_<?php echo $bt['id']; ?>'><?php echo $bt['display_order']; ?></td>
                                    <td id="image_<?php echo $bt['id']; ?>"><img width="60" src="<?php echo SLIDER_PATH.$bt['slider_image']; ?>"/></td>
                                    <td id="sliderUrl_<?php echo $bt['id']; ?>"><?php echo $bt['slider_url']; ?></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_edit" url-image="<?php echo SLIDER_PATH.$bt['slider_image']; ?>" data-id="<?php echo $bt['id']; ?>" title="Sửa"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" data-id="<?php echo $bt['id']; ?>" title="Xóa"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php echo form_open('backend/slider/update', array('id' => 'sliderForm')); ?>
                            <tr>
                                <td><?php $this->Mconstants->selectNumber(0, 100, 'display_order', 1, true); ?></td>
                                <td>
                                    <div class="form-group">
                                        <?php $avatar = NO_IMAGE; ?>
                                        <img src="<?php echo SLIDER_PATH.$avatar; ?>" class="chooseImage" id="imgImage" style="width: 60px;display: block;">
                                        <input type="text" hidden="hidden" name="slider_image" id="image" value="<?php echo $avatar; ?>">
                                    </div>
                                    <div class="progress" id="fileProgress" style="display: none;">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <input type="file" style="display: none;" id="inputFileImage">
                                    <input type="text" hidden="hidden" id="uploadFileUrl" value="<?php echo base_url('common/file/upload'); ?>">
                                </td>
                                <td><input type="text" class="form-control" id="sliderUrl" name="slider_url" value="" data-field="Url"></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" id="link_update" title="Cập nhật"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" id="link_cancel" title="Thôi"><i class="fa fa-times"></i></a>
                                    <input type="text" name="id" id="sliderId" value="0" hidden="hidden">
                                    <input type="text" id="deleteUrl" value="<?php echo base_url('backend/slider/delete'); ?>" hidden="hidden">
                                </td>
                            </tr>
                            <?php echo form_close(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('backend/includes/footer'); ?>
<script>
    var imageText = "<?php echo 'Please select an image.' ?>";
    var removeText = "<?php echo 'Do you really want to delete ?' ?>";
</script>