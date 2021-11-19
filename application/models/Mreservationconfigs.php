<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mreservationconfigs extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "reservation_configs";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "reservation_config_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM customer_reviews WHERE reservation_config_status_id > 0" . $this->buildQuery($postData);

        if(isset($postData['order_by'])){
            $query .= " ORDER BY created_at ".$postData['order_by'];
        }else{
            $query .= " ORDER BY created_at DESC";
        }

        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';

        if(isset($postData['reservation_config_status_id']) && $postData['reservation_config_status_id'] != '')  $query.=" AND reservation_config_status_id = ".$postData['reservation_config_status_id'];
        if(isset($postData['business_profile_id']) && $postData['business_profile_id'] > 0)  $query.=" AND business_profile_id = ".$postData['business_profile_id'];

        return $query;
    }

    public function checkTimeNow($dayId = '', $businessId = 0) {
        $query = "SELECT id FROM `reservation_configs` WHERE
            day_id = ? 
            AND business_profile_id = ? 
            AND TIME_FORMAT(start_time, '%H:%i:%s') < CURRENT_TIME() AND TIME_FORMAT(end_time, '%H:%i:%s') > CURRENT_TIME()";
        $data = $this->getByQuery($query, array($dayId, $businessId));
        if(count($data) > 0) return true;
        return false;
    }
}