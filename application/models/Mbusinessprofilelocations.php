<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessprofilelocations extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_profile_locations";
        $this->_primary_key = "id";
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND `business_profiles.business_name` LIKE '%{$postData['search_text']}%' ";
            if(isset($postData['service_id']) && count($postData['service_id']) > 0) {
                $serviceids = join(",",$postData['service_id']);
                if(!empty($serviceids)) $query .= " AND business_profiles.service_id IN (".$serviceids.")";
            }
        }
        
        return $query;
    }

    public function getBusinessprofileLocations($postData) {
        $query = "SELECT
                    locations.id,
                    locations.lat,
                    locations.lng,
                    business_profiles.id as business_profile_id,
                    business_profiles.business_name,
                    business_profiles.business_phone,
                    business_profiles.business_slogan,
                    business_profiles.business_avatar
                FROM
                    business_profile_locations
                    LEFT JOIN locations ON locations.id = business_profile_locations.location_id
                    LEFT JOIN business_profiles ON business_profiles.id = business_profile_locations.business_profile_id 
                WHERE
                    business_profile_locations.business_profile_location_status_id = ?".$this->buildQuery($postData);
        return $this->getByQuery($query, array(STATUS_ACTIVED));
    }
}