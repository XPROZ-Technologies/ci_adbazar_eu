<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessprofiles extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_profiles";
        $this->_primary_key = "id";
    }
}