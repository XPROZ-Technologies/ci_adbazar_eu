<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcoupons extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "coupons";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "coupon_status_id > 0 AND coupon_amount > 0 AND coupon_amount > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM coupons WHERE coupon_status_id > 0 AND coupon_amount > 0" . $this->buildQuery($postData);
        
        if(isset($postData['order_by'])){
            $query .= " ORDER BY start_date ".$postData['order_by'];
        }else{
            $query .= " ORDER BY start_date DESC";
        }
        
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    public function getListBusinessId(){
        $query = "SELECT DISTINCT business_profile_id FROM coupons WHERE coupon_status_id > 0";
       
        $result = $this->getByQuery($query);

        $businessProfileIds = array();
        if(count($result) > 0){
            foreach($result as $couponItem){
                $businessProfileIds[] = $couponItem['business_profile_id'];
            }
        }
        return $businessProfileIds;
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `coupon_code` LIKE '%{$postData['search_text']}%' OR coupon_subject LIKE '%{$postData['search_text']}%' OR coupon_amount LIKE '%{$postData['search_text']}%')";
        if(isset($postData['search_text_fe']) && !empty($postData['search_text_fe'])) $query.=" AND ( `coupon_code` LIKE '%{$postData['search_text_fe']}%' OR coupon_subject LIKE '%{$postData['search_text_fe']}%')";
        if(isset($postData['coupon_status_id']) && !empty($postData['coupon_status_id'])) $query.=" AND `coupon_status_id` = {$postData['coupon_status_id']}";
        if(isset($postData['business_profile_id']) && $postData['business_profile_id'] > 0) $query.=" AND `business_profile_id` = {$postData['business_profile_id']}";
        if(isset($postData['is_hot']) && !empty($postData['is_hot'])) $query.=" AND `is_hot` = {$postData['is_hot']}";
        if(isset($postData['is_full']) && !empty($postData['is_full'])) $query.=" AND `is_full` = {$postData['is_full']}";
        if(isset($postData['saved_coupons']) && count($postData['saved_coupons']) > 0) $query.=" AND `id` NOT IN (".implode(',', $postData['saved_coupons']).")";
        if(isset($postData['coupon_ids']) && count($postData['coupon_ids']) > 0) $query.=" AND `id` IN (".implode(',', $postData['coupon_ids']).")";
        if(isset($postData['business_profile_ids']) && count($postData['business_profile_ids']) > 0) $query.=" AND `business_profile_id` IN (".implode(',', $postData['business_profile_ids']).")";

        return $query;
    }

    public function buildQueryInApi($postData) {
        $query = '';
       

        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text']) && !empty($postData['search_text'])) {
                $query.=" AND ( business_profiles.business_name LIKE '%{$postData['search_text']}%' OR coupons.`coupon_code` LIKE '%{$postData['search_text']}%' OR coupons.coupon_subject LIKE '%{$postData['search_text']}%' OR coupons.coupon_amount LIKE '%{$postData['search_text']}%')";
            }
            if(isset($postData['customer_id']) && $postData['customer_id'] > 0) {
                $query.=" AND coupons.id NOT IN (SELECT coupon_id FROM customer_coupons WHERE customer_coupon_status_id = 2 AND customer_id =".$postData['customer_id'].")";
            }
           
            if(isset($postData['service_id']) && count($postData['service_id']) > 0 && isset($postData['service_type_id']) && count($postData['service_type_id']) <= 0) {
                $serviceIds = join(",",$postData['service_id']);
                $query.=" AND coupons.business_profile_id IN (SELECT business_profiles.id FROM business_profiles  WHERE business_profiles.service_id IN (".$serviceIds."))";
            }
            if(isset($postData['service_id']) && count($postData['service_id']) <= 0 && isset($postData['service_type_id']) && count($postData['service_type_id']) > 0) {
                $serviceTypeIds = join(",",$postData['service_type_id']);
                $query .= " AND coupons.business_profile_id IN (SELECT business_profiles.id FROM business_profiles LEFT JOIN service_types ON service_types.service_id = business_profiles.service_id WHERE  service_types.id IN (".$serviceTypeIds."))";
            }
            if(isset($postData['service_id']) && count($postData['service_id']) > 0 && isset($postData['service_type_id']) && count($postData['service_type_id']) > 0) {
                $serviceTypeIds = join(",",$postData['service_type_id']);
                $serviceIds = join(",",$postData['service_id']);
                $query .= " AND coupons.business_profile_id IN (SELECT business_profiles.id FROM business_profiles LEFT JOIN service_types ON service_types.service_id = business_profiles.service_id WHERE business_profiles.service_id IN (".$serviceIds.") AND service_types.id IN (".$serviceTypeIds."))";
            }

            if(isset($postData['business_id']) && $postData['business_id'] > 0) {
                if(isset($postData['business_id']) && $postData['business_id'] > 0) $query.=" AND coupons.business_profile_id = {$postData['business_id']}";
            }

        }
        
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

    function genCouponCode($couponCode = "", $amount = 0, $used = 0) {
        if(!empty($couponCode) && !empty($amount) && $amount > 0){
            $new_index = $used + 1;
            if($amount >= $new_index){
                return $couponCode . '-' . (($used + 1) + 10000);
            }
        }
        return "";
    }

    public function getListHome($postData) {
        $where = '';
        if($postData['customer_id'] > 0) {
            $where = " AND coupons.id NOT IN (select coupon_id from customer_coupons WHERE customer_coupons.customer_id = ".$postData['customer_id']." AND customer_coupons.customer_coupon_status_id = ".STATUS_ACTIVED.") ";
        }

        $query = "SELECT
                coupons.id,
                coupons.coupon_subject,
                coupons.coupon_image,
                coupons.coupon_amount,
                DATE_FORMAT( coupons.start_date, '%Y/%m/%d' ) AS start_date,
                DATE_FORMAT( coupons.end_date, '%Y/%m/%d' ) AS end_date,
                ( SELECT count( id ) FROM customer_coupons WHERE customer_coupons.coupon_id = coupons.id AND customer_coupons.customer_coupon_status_id = ? GROUP BY coupon_id ) AS coupon_used 
            FROM
                coupons 
            WHERE
                DATE(coupons.end_date) >= CURDATE()
                AND ( SELECT count( id ) FROM customer_coupons WHERE customer_coupons.coupon_id = coupons.id AND customer_coupons.customer_coupon_status_id = ".STATUS_ACTIVED." ) < coupons.coupon_amount 
                ".$where."
                 AND coupons.coupon_status_id = ? 
                ".$this->buildQuery($postData)."
            GROUP BY
                coupons.business_profile_id 
            ORDER BY
                coupons.created_at DESC
            LIMIT ?";
        
        $result = $this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED, 10));
        return $result;
    }

    public function getCountInApi($postData, $isAdmin = false) {
        $where = "";
        if($postData['customer_id'] > 0) {
            $where .= " AND coupons.id NOT IN (select coupon_id from customer_coupons WHERE customer_coupons.customer_id = ".$postData['customer_id']." AND customer_coupons.customer_coupon_status_id = ".STATUS_ACTIVED.") ";
        }
        $where_status = " AND coupons.coupon_status_id = 2 ";
        if($isAdmin) {
            $where_status = " AND coupons.coupon_status_id > 0 ";
        }

        $query = "SELECT coupons.id
                    FROM
                        coupons
                        LEFT JOIN business_profiles ON business_profiles.id = coupons.business_profile_id
                    WHERE
                        DATE(coupons.end_date) >= CURDATE() 
                        AND ( SELECT count( id ) FROM customer_coupons WHERE customer_coupons.coupon_id = coupons.id AND customer_coupons.customer_coupon_status_id = ".STATUS_ACTIVED." ) < coupons.coupon_amount 
                        ".$where."
                        ".$where_status."
                        ".$this->buildQueryInApi($postData);
        return count($this->getByQuery($query));
    }

    public function getListInApi($postData, $perPage = 0, $page = 1, $isAdmin = false) {
        
        $orderBy = 'DESC';
        if(isset($postData['order_by']) && !empty($postData['order_by'])) {
            $orderBy = $postData['order_by'];
        }
        
        $where = "";
        if($postData['customer_id'] > 0) {
            $where = " AND coupons.id NOT IN (select coupon_id from customer_coupons WHERE customer_coupons.customer_id = ".$postData['customer_id']." AND customer_coupons.customer_coupon_status_id = ".STATUS_ACTIVED.") ";
        }

        $where_status = " AND coupons.coupon_status_id = 2 ";
        if($isAdmin) {
            $where_status = " AND coupons.coupon_status_id > 0 ";
        }

        $query = "SELECT
                    coupons.id,
                    coupons.coupon_subject,
                    coupons.coupon_image,
                    coupons.coupon_amount,
                    coupons.coupon_status_id,
                    DATE_FORMAT( coupons.start_date, '%Y/%m/%d' ) AS `start_date`,
                    DATE_FORMAT( coupons.end_date, '%Y/%m/%d' ) AS end_date,
                    coupons.created_at,
                    ( SELECT count( id ) FROM customer_coupons WHERE customer_coupons.coupon_id = coupons.id AND customer_coupons.customer_coupon_status_id = ? GROUP BY coupon_id ) AS coupon_used 
                FROM
                    coupons
                LEFT JOIN business_profiles ON business_profiles.id = coupons.business_profile_id
                WHERE
                    DATE(coupons.end_date) >= CURDATE() 
                    AND ( SELECT count( id ) FROM customer_coupons WHERE customer_coupons.coupon_id = coupons.id AND customer_coupons.customer_coupon_status_id = ".STATUS_ACTIVED." ) < coupons.coupon_amount 
                    ".$where." 
                    ".$where_status."
                    ".$this->buildQueryInApi($postData)."
                ORDER BY
                    coupons.created_at ".$orderBy;
            if($perPage > 0) {
                $from = ($page-1) * $perPage;
                $query .= " LIMIT {$from}, {$perPage}";
            }
        return $this->getByQuery($query, array(STATUS_ACTIVED));
    }

    public function getServicesInCoupon($customerId = 0, $langCode = '_vi') {
        $services = [];
       
        if($customerId == 0) {
            $query = "SELECT services.id, services.service_name".$langCode." as service_name FROM `services`
                    LEFT JOIN business_profiles ON business_profiles.service_id = services.id
                    LEFT JOIN coupons ON coupons.business_profile_id = business_profiles.id
                    WHERE services.service_status_id = ? AND coupons.business_profile_id > 0 AND coupons.coupon_status_id = ?
                    GROUP BY services.id";
            $services = $this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED));
        } else {
            $query = "SELECT
                    services.id,
                    services.service_name".$langCode." AS service_name 
                FROM
                    `customer_coupons`
                    LEFT JOIN coupons ON coupons.id = customer_coupons.coupon_id 
                    LEFT JOIN business_profiles ON business_profiles.id = coupons.business_profile_id
                    LEFT JOIN services ON business_profiles.service_id = services.id
                WHERE
                    services.service_status_id = ? 
                    AND coupons.business_profile_id > 0 
                    AND coupons.coupon_status_id = ? AND customer_coupons.customer_coupon_status_id = ? AND customer_coupons.customer_id = ?
                GROUP BY
                    services.id";
            
            $services = $this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED, STATUS_ACTIVED, $customerId));
        }
        
        if($services) {
            $this->load->model('Mservicetypes');
            for($i = 0; $i < count($services); $i++){
                $serviceTypes = $this->Mservicetypes->getBy(array('service_id' => $services[$i]['id'], 'status_id' => STATUS_ACTIVED), false, 'display_order', 'id, service_type_name'.$langCode.' as service_type_name', 0,0,'asc');
                $services[$i]['service_types'] = $serviceTypes;
            }   
        }
        return $services;           
    }

    public function getDetailCoupon($postData, $isAdmin = false) {
        $where = " AND coupons.coupon_status_id = 2";
        if($isAdmin) {
            $where = " AND coupons.coupon_status_id > 0";
        }

        $query = "SELECT
                    coupons.id,
                    coupons.coupon_subject,
                    coupons.coupon_image,
                    coupons.coupon_amount,
                    coupons.coupon_status_id,
                    DATE_FORMAT( coupons.start_date, '%Y/%m/%d' ) AS `start_date`,
                    DATE_FORMAT( coupons.end_date, '%Y/%m/%d' ) AS end_date,
                    coupons.coupon_description,
                    coupons.business_profile_id,
                    business_profiles.business_name,
                    business_profiles.business_avatar,
                    business_profiles.business_address,
                    business_profiles.business_phone,
                    coupons.created_at,
                    CASE WHEN customer_coupons.customer_id > 0 THEN customer_coupons.customer_coupon_code ELSE '' END AS coupon_code,
                    ( SELECT count( id ) FROM customer_coupons WHERE customer_coupons.coupon_id = coupons.id AND customer_coupons.customer_coupon_status_id = ? GROUP BY coupon_id ) AS coupon_used
                FROM
                    coupons
                    LEFT JOIN customer_coupons ON customer_coupons.coupon_id = coupons.id
                    LEFT JOIN business_profiles ON business_profiles.id = coupons.business_profile_id  
                WHERE coupons.id = ? AND business_profiles.id IS NOT NULL ".$where; 
        $data = $this->getByQuery($query, array(STATUS_ACTIVED, $postData['coupon_id']));
        return $data;
    }

}