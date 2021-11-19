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

    private function buildQuery($postData){
        $query = '';
        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['business_id']) && $postData['business_id'] > 0) $query .=" AND `business_profile_id` = ".$postData['business_id'];
        }
        
        return $query;
    }

    public function getCountInApi($postData){
        $query = "id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function getListInApi($postData, $perPage = 0, $page = 1) {
        $query = "SELECT photo_image FROM business_photos WHERE id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }
}