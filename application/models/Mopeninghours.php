<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mopeninghours extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "opening_hours";
        $this->_primary_key = "id";
    }
}