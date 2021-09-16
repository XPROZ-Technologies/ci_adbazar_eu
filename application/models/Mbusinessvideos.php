<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessvideos extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_videos";
        $this->_primary_key = "id";
    }
}