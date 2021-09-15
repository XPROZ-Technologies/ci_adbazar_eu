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
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `coupon_code` LIKE '%{$postData['search_text']}%' OR coupon_subject LIKE '%{$postData['search_text']}%' OR coupon_amount LIKE '%{$postData['search_text']}%'";
        return $query;
    }
}