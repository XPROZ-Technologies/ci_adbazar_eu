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
    

    public function getCount($postData){
        $query = "business_profile_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM business_service_types WHERE business_profile_id > 0" . $this->buildQuery($postData);
        
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        
        if(isset($postData['service_type_ids']) && count($postData['service_type_ids']) > 0) {
            $ids = join(",",$postData['service_type_ids']);
            $query.=" AND `service_type_id` IN (".$ids.")";
        }
        
        return $query;
    }
}