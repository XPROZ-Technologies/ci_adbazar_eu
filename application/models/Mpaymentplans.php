<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpaymentplans extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "payment_plans";
        $this->_primary_key = "id";
    }
}