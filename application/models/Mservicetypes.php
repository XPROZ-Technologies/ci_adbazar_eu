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
                    WHERE service_types.service_id = ?
                ";
        return $this->getByQuery($query, array($serviceId));
    }

    public function getListServiceTypeSelect2Ajax($serviceId, $searchText){
        $where = '';
        if(!empty($searchText)) $where = " AND service_type_name_en LIKE '%".$searchText."%' ";
        $query = "SELECT * FROM service_types WHERE service_id = ".$serviceId.$where." LIMIT 200";
        return $this->getByQuery($query);
    }
}