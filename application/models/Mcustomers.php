<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customers";
        $this->_primary_key = "id";
    }

    public function login($userEmail, $customerPass, $loginTypeId = 0){
        if(!empty($userEmail) && !empty($customerPass)){
            $query = "SELECT * FROM customers WHERE customer_password=? AND customer_status_id=? AND customer_email=? LIMIT 1";
            $customers = $this->getByQuery($query, array(md5($customerPass), STATUS_ACTIVED, $userEmail));
            if(!empty($customers)){
                $customer = $customers[0];
                return $customer;
            }
        }
        if(in_array(intval($loginTypeId), [1,2])) {
            $query = "SELECT * FROM customers WHERE customer_email=? AND customer_status_id=?  LIMIT 1";
            $customers = $this->getByQuery($query, array($userEmail, STATUS_ACTIVED));
            if(!empty($customers)){
                $customer = $customers[0];
                return $customer;
            }
        }
        return false;
    }

    public function checkExist($customerId, $email){
        $query = "SELECT id FROM customers WHERE id != ? AND customer_status_id > 0 ";
        $param = array($customerId);
        $flag1 = !empty($email);
        if($flag1){
            $query .= " AND customer_email = ? LIMIT 1";
            $param[] = $email;
        }
        $customer = $this->getByQuery($query, $param);
        if (!empty($customer)) return $customer[0];
        return false;
    }

    public function getCount($postData){
        $query = "customer_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM customers WHERE customer_status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `customer_first_name` LIKE '%{$postData['search_text']}%' OR customer_last_name LIKE '%{$postData['search_text']}%' OR customer_email LIKE '%{$postData['search_text']}%' OR customer_phone LIKE '%{$postData['search_text']}%' OR `customer_address` LIKE '%{$postData['search_text']}%')";
        if(isset($postData['customer_status_id']) && $postData['customer_status_id'] > 0) $query .= " AND customer_status_id = ".$postData['customer_status_id'];
        return $query;
    }

    public function update($postData, $customerId = 0){
        $isUpdate = $customerId > 0;
        $this->db_master = $this->load->database('master', TRUE);
        $this->db_master->trans_begin();
        $customerId = $this->save($postData, $customerId);
        if($customerId > 0){
        }
        if ($this->db_master->trans_status() === false) {
            $this->db_master->trans_rollback();
            return 0;
        }
        else {
            $this->db_master->trans_commit();
            return $customerId;
        }
    }

    public function getListSelect2Ajax($searchText = '') {
        $where = '';
        if(!empty($searchText)) $where = " AND (customer_first_name LIKE '%".$searchText."%' OR customer_last_name LIKE '%".$searchText."%') ";
        $query = "SELECT CONCAT(customer_first_name, ' ', customer_last_name) as full_name, id FROM customers WHERE customer_status_id = 2  ".$where." LIMIT 200";
        return $this->getByQuery($query);
    }

}