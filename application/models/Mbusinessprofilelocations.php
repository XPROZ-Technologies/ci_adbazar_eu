<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessprofilelocations extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_profile_locations";
        $this->_primary_key = "id";
    }
}