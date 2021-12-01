<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlocations extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "locations";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "location_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM locations WHERE location_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `lat` LIKE '%{$postData['search_text']}%' OR lng LIKE '%{$postData['search_text']}%' OR location_name LIKE '%{$postData['search_text']}%'";
        return $query;
    }

    public function getLocationInBusiness($locationId = 0) {
        $query = "SELECT
                        business_profiles.id,
                        business_profiles.business_name,
                        business_profile_locations.expired_date,
                        business_profile_locations.id as business_profile_location_id
                    FROM business_profile_locations
                        LEFT JOIN business_profiles ON business_profiles.id = business_profile_locations.business_profile_id
                    WHERE
                        business_profile_locations.business_profile_location_status_id > 0 AND business_profile_locations.location_id = ?";
        $data = $this->getByQuery($query, array($locationId));
        if(count($data) > 0) return $data[0];
        else return array(); 
    }

    public function getLocationNotInBusinessProfile($searchText, $businessProfileLocationId){
        $where = ''; $where2 = '';
        if(!empty($searchText)) $where = " AND (location_name LIKE '%".$searchText."%') ";
        if($businessProfileLocationId > 0) $where2 = " AND id != ".$businessProfileLocationId;
        $query = "SELECT
                        id,
                        location_name 
                    FROM
                        locations 
                    WHERE
                        locations.location_status_id = ? ".$where."
                        AND locations.id NOT IN ( SELECT location_id FROM business_profile_locations WHERE business_profile_location_status_id > 0 ".$where2.")";
        return $this->getByQuery($query, array(STATUS_ACTIVED));
    }
}