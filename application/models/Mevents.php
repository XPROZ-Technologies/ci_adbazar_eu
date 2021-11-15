<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mevents extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "events";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "event_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM events WHERE event_status_id > 0" . $this->buildQuery($postData);

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

    private function buildQuery($postData){
        $query = '';

        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `event_subject` LIKE '%{$postData['search_text']}%' OR  `event_description` LIKE '%{$postData['search_text']}%')";
        if(isset($postData['search_text_fe']) && !empty($postData['search_text_fe'])) $query.=" AND ( `event_subject` LIKE '%{$postData['search_text_fe']}%'  OR `event_description` LIKE '%{$postData['search_text_fe']}%')";
        if(isset($postData['event_status_id']) && !empty($postData['event_status_id']))  $query.=" AND event_status_id = ".$postData['event_status_id'];
        if(isset($postData['start_date']) && !empty($postData['start_date'])) $query .= " AND DATE(`start_date`) >= '{$postData['start_date']}'";
        if(isset($postData['selected_date']) && !empty($postData['selected_date'])) $query .= " AND DATE(`start_date`) <= '{$postData['selected_date']}' AND DATE(`end_date`) >= '{$postData['selected_date']}'";
        if(isset($postData['business_profile_id']) && $postData['business_profile_id'] > 0) $query.=" AND `business_profile_id` = {$postData['business_profile_id']}";
        if(isset($postData['joined_events']) && count($postData['joined_events']) > 0) $query.=" AND `id` NOT IN (".implode(',', $postData['joined_events']).")";
        if(isset($postData['event_ids']) && count($postData['event_ids']) > 0) $query.=" AND `id` IN (".implode(',', $postData['event_ids']).")";

        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query.=" AND `customer_events.customer_id` = {$postData['customer_id']}";
            if(isset($postData['selected_date']) && !empty($postData['selected_date'])) {
                $query .= " AND DATE(`events`.start_date) >= ".$postData['selected_date']." <= DATE(`events`.end_date)";
            }
        }
        return $query;
    }

    public function getListHome($postData) {
        $query = "SELECT
                    `events`.id,
                    `events`.event_subject,
                    `events`.event_image,
                    `events`.business_profile_id as business_id,
                    DATE_FORMAT( `events`.`start_date`, '%Y/%m/%d' ) AS `start_date`,
                    DATE_FORMAT( `events`.end_date, '%Y/%m/%d' ) AS end_date,
                    TIME_FORMAT(`events`.start_time, '%H:%i') AS start_time,
                    TIME_FORMAT(`events`.end_time, '%H:%i') AS end_time,
                    `business_profiles`.business_name
                FROM
                    `events`
                    LEFT JOIN business_profiles ON business_profiles.id = `events`.business_profile_id
                WHERE
                    DATE_FORMAT(CONCAT(`events`.end_date, ' ', TIME_FORMAT(`events`.start_time, '%H:%i')) , '%Y-%m-%d %H:%i:%s') >= NOW()
                    AND `events`.id NOT IN (SELECT customer_events.event_id FROM customer_events WHERE customer_events.customer_event_status_id = ?)
                    AND `events`.event_status_id = ? AND `events`.business_profile_id > 0 ".$this->buildQuery($postData)."
                GROUP BY
                    `events`.business_profile_id 
                ORDER BY
                    `events`.start_date, TIME_FORMAT(`events`.start_time, '%H:%i') ASC
                LIMIT ?";
        $result = $this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED, 20));
        return $result;
    }

    public function getCountInApi($postData) {
        $query = "SELECT
                    `events`.id
                FROM
                    `events`
                WHERE
                    `events`.id NOT IN (SELECT customer_events.event_id FROM customer_events WHERE customer_events.customer_event_status_id = ?)
                    AND `events`.event_status_id = ? AND `events`.business_profile_id > 0 ".$this->buildQuery($postData);
        return count($this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED)));
    }

    public function getListInApi($postData, $perPage = 0, $page = 1) {
        $query = "SELECT
                    `events`.id,
                    `events`.event_subject,
                    `events`.event_image,
                    `events`.business_profile_id as business_id,
                    DATE_FORMAT( `events`.`start_date`, '%Y/%m/%d' ) AS `start_date`,
                    DATE_FORMAT( `events`.end_date, '%Y/%m/%d' ) AS end_date,
                    TIME_FORMAT(`events`.start_time, '%H:%i') AS start_time,
                    TIME_FORMAT(`events`.end_time, '%H:%i') AS end_time,
                    `business_profiles`.business_name
                FROM
                    `events`
                    LEFT JOIN business_profiles ON business_profiles.id = `events`.business_profile_id
                WHERE
                    `events`.id NOT IN (SELECT customer_events.event_id FROM customer_events WHERE customer_events.customer_event_status_id = ?)
                    AND `events`.event_status_id = ? AND `events`.business_profile_id > 0 ".$this->buildQuery($postData)."
                GROUP BY
                    `events`.business_profile_id 
                ORDER BY
                    `events`.`start_date`, TIME_FORMAT(`events`.start_time, '%H:%i') ASC";
        
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }

        $result = $this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED));
        return $result;
    }
}