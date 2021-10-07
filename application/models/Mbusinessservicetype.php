<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessservicetype extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_service_types";
        $this->_primary_key = "id";
    }

    public function saveServiceType($serviceTypes = array(), $businessProfileId = 0, $isEdit = false){
        //Save open hours
        if(!empty($serviceTypes) && $businessProfileId > 0) {
            if($isEdit){
                $this->db->delete('business_service_types', array('business_profile_id' => $businessProfileId));
            }
            $arrBusinessType = array();
            foreach ($serviceTypes as $u) {
                $arrBusinessType[] = array(
                    'business_profile_id' => $businessProfileId,
                    'service_type_id' => $u
                );
            }
               
            if (!empty($arrBusinessType)) $this->db->insert_batch('business_service_types', $arrBusinessType);
        
            return true;
        }
        return false;
    }
    
}