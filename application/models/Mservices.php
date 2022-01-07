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
                if(!empty($serviceTypes)) {
                    $this->load->model('Mservicetypes');
                    foreach ($serviceTypes as $u) {
                       $serviceType = array(
                            'service_id' => $serviceId,
                            'updated_by' => $userId,
                            'updated_at' => getCurentDateTime(),
                            'service_type_name_vi' => $u['service_type_name_vi'],
                            'service_type_name_en' => $u['service_type_name_en'],
                            'service_type_name_de' => $u['service_type_name_de'],
                            'service_type_name_cz' => $u['service_type_name_cz'],
                            'display_order' => $u['display_order'],
                            'status_id' => $u['status_id'],

                        );
                        $this->Mservicetypes->save($serviceType, $u['id']);
                    }
                }
        	} else {
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
        $service_name = "service_name_".$this->Mconstants->languageShortCodes[$language];
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
        $service_name = "service_name_".$this->Mconstants->languageShortCodes[$language];
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
        $service_name = "service_name_".$this->Mconstants->languageShortCodes[$language];
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

    public function getListHome($customerId = 0, $langCode = '_vi') {
        $select = "services.id, services.service_name".$this->langCode." as service_name, services.service_image";
        $where = '';
    
        $query = "SELECT ".$select." 
                    FROM services 
                    WHERE services.service_status_id = ? ".$where."
                ";
        return $this->getByQuery($query, array(STATUS_ACTIVED));
    }

    public function getListInApi($customerId = 0, $langCode = '_vi') {
        $select = "services.id, services.service_name".$this->langCode." as service_name, services.service_image";

        $query = "SELECT ".$select." 
                    FROM services 
                    WHERE services.service_status_id = ? ".$where."
                ";
        return $this->getByQuery($query, array(STATUS_ACTIVED));
    }
    // LEFT JOIN services ON services.id = service_types.service_id
    // LEFT JOIN business_profiles ON business_profiles.service_id = service_types.service_id
    public function getServiceTypeInService($businessProfileId = 0, $langCode = '_vi') {
        if($businessProfileId > 0) {
            $where = ' AND business_service_types.business_profile_id = '.$businessProfileId;
            $query = "SELECT
                service_types.service_id,
                service_types.id,
                service_types.service_type_name".$langCode." as service_type_name
            FROM
                business_service_types 
                LEFT JOIN service_types ON business_service_types.service_type_id = service_types.id
            WHERE
                service_types.status_id = ? ".$where;
            $datas = $this->getByQuery($query, array(STATUS_ACTIVED));
            $serviceTypeNames = '';
           
            $serviceType = [];
            $exitServiceTypeName = [];
            foreach($datas as $data) {
                if(!in_array($data['service_type_name'], $exitServiceTypeName)) {
                    $serviceTypeNames .= $data['service_type_name'].', ';
                    $exitServiceTypeName[] = $data['service_type_name'];
                }
                $serviceType[] = array(
                    'id' => $data['id'],
                    'service_type_name' => $data['service_type_name'],
                );

            } 
            return array(
                'serviceTypeNames' => rtrim($serviceTypeNames, ', '),
                'serviceType' => $serviceType
            );

        } else return '';
        
    }

    public function getServiceTypeInServiceAll($serviceId = [], $serviceTypeId = [], $langCode = '_vi') {
        if(count($serviceId) > 0) {
          
            $serviceIds = join(",",$serviceId);
            
            $query = "SELECT
                service_types.service_id,
                service_types.id,
                service_types.service_type_name".$langCode." as service_type_name,
                services.service_name".$langCode." as service_name
            FROM
                  services
            LEFT JOIN service_types ON services.id = service_types.service_id
            WHERE
                service_types.status_id = ? AND services.id IN (".$serviceIds.")
            ORDER BY  service_types.display_order ASC";
            $datas = $this->getByQuery($query, array(STATUS_ACTIVED));
            $serviceTypeNames = '';
            $serviceName = '';
            $serviceType = [];
            $duplcateServiceName = [];
            foreach($datas as $data) {
                if(!in_array($data['service_name'], $duplcateServiceName)) {
                    $serviceName .= $data['service_name'].', ';
                    $duplcateServiceName[] = $data['service_name'];
                }
                
                
                $isSelected = 0;
                if(in_array($data['id'], $serviceTypeId)) {
                    $isSelected = 1;
                }
                $serviceType[] = array(
                    'id' => $data['id'],
                    'service_type_name' => $data['service_type_name'],
                    'is_selected' => $isSelected
                );

            } 
            return array(
                'serviceName' => rtrim($serviceName, ', '),
                'serviceType' => $serviceType
            );

        } else return '';
        
    }
}