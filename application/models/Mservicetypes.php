<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mservicetypes extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "service_types";
        $this->_primary_key = "id";
    }

    public function getList($serviceId) {
        $query = "SELECT
                        service_types.*,
                        business_service_types.service_type_id	as service_type_id
                    FROM
                        service_types
                    LEFT JOIN business_service_types ON business_service_types.service_type_id = service_types.id
                    WHERE service_types.service_id = ? AND service_types.status_id = ?  group by service_types.id
                ";
        return $this->getByQuery($query, array($serviceId, STATUS_ACTIVED));
    }

    public function getListByBusiness($businessId = 0, $service_type_name = "service_type_name_de") {
        $query = "SELECT
                        {$service_type_name} as service_type_name,
                        service_types.id
                    FROM
                        service_types
                    LEFT JOIN business_service_types ON business_service_types.service_type_id = service_types.id
                    WHERE  service_types.status_id = 2 AND  business_service_types.business_profile_id = ?
                ";
        return $this->getByQuery($query, array($businessId));
    }

    public function getListByListBusinessId($postData = array(), $service_type_name = "service_type_name_de") {
        $query = "SELECT
                        DISTINCT
                        {$service_type_name} as service_type_name,
                        service_types.id
                    FROM
                        service_types
                    LEFT JOIN business_service_types ON business_service_types.service_type_id = service_types.id
                    WHERE  service_types.status_id = 2 AND  business_service_types.business_profile_id > 0 ". $this->buildQuery($postData);
        return $this->getByQuery($query);
    }

    public function getSelectedByListBusinessId($businessId = 0, $service_type_name = "service_type_name_de") {
        if($businessId > 0){
            $query = "SELECT
                        DISTINCT
                        service_types.id
                    FROM
                        service_types
                    LEFT JOIN business_service_types ON business_service_types.service_type_id = service_types.id
                    WHERE service_types.status_id = 2 AND  business_service_types.business_profile_id = ". $businessId;
            return $this->getByQuery($query);
        }else{
            return array();
        }
        
    }

    public function getListByServices($postData = array(), $service_type_name = "service_type_name_de") {
        $query = "SELECT
                        DISTINCT
                        {$service_type_name} as service_type_name,
                        service_types.id
                    FROM
                        service_types
                    WHERE status_id = 2 AND service_id > 0 ". $this->buildQuery($postData);
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        
        if(isset($postData['business_profile_ids']) && count($postData['business_profile_ids']) > 0) $query .= " AND business_service_types.business_profile_id IN (".implode(',', $postData['business_profile_ids']).")";
        if(isset($postData['service_ids']) && count($postData['service_ids']) > 0) $query .= " AND service_id IN (".implode(',', $postData['service_ids']).")";
        if(isset($postData['service_id']) && $postData['service_id'] > 0) $query .= " AND service_id = ".$postData['service_id'];
        
        return $query;
    }

    public function getListServiceTypeSelect2Ajax($serviceId, $searchText){
        $where = '';
        if(!empty($searchText)) $where = " AND service_type_name_en LIKE '%".$searchText."%' ";
        $query = "SELECT * FROM service_types WHERE status_id = 2 AND service_id = ".$serviceId.$where." LIMIT 200";
        return $this->getByQuery($query);
    }

    public function getListServiceTypeSelect2AjaxFrontend($serviceId, $service_type_name = "service_type_name_de"){
        $where = '';
        $query = "SELECT id, {$service_type_name} as service_type_name FROM service_types WHERE status_id = 2 AND  service_id = ".$serviceId.$where." LIMIT 50";
        return $this->getByQuery($query);
    }

    public function getServiceTypeInService($serviceId = 0, $langCode = '_vn') {
        $service_name = 'service_type_name'.$langCode;
        $query = "SELECT id, {$service_name} as service_type_name FROM service_types WHERE status_id = ? AND  service_id = ?";
        $datas = $this->getByQuery($query, array(STATUS_ACTIVED, $serviceId));
        $serviceTypeNames = '';
        foreach($datas as $data) {
            $serviceTypeNames .= $data['service_type_name'].', ';

        } 
        return rtrim($serviceTypeNames, ', ');
    }
}