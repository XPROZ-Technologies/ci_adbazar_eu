<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcoupons extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "coupons";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "coupon_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM coupons WHERE coupon_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `coupon_code` LIKE '%{$postData['search_text']}%' OR coupon_subject LIKE '%{$postData['search_text']}%' OR coupon_amount LIKE '%{$postData['search_text']}%'";
        return $query;
    }

    public function update($postData, $couponId) {
        $isUpdate = $couponId > 0;
        $this->db_master = $this->load->database('master', TRUE);
        $this->db_master->trans_begin();
        $couponId = $this->save($postData, $couponId);
        if($couponId > 0){
            if($isUpdate){

            } else {
                $couponCode = createRandomCode(7).$couponId;
                $this->db->update('coupons', array('coupon_code' => $couponCode), array('id' => $couponId));
            }
        }
        if ($this->db_master->trans_status() === false) {
            $this->db_master->trans_rollback();
            return 0;
        }
        else {
            $this->db_master->trans_commit();
            return $couponId;
        }
    }
}