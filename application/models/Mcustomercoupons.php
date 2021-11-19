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
            $query = "customer_id > 0 AND customer_coupon_status_id > 0 " . $this->buildQuery(array('coupon_id' => $coupon_id));
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

    private function buildQueryApi($postData){
        $query = '';
        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( coupons.coupon_code LIKE '%{$postData['search_text']}%' OR coupons.coupon_subject LIKE '%{$postData['search_text']}%')";
            if(isset($postData['service_id']) && $postData['service_id'] > 0) $query .= " AND business_profiles.service_id = ".$postData['service_id'];
            if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query .= " AND customer_coupons.customer_id = ".$postData['customer_id'];
        }
        return $query;
    }

    public function getCountInApi($postData){
        $query = "SELECT
                    coupons.id
                FROM
                    coupons
                    LEFT JOIN customer_coupons ON customer_coupons.coupon_id = coupons.id
                    LEFT JOIN business_profiles ON business_profiles.customer_id = customer_coupons.customer_id 
                WHERE customer_coupons.id IS NOT NULL  AND
                    coupons.coupon_status_id = ? 
                    AND customer_coupons.customer_coupon_status_id = ?  " . $this->buildQueryApi($postData). "
                GROUP BY
                    coupons.id";
        return count($this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED)));
    }

    public function getListInApi($postData, $perPage = 0, $page = 1) {
        if(empty($postData['order_by'])) $postData['order_by'] = 'DESC';
        $query = "SELECT
                    coupons.id,
                    coupons.coupon_subject,
                    coupons.coupon_image,
                    DATE_FORMAT(coupons.start_date, '%Y/%m/%d') as `start_date`,
                    DATE_FORMAT(coupons.end_date, '%Y/%m/%d') as end_date,
                    COUNT(CASE WHEN customer_coupons.customer_id > 0 THEN 1 END) as coupon_used,
                    coupons.coupon_amount
                FROM
                    coupons
                    LEFT JOIN customer_coupons ON customer_coupons.coupon_id = coupons.id
                    LEFT JOIN business_profiles ON business_profiles.customer_id = customer_coupons.customer_id 
                WHERE customer_coupons.id IS NOT NULL  AND
                    coupons.coupon_status_id = ? 
                    AND customer_coupons.customer_coupon_status_id = ?  " . $this->buildQueryApi($postData). "
                GROUP BY
                    coupons.id  ORDER BY coupons.created_at ".$postData['order_by'];
        if($perPage > 0) { 
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED));
    }
}