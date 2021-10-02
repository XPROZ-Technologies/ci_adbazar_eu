<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mservices extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "services";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "service_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1, $language = 0){
        $query = "SELECT * FROM services WHERE service_status_id > 0" . $this->buildQuery($postData, $language);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData, $language = 0){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( `service_name_vi` LIKE '%{$postData['search_text']}%' || `service_name_en` LIKE '%{$postData['search_text']}%' || `service_name_cz` LIKE '%{$postData['search_text']}%' || `service_name_de` LIKE '%{$postData['search_text']}%')";
        if(isset($postData['service_status_id']) && $postData['service_status_id'] > 0) $query .= " AND service_status_id = ".$postData['service_status_id'];
        if(isset($postData['service_id']) && $postData['service_id'] > 0) $query .= " AND id = ".$postData['service_id'];
        if(isset($postData['service_ids']) && count($postData['service_ids']) > 0) $query .= " AND id IN (".implode(',', $postData['service_ids']).")";
        if(isset($postData['is_hot']) && $postData['is_hot'] > 0) $query .= " AND is_hot = ".$postData['is_hot'];
        return $query;
    }

    public function update($postData, $serviceId, $serviceTypes, $userId) {
        $isUpdate = $serviceId > 0;
        $this->db->trans_begin();
        $serviceId = $this->save($postData, $serviceId);
        if ($serviceId > 0) {
            if($isUpdate){
                $this->db->delete('service_types', array('service_id' => $serviceId));
        	}
            if(!empty($serviceTypes)) {
                $arrServiceType = array();
                foreach ($serviceTypes as $u) {
                	$u['service_id'] = $serviceId;
                    $u['created_by'] = $userId;
                    $u['created_at'] = getCurentDateTime();
                    $u['updated_by'] = $userId;
                    $u['updated_at'] = getCurentDateTime();
                    $arrServiceType[] = $u;
                }
               
                if (!empty($arrServiceType)) $this->db->insert_batch('service_types', $arrServiceType);
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return 0;
        }
        else {
            $this->db->trans_commit();
            return $serviceId;
        }
    }

    public function getHighlightListByLang($language = 0, $isAll = false) {
        if($language == 0) $language = $this->Mconstants->languageDefault;
        $service_name = "service_name_".$this->Mconstants->languageCodes[$language];
        $query = "SELECT id, service_image, service_name_en as service_slug, {$service_name} as service_name FROM services";
        if($isAll){
            $query .= " WHERE is_hot = ".STATUS_ACTIVED." AND service_status_id > 0";
        }else{
            $query .= " WHERE is_hot = ".STATUS_ACTIVED." AND service_status_id = ".STATUS_ACTIVED;
        }
        return $this->getByQuery($query);
    }

    public function getByIds($postData = array(), $language = 0, $isAll = false) {
        if($language == 0) $language = $this->Mconstants->languageDefault;
        $service_name = "service_name_".$this->Mconstants->languageCodes[$language];
        $query = "SELECT id, service_image, service_name_en as service_slug, {$service_name} as service_name FROM services";
        if($isAll){
            $query .= " WHERE service_status_id > 0";
        }else{
            $query .= " WHERE service_status_id = ".STATUS_ACTIVED;
        }
        $query .= $this->buildQuery($postData);
        return $this->getByQuery($query);
    }

    public function getServiceMenus($language = 0) {
        if($language == 0) $language = $this->Mconstants->languageDefault;
        $service_name = "service_name_".$this->Mconstants->languageCodes[$language];
        $query = "SELECT id, service_name_en as service_slug, {$service_name} as service_name FROM services";
        $query .= " WHERE service_status_id > 0";
        
        return $this->getByQuery($query);
    }

    public function getListSelect2Ajax($searchText = '') {
        $where = '';
        if(!empty($searchText)) $where = " AND (service_name_en LIKE '%".$searchText."%') ";
        $query = "SELECT * FROM services WHERE service_status_id = 2  ".$where." LIMIT 200";
        return $this->getByQuery($query);
    }
}