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

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM services WHERE service_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query .=" AND ( `service_name` LIKE '%{$postData['search_text']}%')";
        if(isset($postData['service_status_id']) && $postData['service_status_id'] > 0) $query .= " AND service_status_id = ".$postData['service_status_id'];
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
}