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

        if(isset($postData['book_status_id']) && $postData['book_status_id'] != '')  $query.=" AND book_status_id = ".$postData['book_status_id'];
        if(isset($postData['business_profile_id']) && $postData['business_profile_id'] > 0)  $query.=" AND business_profile_id = ".$postData['business_profile_id'];
        if(isset($postData['customer_id']) && $postData['customer_id'] > 0)  $query.=" AND customer_id = ".$postData['customer_id'];

        return $query;
    }
}