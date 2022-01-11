<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mopeninghours extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "opening_hours";
        $this->_primary_key = "id";
    }
    public function saveOpenHours($openingHours = array(), $businessProfileId = 0, $isEdit = false){
        //Save open hours
        if(!empty($openingHours) && $businessProfileId > 0) {
            
            $arrOpenHours = array();
            foreach ($openingHours as $u) {
                $starTime = NULL;
                $expStarTime = explode(':', $u['start_time']);
                if(count($expStarTime) == 3) {
                    $starTime = $u['start_time'];
                } else {
                    if(!empty($u['start_time'])) $starTime = $u['start_time'].':00';
                }
                $endTime = NULL;
                $expEndTime = explode(':', $u['end_time']);
                if(count($expEndTime) == 3) {
                    $endTime = $u['end_time'];
                } else {
                    if(!empty($u['end_time'])) $endTime = $u['end_time'].':00';
                }
                $arrOpenHours[] = array(
                    'business_profile_id' => $businessProfileId,
                    'day_id' => $u['day_id'],
                    'start_time' => $starTime,
                    'end_time' => $endTime,
                    'opening_hours_status_id' => $u['opening_hours_status_id'],
                    'created_at' => getCurentDateTime(),
                    'created_by' => 0
                );
            }

            if($isEdit && count($arrOpenHours) > 0){
                $this->db->delete('opening_hours', array('business_profile_id' => $businessProfileId));
            }
            
            if (count($arrOpenHours) > 0) {
                $this->db->insert_batch('opening_hours', $arrOpenHours);
            }
            return true;
        }
        return false;
    }
    
}