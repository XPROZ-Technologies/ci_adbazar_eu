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
        $query = "SELECT * FROM customer_reservations WHERE book_status_id > 0" . $this->buildQuery($postData);

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

        if(isset($postData['api']) && $postData['api'] == 'api') {
            if(isset($postData['business_id']) && $postData['business_id'] > 0)  $query.=" AND business_profile_id = ".$postData['business_id'];
            if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( `book_code` LIKE '%{$postData['search_text']}%' OR `book_name` LIKE '%{$postData['search_text']}%' OR `book_phone` LIKE '%{$postData['search_text']}%')";
        }
        

        return $query;
    }

    public function getCountApi($postData){
        $query = "book_status_id > 0" . $this->buildQueryApi($postData);
        return $this->countRows($query);
    }

    public function searchApi($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM customer_reservations WHERE book_status_id > 0" . $this->buildQueryApi($postData);

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

    private function buildQueryApi($postData){
        $query = '';

        if(isset($postData['api']) && $postData['api'] == 'api') {
            if(isset($postData['business_id']) && $postData['business_id'] > 0)  $query.=" AND business_profile_id = ".$postData['business_id'];
            if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( `book_code` LIKE '%{$postData['search_text']}%' OR `book_name` LIKE '%{$postData['search_text']}%' OR `book_phone` LIKE '%{$postData['search_text']}%')";
            if(isset($postData['book_status_id']) && $postData['book_status_id'] != '') $query.=" AND book_status_id = ".$postData['book_status_id'];
        }
        return $query;
    }
}