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
}