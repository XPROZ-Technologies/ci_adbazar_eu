<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomerreviews extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customer_reviews";
        $this->_primary_key = "id";
    }
}