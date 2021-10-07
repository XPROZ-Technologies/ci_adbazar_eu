<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbusinessphotos extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "business_photos";
        $this->_primary_key = "id";
    }

    public function savePhotos($uploadedImage = array(), $businessProfileId = 0){
        if(!empty($uploadedImage) && $businessProfileId > 0) {
            $arrPhotos = array();
            foreach ($uploadedImage as $photo) {
                $arrPhotos[] = array(
                    'business_profile_id' => $businessProfileId,
                    'photo_image' => $photo,
                    'created_at' => getCurentDateTime(),
                    'created_by' => 0,
                    'updated_at' => getCurentDateTime(),
                    'updated_by' => 0

                );
            }
           
            if (!empty($arrPhotos)) $this->db->insert_batch('business_photos', $arrPhotos);
            return true;
        }else{
            return false;
        }
    }
}