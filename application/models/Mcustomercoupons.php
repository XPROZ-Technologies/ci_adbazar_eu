<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomercoupons extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customer_coupons";
        $this->_primary_key = "id";
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM customer_coupons WHERE customer_id > 0 AND customer_coupon_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    public function getCount($postData){
        $query = "customer_id > 0 AND customer_coupon_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function getUsedCoupon($coupon_id = 0){
        if($coupon_id > 0){
            $query = "customer_id > 0 AND customer_coupon_status_id > 0" . $this->buildQuery(array('coupon_id' => $coupon_id));
            return $this->countRows($query);
        } 
        return 0;
    }

    private function buildQuery($postData){
        $query = '';
        
        if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query .= " AND customer_id = ".$postData['customer_id'];
        if(isset($postData['coupon_id']) && $postData['coupon_id'] > 0) $query .= " AND coupon_id = ".$postData['coupon_id'];
        
        return $query;
    }
}