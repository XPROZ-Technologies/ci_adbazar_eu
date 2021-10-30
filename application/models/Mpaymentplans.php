<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpaymentplans extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "payment_plans";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "plan_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM payment_plans WHERE plan_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `plan_name` LIKE '%{$postData['search_text']}%' OR plan_amount LIKE '%{$postData['search_text']}%' OR plan_vat LIKE '%{$postData['search_text']}%' OR plan_amount LIKE '%{$postData['search_text']}%' OR `plan_save` LIKE '%{$postData['search_text']}%')";
        if(isset($postData['plan_id']) && $postData['plan_id'] > 0) $query .= " AND plan_id = ".$postData['plan_id'];
        if(isset($postData['plan_type_id']) && $postData['plan_type_id'] > 0) $query .= " AND plan_type_id = ".$postData['plan_type_id'];
        return $query;
    }
}