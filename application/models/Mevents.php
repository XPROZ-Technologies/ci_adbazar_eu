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

        return $query;
    }

    public function getListHome($postData) {
        /*
            AND `events`.id NOT IN (SELECT customer_events.event_id FROM customer_events WHERE customer_events.customer_event_status_id = ?)
        */
        $where = '';
        if($postData['customer_id'] > 0) {
            $where = " AND `events`.id NOT IN (SELECT customer_events.event_id FROM customer_events WHERE customer_events.customer_event_status_id = ".STATUS_ACTIVED." AND customer_events.customer_id = ".$postData['customer_id'].")";
        }
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
                    AND `events`.event_status_id = ? AND `events`.business_profile_id > 0 ".$this->buildQuery($postData)." ".$where."
                GROUP BY
                    `events`.business_profile_id 
                ORDER BY
                    `events`.start_date, TIME_FORMAT(`events`.start_time, '%H:%i') ASC
                LIMIT ?";
        $result = $this->getByQuery($query, array(STATUS_ACTIVED, 10));
        return $result;
    }

    public function buildQueryInApi($postData) {
        $query = '';

        
        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND (`business_profiles`.business_name LIKE '%{$postData['search_text']}%' OR `events`.`event_subject` LIKE '%{$postData['search_text']}%' OR  `events`.`event_description` LIKE '%{$postData['search_text']}%')";
            // if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query.=" AND `customer_events`.customer_id = {$postData['customer_id']}";
            if(isset($postData['selected_date']) && !empty($postData['selected_date'])) {
                $query .= " AND (DATE( `events`.`start_date` ) <= DATE('".ddMMyyyy($postData['selected_date'], 'Y-m-d')."') AND  DATE('".ddMMyyyy($postData['selected_date'], 'Y-m-d')."') <= DATE( `events`.end_date )) ";
            }
            if(isset($postData['business_id']) && $postData['business_id'] > 0) {
                if(isset($postData['business_id']) && $postData['business_id'] > 0) $query.=" AND `events`.business_profile_id = {$postData['business_id']}";
            }

            if(isset($postData['filter_by']) && in_array(intval($postData['filter_by']), [1,2,3, 4])) {
                if(intval($postData['filter_by']) == 1) {
                    $query .= " AND (DATE_FORMAT(CONCAT(`events`.`start_date`,' ',`events`.start_time), '%Y-%m-%d %H:%i') > DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i') AND `events`.event_status_id = 2)";
                } else if (intval($postData['filter_by']) == 2) {
                    $query .= " AND (DATE_FORMAT(CONCAT(`events`.`start_date`,' ',`events`.start_time), '%Y-%m-%d %H:%i') <= DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i') AND DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i') <= DATE_FORMAT(CONCAT(`events`.`end_date`,' ',`events`.end_time), '%Y-%m-%d %H:%i') AND `events`.event_status_id = 2 )";
                } else if (intval($postData['filter_by']) == 3) {
                    $query .= " AND (DATE_FORMAT(CONCAT(`events`.`end_date`,' ',`events`.end_time), '%Y-%m-%d %H:%i') < DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i') AND `events`.event_status_id != 4)";
                } else if (intval($postData['filter_by']) == 4) {
                    $query .= " AND `events`.event_status_id = 4";
                }
            }
        }
        return $query;
    }

    public function getCountInApi($postData, $isAdmin = false) {

        $where = "";
        if(!empty($postData['customer_id']) && $postData['customer_id'] > 0 && $isAdmin == false) {
            $where = " AND `events`.id NOT IN (SELECT customer_events.event_id FROM customer_events WHERE customer_events.customer_event_status_id = 2 AND customer_id = ".$postData['customer_id'].")";
        }
        
        $where_status = " AND events.event_status_id = 2 ";
        if($isAdmin) {
            $where_status = " AND events.event_status_id > 0 ";
        }

        $query = "SELECT
                    `events`.id
                FROM
                    `events`
                    LEFT JOIN business_profiles ON business_profiles.id = `events`.business_profile_id
                WHERE
                    `events`.business_profile_id > 0 ".$where_status." ".$this->buildQueryInApi($postData).$where;
                    
        return count($this->getByQuery($query));
    }

    public function getListInApi($postData, $perPage = 0, $page = 1, $isAdmin = false) {
        if(empty($postData['order_by'])) $postData['order_by'] = 'DESC';

        $where = "";
        if(!empty($postData['customer_id']) && $postData['customer_id'] > 0 && $isAdmin == false) {
            $where = "AND `events`.id NOT IN (SELECT customer_events.event_id FROM customer_events WHERE customer_events.customer_event_status_id = ".STATUS_ACTIVED." AND customer_id = ".$postData['customer_id'].")";
        }

        $where_status = " AND events.event_status_id = 2 ";
        if($isAdmin) {
            $where_status = " AND events.event_status_id > 0 ";
        }

        $order_by = " `events`.`start_date`, TIME_FORMAT(`events`.start_time, '%H:%i') ".$postData['order_by'];
        if($isAdmin) {
            $order_by = " `events`.`created_at` ".$postData['order_by'];
        }

        $query = "SELECT
                    `events`.id,
                    `events`.event_subject,
                    `events`.event_image,
                    `events`.business_profile_id as business_id,
                    `events`.event_status_id,
                    DATE_FORMAT( `events`.`start_date`, '%Y/%m/%d' ) AS `start_date`,
                    DATE_FORMAT( `events`.end_date, '%Y/%m/%d' ) AS end_date,
                    TIME_FORMAT(`events`.start_time, '%H:%i') AS start_time,
                    TIME_FORMAT(`events`.end_time, '%H:%i') AS end_time,
                    `business_profiles`.business_name
                FROM
                    `events`
                    LEFT JOIN business_profiles ON business_profiles.id = `events`.business_profile_id
                WHERE
                    `events`.business_profile_id > 0 ".$where_status." ".$this->buildQueryInApi($postData)." ".$where."
                ORDER BY ".$order_by;
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }

        $result = $this->getByQuery($query);
        return $result;
    }

    public function getDetailEvent($postData, $isAdmin = false) {
        $where = " AND `events`.event_status_id = 2 ";
        if($isAdmin) {
            $where = " AND `events`.event_status_id > 0 ";
        }

        $query = "SELECT
                `events`.id,
                `events`.event_subject,
                `events`.event_image,
                `events`.event_description,
                DATE_FORMAT( `events`.`start_date`, '%Y/%m/%d' ) AS `start_date`,
                DATE_FORMAT( `events`.end_date, '%Y/%m/%d' ) AS end_date,
                TIME_FORMAT(`events`.start_time, '%H:%i') AS start_time,
                TIME_FORMAT(`events`.end_time, '%H:%i') AS end_time,
                business_profiles.id as business_profile_id,
                business_profiles.business_name,
                business_profiles.business_avatar,
                business_profiles.business_address,
                business_profiles.business_phone
            FROM
                `events`
                LEFT JOIN customer_events ON customer_events.event_id = `events`.id
                LEFT JOIN business_profiles ON business_profiles.id = `events`.business_profile_id
            WHERE `events`.id = ?  AND business_profiles.id IS NOT NULL ".$where." ";
       
        $result = $this->getByQuery($query, array($postData['event_id']));
        return $result;
    }

    public function getCalendar() {
        $query = "SELECT ( SELECT `start_date` FROM `events`  WHERE
                        DATE_FORMAT( CONCAT( `start_date`, ' ', `start_time` ), '%Y-%m-%d %H %i %s' ) >= NOW( ) 
                        ORDER BY
                        DATE_FORMAT( CONCAT( `start_date`, ' ', `start_time` ), '%Y-%m-%d %H %i %s' ) ASC 
                        LIMIT 1 
                    ) AS `start_date`,
                    MAX( end_date ) AS end_date 
                FROM
                    `events`";
        return $this->getByQuery($query);
    }

    public function event24h($dateBefore, $dateAfter) {
        $query = " SELECT * FROM `events` WHERE event_status_id = 2 AND 
                    (DATE_FORMAT(CONCAT(start_date,' ', start_time), '%Y-%m-%d %H:%i') >= '".$dateBefore."' AND  DATE_FORMAT(CONCAT(start_date,' ', start_time), '%Y-%m-%d %H:%i') <= '".$dateAfter."' )";
        return $this->getByQuery($query);
    }
}