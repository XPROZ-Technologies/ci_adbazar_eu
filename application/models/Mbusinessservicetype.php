<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessservicetype extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_service_types";
        $this->_primary_key = "id";
    }
}