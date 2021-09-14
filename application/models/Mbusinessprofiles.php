<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessprofiles extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_profiles";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "busines_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM business_profiles WHERE busines_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( `business_name` LIKE '%{$postData['search_text']}%' OR `business_email` LIKE '%{$postData['search_text']}%' OR `business_address` LIKE '%{$postData['search_text']}%' OR `business_whatsapp` LIKE '%{$postData['search_text']}%' OR `business_phone` LIKE '%{$postData['search_text']}%')";
        if(isset($postData['busines_status_id']) && $postData['busines_status_id'] > 0) $query .= " AND busines_status_id = ".$postData['busines_status_id'];
        if(isset($postData['service_id']) && $postData['service_id'] > 0) $query .= " AND service_id = ".$postData['service_id'];
        if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query .= " AND customer_id = ".$postData['customer_id'];
        return $query;
    }

    public function update($postData = array(), $businessProfileId = 0, $businessServiceTypes = array(), $openingHours = array(), $userId = 0) {
        $isUpdate = $businessProfileId > 0;
        $this->db->trans_begin();
        $businessProfileId = $this->save($postData, $businessProfileId);
        if ($businessProfileId > 0) {
            if($isUpdate){
                $this->db->delete('opening_hours', array('business_profile_id' => $businessProfileId));
                $this->db->delete('business_service_types', array('business_profile_id' => $businessProfileId));
        	}
            if(!empty($businessServiceTypes)) {
                $arrBusinessType = array();
                foreach ($businessServiceTypes as $u) {
                    $arrBusinessType[] = array(
                        'business_profile_id' => $businessProfileId,
                        'service_type_id' => $u
                    );
                }
               
                if (!empty($arrBusinessType)) $this->db->insert_batch('business_service_types', $arrBusinessType);
            }

            if(!empty($openingHours)) {
                $arrOpenHours = array();
                foreach ($openingHours as $u) {
                    $arrOpenHours[] = array(
                        'business_profile_id' => $businessProfileId,
                        'day_id' => $u['day_id'],
                        'start_time' => !empty($u['start_time']) ? $u['start_time'].':00': NULL,
                        'end_time' => !empty($u['end_time']) ? $u['end_time'].':00': NULL,
                        'opening_hours_status_id' => $u['opening_hours_status_id'],
                        'created_at' => getCurentDateTime(),
                        'created_by' => $userId,
                        'updated_at' => getCurentDateTime(),
                        'updated_by' => $userId

                    );
                }
               
                if (!empty($arrOpenHours)) $this->db->insert_batch('opening_hours', $arrOpenHours);
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        }
        else {
            $this->db->trans_commit();
            return $businessProfileId;
        }
    }

    public function getBusinessInLocation($businessProfileId = 0) {
        $query = "SELECT
                locations.id,
                locations.location_name,
                business_profile_locations.expired_date,
                business_profile_locations.id as business_profile_location_id
            FROM business_profile_locations
                LEFT JOIN locations ON locations.id = business_profile_locations.location_id
            WHERE
                business_profile_locations.business_profile_location_status_id > 0 AND business_profile_locations.business_profile_id = ?";
        $data = $this->getByQuery($query, array($businessProfileId));
        if(count($data) > 0) return $data[0];
        else return array(); 
    }

    public function getBusinessProfileNotInLocation($searchText = '', $businessProfileLocationId = 0) {
        $where = ''; $where2 = '';
        if(!empty($searchText)) $where = " AND (business_name LIKE '%".$searchText."%') ";
        if($businessProfileLocationId > 0) $where2 = " AND id != ".$businessProfileLocationId;
        $query = "SELECT
                        id,
                        business_name 
                    FROM
                        business_profiles 
                    WHERE
                        business_profiles.busines_status_id = ? ".$where."
                        AND business_profiles.id NOT IN ( SELECT business_profile_id FROM business_profile_locations WHERE business_profile_location_status_id > 0 ".$where2.")";
        return $this->getByQuery($query, array(STATUS_ACTIVED));
    }
}