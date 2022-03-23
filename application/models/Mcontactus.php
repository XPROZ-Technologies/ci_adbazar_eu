<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcontactus extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "contact_us";
        $this->_primary_key = "id";
    }

}