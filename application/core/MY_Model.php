<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $_table_name = '';
    protected $_primary_key = '';

    function __construct() {
        parent::__construct();
        $this->db_slave = $this->load->database('slave', TRUE);
        $this->db_master = $this->load->database('master', TRUE);
    }

    public function get($id = 0, $single = false, $orderBy = "", $select = "", $limit = 0, $offset = 0, $orderType = 'desc') {
        if(!empty($select)) $this->db_slave->select($select);
        if ($id > 0) {
            $this->db_slave->where($this->_primary_key, $id);
            $method = 'row_array';
        }
        elseif ($single == TRUE) $method = 'row_array';
        else {
            $method = 'result_array';
            if ($offset > 0 && $limit > 0) $this->db_slave->limit($limit, $offset);
            elseif ($limit > 0) $this->db_slave->limit($limit);
            if (!empty($orderBy)) $this->db_slave->order_by($orderBy, $orderType);
        }
        return $this->db_slave->get($this->_table_name)->$method();
    }

    public function getBy($where, $single = false, $orderBy = "", $select = "", $limit = 0, $offset = 0, $orderType = 'desc') {
        $this->db_slave->where($where);
        return $this->get(0, $single, $orderBy, $select, $limit, $offset, $orderType);
    }

    public function getByQuery($query, $param = array()){
        if(!empty($query)){
            return $this->db_slave->query($query, $param)->result_array();
        }
        return array();
    }

    public function getListFieldValue($where, $tableField){
        $retVal = array();
        $records = $this->getBy($where, false, '', $tableField);
        foreach($records as $rd) $retVal[] = $rd[$tableField];
        return $retVal;
    }

    public function getFieldValue($where, $tableField, $defaultValue = '') {
        $query = $this->db_slave->select($tableField)->where($where)->get($this->_table_name);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->$tableField;
        }
        return $defaultValue;
    }

    public function countRows($where) {
        $this->db_slave->select($this->_primary_key);
        $this->db_slave->where($where);
        $query = $this->db_slave->get($this->_table_name);
        if($query->num_rows() > 0) return $query->num_rows();
        return 0;
    }

    public function save($data, $id = 0, $fieldNull = array()) {
        if ($id == 0) {
            foreach($fieldNull as $field){
                if(!isset($data[$field]) || empty($data[$field])){
                    $this->db_master->set($field, null);
                    unset($data[$field]);
                }
            }
            $this->db_master->insert($this->_table_name, $data);
            return $this->db_master->insert_id();
        }
        else {
            foreach($fieldNull as $field){
                if(!isset($data[$field]) || empty($data[$field])){
                    $this->db_master->set($field, null);
                    unset($data[$field]);
                }
            }
            $this->db_master->where($this->_primary_key, $id);
            $this->db_master->update($this->_table_name, $data);
            return $id;
        }
    }

    public function changeStatus($statusId, $id, $fieldName = 'status_id', $updateUserId = 0, $deleteAt = 0){
        $retVal = false;
        if($statusId >= 0 && $id > 0){
            if(empty($fieldName)) $fieldName = 'status_id';
            if($updateUserId > 0) $id =  $this->save(array($fieldName => $statusId, 'updated_by' => $updateUserId, 'updated_at' => getCurentDateTime()), $id);
            if($deleteAt > 0) $id =  $this->save(array($fieldName => $statusId, 'updated_by' => $updateUserId, 'deleted_at' => getCurentDateTime()), $id);
            else $id = $this->save(array($fieldName => $statusId), $id);
            $retVal = $id > 0;
        }
        return $retVal;
    }

    public function changeIsHot($isHot, $id, $fieldName = 'is_hot', $updateUserId = 0){
        $retVal = false;
        if($isHot != '' && $id > 0){
            if(empty($fieldName)) $fieldName = 'is_hot';
            if($updateUserId > 0) $id =  $this->save(array($fieldName => $isHot, 'updated_by' => $updateUserId, 'updated_at' => getCurentDateTime()), $id);
            else $id = $this->save(array($fieldName => $isHot), $id);
            $retVal = $id > 0;
        }
        return $retVal;
    }

    public function updateBy($where, $data) {
        $this->db_master->where($where);
        return $this->db_master->update($this->_table_name, $data);
    }

    public function delete($id) {
        if ($id > 0){
            $this->db_master->where($this->_primary_key, $id);
            $this->db_master->limit(1);
            $this->db_master->delete($this->_table_name);
            return true;
        }
        return false;
    }

    public function deleteMultiple($where) {
        $this->db_master->where($where);
        $this->db_master->delete($this->_table_name);
    }

    

    public function prettyPrint($result){
		$dom = new DOMDocument("1.0");
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;	
		$dom->loadXML(simplexml_load_string($result)->asXML());

		return $dom->saveXML();
	}
}