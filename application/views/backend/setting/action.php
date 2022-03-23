<?php $this->load->view('backend/includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content">
                <div class="box box-success">
                    <?php sectionTitleHtml($title); ?>
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table table-hover table-bordered" id="tblAction">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Menu</th>
                                <th>Url</th>
                                <th>Menu cha</th>
                                <th>Thứ tự</th>
                                <th>FontAwesome</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="tbodyActions">
                            <?php $i = 0;
                            $selectHtml = $this->Mactions->getParentActionHtml($listActiveActions);
                            foreach($listActiveActions as $act){
                                $i++;
                                $class = '';
                                if($act['action_level'] == 1) $class = ' class="danger"';
                                elseif($act['action_level'] == 2) $class = ' class="warning"'; ?>
                                <tr id="action_<?php echo $act['id']; ?>"<?php echo $class; ?>>
                                    <td><?php echo $i; ?></td>
                                    <td class="action-level-<?php echo $act['action_level']; ?>"><input type="text" class="form-control" id="actionName_<?php echo $act['id'] ?>" value="<?php echo $act['action_name']; ?>"/></td>
                                    <td><input type="text" class="form-control" id="actionUrl_<?php echo $act['id'] ?>" value="<?php echo $act['action_url']; ?>"/></td>
                                    <td><select class="form-control parent" id="parentActionId_<?php echo $act['id'] ?>" data-id="<?php echo $act['id'] ?>"><?php echo $selectHtml; ?></select></td>
                                    <td><?php $this->Mconstants->selectNumber(0, 100, 'DisplayOrder_'.$act['id'], $act['display_order'], true); ?></td>
                                    <td><input type="text" class="form-control" id="fontAwesome_<?php echo $act['id'] ?>" value="<?php echo $act['font_awesome']; ?>"/></td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" class="link_update" title="Cập nhật" data-id="<?php echo $act['id'] ?>"><i class="fa fa-save"></i></a>
                                        <a href="javascript:void(0)" class="link_delete" title="Xóa" data-id="<?php echo $act['id'] ?>"><i class="fa fa-times"></i></a>
                                        <input type="text" hidden="hidden" id="parent_<?php echo $act['id'] ?>" value="<?php echo empty($act['parent_action_id']) ? 0 : $act['parent_action_id']; ?>">
                                        <input type="text" hidden="hidden" id="level_<?php echo $act['id'] ?>" value="<?php echo $act['action_level']; ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr id="action_0">
                                <td><?php echo $i+1; ?></td>
                                <td class="action-level-1"><input type="text" class="form-control" id="actionName_0" value=""/></td>
                                <td><input type="text" class="form-control" id="actionUrl_0" value=""/></td>
                                <td><select class="form-control parent" id="parentActionId_0" data-id="0"><?php echo $selectHtml; ?></select></td>
                                <td><?php $this->Mconstants->selectNumber(0, 100, 'DisplayOrder_0', 1, true); ?></td>
                                <td><input type="text" class="form-control" id="fontAwesome_0" value=""/></td>
                                <td class="actions">
                                    <a href="javascript:void(0)" class="link_update" title="Cập nhật" data-id="0"><i class="fa fa-save"></i></a>
                                    <a href="javascript:void(0)" class="link_delete" title="Xóa" data-id="0"><i class="fa fa-times"></i></a>
                                    <input type="text" hidden="hidden" id="parent_0" value="0">
                                    <input type="text" hidden="hidden" id="level_0" value="1">
                                    <input type="text" hidden="hidden" id="updateActionUrl" value="<?php echo base_url('sys-admin/action/insert-update'); ?>">
                                    <input type="text" hidden="hidden" id="deleteActionUrl" value="<?php echo base_url('sys-admin/action/delete'); ?>">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        var text_empty_name = "Menu name cannot be left blank";
    </script>
<?php $this->load->view('backend/includes/footer'); ?>