<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinesspayments extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_payments";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "payment_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM business_payments WHERE payment_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `payment_name` LIKE '%{$postData['search_text']}%' OR payment_address LIKE '%{$postData['search_text']}%' OR payment_amount LIKE '%{$postData['search_text']}%' OR payment_vat LIKE '%{$postData['search_text']}%' OR `payment_total` LIKE '%{$postData['search_text']}%')";
        if(isset($postData['business_profile_id']) && $postData['business_profile_id'] > 0) $query .= " AND business_profile_id = ".$postData['business_profile_id'];
        if(isset($postData['payment_gateway_id']) && $postData['payment_gateway_id'] > 0) $query .= " AND payment_gateway_id = ".$postData['payment_gateway_id'];
        return $query;
    }
}