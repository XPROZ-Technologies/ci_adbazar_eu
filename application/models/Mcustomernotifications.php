<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomernotifications extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customer_notifications";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "notification_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1, $language = 0){
        $query = "SELECT * FROM customer_notifications WHERE notification_status_id > 0" . $this->buildQuery($postData, $language);
        
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

    private function buildQuery($postData, $language = 0){
        $query = '';
        
        if(isset($postData['notification_status_id']) && $postData['notification_status_id'] > 0) $query .= " AND notification_status_id = ".$postData['notification_status_id'];
        if(isset($postData['business_id']) && $postData['business_id'] > 0) $query .= " AND business_id = ".$postData['business_id'];
        if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query .= " AND customer_id = ".$postData['customer_id'];
        if(isset($postData['is_send'])) $query .= " AND is_send = ".$postData['is_send'];
        
        return $query;
    }
}