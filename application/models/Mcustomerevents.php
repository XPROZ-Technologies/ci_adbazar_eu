<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomerevents extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customer_events";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "customer_event_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function getCountUsedApi($postData){
        $query = "customer_event_status_id = 2 " . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    private function buildQuery($postData){
        $query = '';
        
        if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query .= " AND customer_id = ".$postData['customer_id'];
        if(isset($postData['event_id']) && $postData['event_id'] > 0) $query .= " AND event_id = ".$postData['event_id'];
        
        return $query;
    }

    private function buildQueryApi($postData){
        $query = '';
        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( business_profiles.business_name LIKE '%{$postData['search_text']}%' OR events.event_subject LIKE '%{$postData['search_text']}%')";
            if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query .= " AND customer_events.customer_id = ".$postData['customer_id'];
        }
        return $query;
    }

    public function getCountInApi($postData){
        $query = "SELECT
                        `events`.id
                    FROM
                        `events`
                        LEFT JOIN `customer_events` ON `events`.id = customer_events.event_id
                        LEFT JOIN business_profiles ON business_profiles.id = `events`.business_profile_id 
                    WHERE
                        customer_events.customer_event_status_id = ? 
                        AND `events`.event_status_id = ? ".$this->buildQueryApi($postData)."
                    GROUP BY
                        `events`.id";
        return count($this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED)));
    }

    public function getListInApi($postData, $perPage = 0, $page = 1) {
        if(empty($postData['order_by'])) $postData['order_by'] = 'DESC';
        $query = "SELECT
                        `events`.id,
                        `events`.event_subject,
                        `events`.event_image,
                        `events`.business_profile_id,
                        business_profiles.business_name,
                        DATE_FORMAT(`events`.start_date, '%Y/%m/%d') as `start_date`,
                    DATE_FORMAT(`events`.end_date, '%Y/%m/%d') as end_date,
                        TIME_FORMAT(`events`.start_time, '%H:%i') AS start_time,
                    TIME_FORMAT(`events`.end_time, '%H:%i') AS end_time
                    FROM
                        `events`
                        LEFT JOIN `customer_events` ON `events`.id = customer_events.event_id
                        LEFT JOIN business_profiles ON business_profiles.id = `events`.business_profile_id 
                    WHERE
                        customer_events.customer_event_status_id = ? 
                        AND `events`.event_status_id = ? ".$this->buildQueryApi($postData)."
                    GROUP BY
                        `events`.id
                    ORDER BY `events`.created_at ".$postData['order_by'];
        if($perPage > 0) { 
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED));
    }
}