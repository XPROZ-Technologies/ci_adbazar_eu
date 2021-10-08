<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomerreviews extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customer_reviews";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "customer_review_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM customer_reviews WHERE customer_review_status_id > 0" . $this->buildQuery($postData);

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

        if(isset($postData['customer_review_status_id']) && !empty($postData['customer_review_status_id']))  $query.=" AND customer_review_status_id = ".$postData['customer_review_status_id'];
        if(isset($postData['customer_id']) && !empty($postData['customer_id']))  $query.=" AND customer_id = ".$postData['customer_id'];
        if(isset($postData['business_id']) && !empty($postData['business_id']))  $query.=" AND business_id = ".$postData['business_id'];
        if(isset($postData['review_star']) && !empty($postData['review_star']))  $query.=" AND review_star = ".$postData['review_star'];

        return $query;
    }
}