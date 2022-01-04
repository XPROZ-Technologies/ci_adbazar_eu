<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomerreservations extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customer_reservations";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "book_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT id, book_code, customer_id, business_profile_id, book_name, number_of_people, country_code_id, book_phone, date_arrived, time_arrived, book_status_id,
                    (CASE WHEN (book_status_id = 2 AND DATE_FORMAT(CONCAT(date_arrived,' ',time_arrived), '%Y-%m-%d %H:%i:%s') < NOW()) THEN 1 ELSE book_status_id END) as book_status_id
                FROM customer_reservations WHERE book_status_id > 0" . $this->buildQuery($postData);

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
        
        if(isset($postData['book_status_id']) && $postData['book_status_id'] != '') {
            if($postData['book_status_id'] == STATUS_ACTIVED){
                $query.=" AND (book_status_id = ".$postData['book_status_id']." AND DATE(`date_arrived`) >= '".date('Y-m-d')."')";
            }else if($postData['book_status_id'] != 1){
                $query.=" AND book_status_id = ".$postData['book_status_id'];
            }else if($postData['book_status_id'] == 1){
                $query.=" AND (book_status_id = ".$postData['book_status_id']." || DATE(`date_arrived`) < '".date('Y-m-d')."')";
            }
            
        } 
        if(isset($postData['business_profile_id']) && $postData['business_profile_id'] > 0)  $query.=" AND business_profile_id = ".$postData['business_profile_id'];
        if(isset($postData['customer_id']) && $postData['customer_id'] > 0)  $query.=" AND customer_id = ".$postData['customer_id'];
        if(isset($postData['code_name']) && !empty($postData['code_name'])) $query.=" AND book_code like '%".$postData['code_name']."%'";
        if(isset($postData['search_text_fe']) && !empty($postData['search_text_fe'])) $query.=" AND (book_code like '%".$postData['search_text_fe']."%' OR book_name like '%".$postData['search_text_fe']."%' OR book_phone like '%".$postData['search_text_fe']."%')";

        if(isset($postData['time_arrived']) && !empty($postData['time_arrived']))  $query.=" AND time_arrived = '".$postData['time_arrived']."'";
        if(isset($postData['date_arrived']) && !empty($postData['date_arrived']))  $query.=" AND date_arrived = '".$postData['date_arrived']."'";

        return $query;
    }

    public function getCountApi($postData){
        $query = "book_status_id > 0" . $this->buildQueryApi($postData);
        return $this->countRows($query);
    }

    public function searchApi($postData, $perPage = 0, $page = 1){
        if(empty($postData['order_by'])) $postData['order_by'] = 'DESC';

        $query = "SELECT 
                        id, book_code, customer_id, business_profile_id, book_name, number_of_people, country_code_id, book_phone, date_arrived, time_arrived, book_status_id,
                        (CASE WHEN (book_status_id = 2 AND DATE_FORMAT(CONCAT(date_arrived,' ',time_arrived), '%Y-%m-%d %H:%i:%s') < NOW()) THEN 1 ELSE book_status_id END) as book_status_id
                    FROM customer_reservations WHERE book_status_id > 0" . $this->buildQueryApi($postData);
        
        $query .= " ORDER BY IF(created_at IS NOT NULL, created_at, updated_at) ".$postData['order_by'];
        

        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQueryApi($postData){
        $query = '';

        if(isset($postData['api']) && $postData['api'] == 'api') {
            if(isset($postData['customer_id']) && $postData['customer_id'] > 0)  $query.=" AND customer_id = ".$postData['customer_id'];
            if(isset($postData['business_id']) && $postData['business_id'] > 0)  $query.=" AND business_profile_id = ".$postData['business_id'];
            if(isset($postData['search_text']) && !empty($postData['search_text'])) {
                $query .=" AND ( `book_code` LIKE '%{$postData['search_text']}%' OR 
                                `book_name` LIKE '%{$postData['search_text']}%' OR 
                                `book_phone` LIKE '%{$postData['search_text']}%' OR
                                `customer_id` IN (Select id FROM customers where customer_first_name LIKE '%{$postData['search_text']}%' OR customer_last_name LIKE '%{$postData['search_text']}%') OR
                                `business_profile_id` IN (select id FROM business_profiles where business_name LIKE '%{$postData['search_text']}%')
                            )"; 
            }
            if(isset($postData['book_status_id']) && $postData['book_status_id'] != '' && $postData['book_status_id'] > 0) {
                if(intval($postData['book_status_id']) == 2) {
                    $query.=" AND book_status_id = ".$postData['book_status_id']." AND DATE_FORMAT(CONCAT(date_arrived,' ',time_arrived), '%Y-%m-%d %H:%i:%s') >= NOW()";
                } else if(intval($postData['book_status_id']) == 1) {
                    $query.=" AND book_status_id = 2 AND DATE_FORMAT(CONCAT(date_arrived,' ',time_arrived), '%Y-%m-%d %H:%i:%s') < NOW()";
                } else {
                    $query.=" AND book_status_id = ".$postData['book_status_id'];
                }
            }
            
            if(isset($postData['selected_date']) && !empty($postData['selected_date'])) {
                $selectedDate = ddMMyyyy($postData['selected_date'], 'Y-m-d');
                $query.=" AND date_arrived = ".$selectedDate;
            }

            if(isset($postData['service_type_id']) && count($postData['service_type_id']) > 0) {
                $service_type_ids = join(",",$postData['service_type_id']);
                if(!empty($service_type_ids)) $query .= " AND customer_reservations.business_profile_id IN (select business_profile_id FROM business_service_types WHERE service_type_id IN (".$service_type_ids.") )";
            }
        }
        return $query;
    }

    public function searchReservationApi($postData, $perPage = 0, $page = 1) {
        if(empty($postData['order_by'])) $postData['order_by'] = 'DESC';
        $query = "SELECT customer_reservations.* FROM customer_reservations WHERE book_status_id > 0" . $this->buildQueryApi($postData);

        $query .= " ORDER BY IF(created_at IS NOT NULL, created_at, updated_at) ".$postData['order_by'];

        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    public function checkTimeBookReservations($strDateTime, $business_id){
        $query = "SELECT business_profile_id, date_arrived, time_arrived, SUM(number_of_people) as number_of_people  
                    FROM `customer_reservations`
                    WHERE book_status_id = 2 
                    AND business_profile_id = ".$business_id." 
                    AND DATE_FORMAT(CONCAT(date_arrived,' ',time_arrived), '%Y-%m-%d %H:%i:%s') >= DATE_FORMAT(CONCAT('".$strDateTime."'), '%Y-%m-%d %H:%i:%s')
                    GROUP BY business_profile_id";
        return $this->getByQuery($query);
    }

    // public function getListServiceType($customerId = 0, $langCode = '_vi') {
    //     $query = "SELECT
    //                     service_types.id, service_types.service_type_name".$langCode." AS service_type_name
    //                 FROM
    //                     customer_reservations 
    //                     LEFT JOIN business_service_types ON business_service_types.business_profile_id = customer_reservations.business_profile_id
	//                     LEFT JOIN service_types ON service_types.id = business_service_types.service_type_id
    //                 WHERE
    //                     customer_reservations.customer_id = ? AND service_types.status_id = 2
    //                 GROUP BY service_types.id";
    //     return $this->getByQuery($query, array($customerId));
    // }

    public function getListServiceType($customerId = 0, $langCode = '_vi') {
        $query = "SELECT
                        service_types.id, service_types.service_type_name".$langCode." AS service_type_name
                    FROM
                        customer_reservations 
                        LEFT JOIN business_service_types ON business_service_types.business_profile_id = customer_reservations.business_profile_id
	                    LEFT JOIN service_types ON service_types.id = business_service_types.service_type_id
                    WHERE
                        customer_reservations.customer_id = ? AND service_types.status_id = 2
                    GROUP BY service_types.id";
        return $this->getByQuery($query, array($customerId));
    }
}