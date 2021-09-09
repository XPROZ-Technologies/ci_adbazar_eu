<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconfigs extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "configs";
        $this->_primary_key = "id";
    }

    public function getListMap($autoLoad = 1, $languageId = 1){
        $langCode = '';
        $select = "config_code, config_value";
        if($languageId == 2){
            $langCode = '_en';
            $select = "config_code, config_value_en";
        };
        $configs = $this->getBy(array('auto_load' => $autoLoad), false, "", $select);
        $retVal = array();
        foreach($configs as $cf) {
            if($languageId == 2){
                $retVal[$cf['config_code']] = $cf['config_value_en'];
            } else {
                $retVal[$cf['config_code']] = $cf['config_value'];
            }
        } 
        return $retVal;
    }

    public function getConfigValue($configCode, $defaultValue){
        return $this->getFieldValue(array('config_code' => $configCode), 'config_value', $defaultValue);
    }

    public function updateBatch($valueData){
        if(!empty($valueData)){
            $this->db_master->update_batch('configs', $valueData, 'id');
        }
        return true;
    }

    public function updateItem($configCode, $configValue, $userId){
        $this->db_master->update('configs', array('config_value' => $configValue, 'updated_by' => $userId, 'updated_at' => getCurentDateTime()), array('config_code' => $configCode));
        return true;
    }
}
