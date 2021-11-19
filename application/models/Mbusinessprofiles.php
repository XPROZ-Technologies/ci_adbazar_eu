<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessprofiles extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_profiles";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "business_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM business_profiles WHERE business_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( `business_name` LIKE '%{$postData['search_text']}%' OR `business_email` LIKE '%{$postData['search_text']}%' OR `business_address` LIKE '%{$postData['search_text']}%' OR `business_whatsapp` LIKE '%{$postData['search_text']}%' OR `business_phone` LIKE '%{$postData['search_text']}%')";
        if(isset($postData['search_text_fe']) && !empty($postData['search_text_fe'])) $query .=" AND ( `business_name` LIKE '%{$postData['search_text_fe']}%' OR `business_description` LIKE '%{$postData['search_text_fe']}%')";
        if(isset($postData['business_status_id']) && $postData['business_status_id'] > 0) $query .= " AND business_status_id = ".$postData['business_status_id'];
        if(isset($postData['business_profile_ids'])) {
            $business_profile_ids = join(",",$postData['business_profile_ids']);
            if(!empty($business_profile_ids)) $query .= " AND id IN (".$business_profile_ids.")";
            
        }
        
        if(isset($postData['is_annual_payment'])) $query .= " AND is_annual_payment = ".$postData['is_annual_payment'];
        if(isset($postData['service_id']) && $postData['service_id'] > 0) $query .= " AND service_id = ".$postData['service_id'];
        if(isset($postData['service_ids']) && count($postData['service_ids']) > 0) $query .= " AND service_id IN (".implode(',', $postData['service_ids']).")";
        if(isset($postData['customer_id']) && $postData['customer_id'] > 0) $query .= " AND customer_id = ".$postData['customer_id'];
        if(isset($postData['expired']) && !empty($postData['expired'])) $query .= " AND DATE(expired_date) >= '{$postData['expired']}'";

        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( `business_name` LIKE '%{$postData['search_text']}%')";
        }
        
        return $query;
    }

    public function update($postData = array(), $businessProfileId = 0, $businessServiceTypes = array(), $openingHours = array(), $userId = 0, $businessPhotos = array(), $businessVideos = array()) {
        $isUpdate = $businessProfileId > 0;
        $this->db->trans_begin();
        $businessProfileId = $this->save($postData, $businessProfileId);
        if ($businessProfileId > 0) {
            if($isUpdate){
                $this->db->delete('opening_hours', array('business_profile_id' => $businessProfileId));
                $this->db->delete('business_service_types', array('business_profile_id' => $businessProfileId));
                $this->db->delete('business_photos', array('business_profile_id' => $businessProfileId));
                $this->db->delete('business_videos', array('business_profile_id' => $businessProfileId));
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
            if(!empty($businessPhotos)) {
                $arrPhotos = array();
                foreach ($businessPhotos as $u) {
                    $photo = empty($u) ? NO_IMAGE : replaceFileUrl($u, BUSINESS_PROFILE_PATH);
                    $arrPhotos[] = array(
                        'business_profile_id' => $businessProfileId,
                        'photo_image' => $photo,
                        'created_at' => getCurentDateTime(),
                        'created_by' => $userId,
                        'updated_at' => getCurentDateTime(),
                        'updated_by' => $userId

                    );
                }
               
                if (!empty($arrPhotos)) $this->db->insert_batch('business_photos', $arrPhotos);
            }
            if(!empty($businessVideos)) {
                $arrVideos = array();
                foreach ($businessVideos as $u) {
                    $arrVideos[] = array(
                        'business_profile_id' => $businessProfileId,
                        'video_url' => $u['video_url'],
                        'video_code' => $u['video_code'],
                        'created_at' => getCurentDateTime(),
                        'created_by' => $userId,
                        'updated_at' => getCurentDateTime(),
                        'updated_by' => $userId

                    );
                }
               
                if (!empty($arrVideos)) $this->db->insert_batch('business_videos', $arrVideos);
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
                locations.lat,
                locations.lng,
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

    public function getByNotification($business_ids = array()) {
        $query = "SELECT
                DISTINCT
                business_profiles.id,
                business_profiles.business_name
            FROM business_profiles
                LEFT JOIN customer_notifications ON customer_notifications.business_id = business_profiles.id
            WHERE notification_status_id > 0 AND customer_notifications.business_id IN (".implode(',', $business_ids).")";
        return $this->getByQuery($query);
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
                        business_profiles.business_status_id = ? ".$where."
                        AND business_profiles.id NOT IN ( SELECT business_profile_id FROM business_profile_locations WHERE business_profile_location_status_id > 0 ".$where2.")";
        return $this->getByQuery($query, array(STATUS_ACTIVED));
    }

    public function getListSelect2BuinessProfile($searchText = '') {
        $where = '';
        if(!empty($searchText)) $where = " AND (business_name LIKE '%".$searchText."%') ";
        $query = "SELECT id, business_name FROM business_profiles WHERE business_status_id = 2  ".$where." LIMIT 200";
        return $this->getByQuery($query);
    }

    public function getCountInApi($postData) {
        $query = "business_status_id = 2" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function getListInApi($postData, $perPage = 0, $page = 1) {
        $query = "SELECT
                    business_profiles.id,
                    business_profiles.business_name,
                    business_profiles.business_slogan,
                    business_profiles.id,
                    business_profiles.business_phone,
                    business_profiles.business_address,
                    business_profiles.business_avatar,
                    business_profiles.business_status_id,
                    ROUND(AVG(customer_reviews.review_star),1) as star,
                    COUNT(CASE  WHEN customer_reviews.business_id > 0 THEN 1 END) as number_of_reviews,
                    CASE  WHEN business_profile_locations.business_profile_id > 0 THEN 1 ELSE 0 END as has_location
                    FROM
                    business_profiles
                    LEFT JOIN customer_reviews ON customer_reviews.business_id = business_profiles.id
                    LEFT JOIN business_profile_locations ON business_profile_locations.business_profile_id = business_profiles.id
                WHERE
                    business_profiles.business_status_id = ? ".$this->buildQuery($postData)."
                GROUP BY
                    business_profiles.id";
            if($perPage > 0) {
                $from = ($page-1) * $perPage;
                $query .= " LIMIT {$from}, {$perPage}";
            }
        return $this->getByQuery($query, array(STATUS_ACTIVED));
    }

    public function getDetailInApi($businessId = 0) {
        $query = "SELECT
                    business_profiles.id,
                    business_profiles.service_id,
                    business_profiles.business_name,
                    business_profiles.business_slogan,
                    business_profiles.business_email,
                    business_profiles.business_address,
                    business_profiles.business_whatsapp,
                    business_profiles.business_url,
                    business_profiles.country_code_id,
                    business_profiles.business_phone,
                    business_profiles.business_description,
                    business_profiles.business_avatar,
                    business_profiles.business_image_cover,
                    business_profiles.business_status_id,
                    ROUND(AVG(customer_reviews.review_star),1) as star,
                    COUNT(CASE  WHEN customer_reviews.business_id > 0 THEN 1 END) as number_of_reviews,
                CASE  WHEN business_profile_locations.business_profile_id > 0 THEN 1 ELSE 0 END as has_location,
                    locations.lat,
                    locations.lng
                FROM
                    `business_profiles`
                    LEFT JOIN business_profile_locations ON business_profile_locations.business_profile_id = business_profiles.id 
                    AND business_profile_locations.business_profile_location_status_id = ?
                    LEFT JOIN locations ON locations.id = business_profile_locations.location_id
                    LEFT JOIN customer_reviews ON customer_reviews.business_id = business_profiles.id 
                WHERE
                    business_profiles.business_status_id = ? 
                    AND business_profiles.id = ? 
                GROUP BY
                    business_profiles.id";
        return $this->getByQuery($query, array(STATUS_ACTIVED, STATUS_ACTIVED, $businessId));
    }
}