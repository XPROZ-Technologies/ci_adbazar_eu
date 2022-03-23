<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mactions extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "actions";
        $this->_primary_key = "id";
    }

    public function getByUserId($userId){
        return $this->getByQuery('SELECT DISTINCT actions.* FROM actions
                WHERE actions.status_id = ? ORDER BY actions.display_order ASC',
            array(STATUS_ACTIVED));
        // return $this->getByQuery('SELECT DISTINCT actions.* FROM actions
        //         INNER JOIN roleactions ON actions.id = roleactions.action_id
        //         INNER JOIN users ON users.role_id = roleactions.role_id
        //         WHERE actions.status_id = ? AND users.id = ? ORDER BY actions.display_order ASC',
        //     array(STATUS_ACTIVED, $userId));
    }

    public function checkAccess($listActions, $actionUrl){
        return true;
        foreach($listActions as $action) {
            if ($action['action_url'] == $actionUrl) return true;
        }
        return false;
    }


    public function getHierachy(){
        $retVal = array();
        $listActions = $this->getBy(array('status_id' => STATUS_ACTIVED), false, 'display_order',  '', 0, 0, 'asc');
        $listActions1 = $listActions2 = $listActions3 = array();
        foreach($listActions as $a){
            if($a['action_level'] == 1) $listActions1[]=$a;
            elseif($a['action_level'] == 2) $listActions2[]=$a;
            elseif($a['action_level'] == 3) $listActions3[]=$a;
        }
        foreach($listActions1 as $a1){
            $retVal[] = $a1;
            foreach ($listActions2 as $a2) {
                if($a2['parent_action_id'] == $a1['id']){
                    $retVal[]=$a2;
                    foreach ($listActions3 as $a3) {
                        if($a3['parent_action_id'] == $a2['id']) $retVal[]=$a3;
                    }
                }
            }
        }
        return $retVal;
    }

    public function getParentActionHtml($listAction){
        $retVal = '<option value="0">Không có</option>';
        foreach($listAction as $act){
            if($act['action_level'] == 1) $retVal .= '<option value="' . $act['id'] . '">' . $act['action_name'] . '</option>';
            elseif($act['action_level'] == 2) $retVal .= '<option value="' . $act['id'] . '">+> ' . $act['action_name'] . '</option>';
        }
        return $retVal;
    }

    public function update($postData, $actionId){
        $this->db_master->trans_begin();
        if($postData['display_order'] > 0) {
            $this->db_master->set('display_order', 'display_order+1', false);
            $this->db_master->where(array('status_id' => STATUS_ACTIVED, 'parent_action_id' => $postData['parent_action_id'], 'display_order>=' => $postData['display_order']));
            $this->db_master->update('actions');
        }
        $this->save($postData, $actionId);
        if ($this->db_master->trans_status() === false){
            $this->db_master->trans_rollback();
            return false;
        }
        else{
            $this->db_master->trans_commit();
            return true;
        }
    }

    public function deleteBy($actionId){
        $actions = $this->getBy(array('parent_action_id' => $actionId, 'status_id' => STATUS_ACTIVED), false, 'id');
        if(empty($actions)) return $this->changeStatus(0, $actionId);
        return false;
    }
}
