<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mopeninghours extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "opening_hours";
        $this->_primary_key = "id";
    }
    public function saveOpenHours($openingHours = array(), $businessProfileId = 0){
        //Save open hours
        if(!empty($openingHours) && $businessProfileId > 0) {
            $arrOpenHours = array();
            foreach ($openingHours as $u) {
                $arrOpenHours[] = array(
                    'business_profile_id' => $businessProfileId,
                    'day_id' => $u['day_id'],
                    'start_time' => !empty($u['start_time']) ? $u['start_time'].':00': NULL,
                    'end_time' => !empty($u['end_time']) ? $u['end_time'].':00': NULL,
                    'opening_hours_status_id' => $u['opening_hours_status_id'],
                    'created_at' => getCurentDateTime(),
                    'created_by' => 0
                );
            }
        
            if (!empty($arrOpenHours)) $this->db->insert_batch('opening_hours', $arrOpenHours);
            return true;
        }
        return false;
    }
    
}