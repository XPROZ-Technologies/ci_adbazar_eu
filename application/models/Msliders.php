<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msliders extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "sliders";
        $this->_primary_key = "id";
    }

    public function update($postData = array(), $sliderId = 0) {
        $this->db_master->trans_begin();
        if($postData['display_order'] > 0) {
            $this->db_master->set('display_order', 'display_order+1', false);
            $this->db_master->where(array('slider_status_id' => STATUS_ACTIVED, 'display_order>=' => $postData['display_order']));
            $this->db_master->update('sliders');
        }
        $sliderId = $this->save($postData, $sliderId);
        if ($this->db_master->trans_status() === false) {
            $this->db_master->trans_rollback();
            return false;
        } else {
            $this->db_master->trans_commit();
            return $sliderId;
        }
    }
}