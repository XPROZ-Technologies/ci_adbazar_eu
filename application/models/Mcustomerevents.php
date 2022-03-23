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

    private function buildQuery($postData){
        $query = '';
        
        if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query .= " AND customer_id = ".$postData['customer_id'];
        if(isset($postData['event_id']) && $postData['event_id'] > 0) $query .= " AND event_id = ".$postData['event_id'];
        
        return $query;
    }
}