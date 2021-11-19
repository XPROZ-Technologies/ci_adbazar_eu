<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mphonecodes extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "phonecodes";
        $this->_primary_key = "id";
    }

    public function getListSelect2Ajax($searchText = '') {
        $where = '';
        if(!empty($searchText)) $where = " AND (country_name LIKE '%".$searchText."%') ";
        $query = "SELECT * FROM phonecodes WHERE id > 0 ".$where." LIMIT 200";
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';

        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text']) && $postData['search_text'] > 0) $query .=" AND `country_name` LIKE '%".$postData['search_text'."%'"];
        }
        
        return $query;
    }

    public function getCountInApi($postData){
        $query = "id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function getListInApi($postData, $perPage = 0, $page = 1) {
        $query = "SELECT * FROM phonecodes WHERE id > 0" . $this->buildQuery($postData). " ORDER BY id ASC";
        if($perPage > 0) { 
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }
}