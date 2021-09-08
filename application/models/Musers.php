<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musers extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "users";
        $this->_primary_key = "id";
    }

    public function login($userName, $userPass){
        if(!empty($userName) && !empty($userPass)){
            $query = "SELECT * FROM users WHERE user_pass=? AND status_id=? AND (`user_name`=? OR phone_number=?) LIMIT 1";
            $users = $this->getByQuery($query, array(md5($userPass), STATUS_ACTIVED, $userName, $userName));
            if(!empty($users)){
                $user = $users[0];
                return $user;
            }
        }
        return false;
    }

    public function checkExist($userId, $email, $phoneNumber, $userName = ''){
        $query = "SELECT id FROM users WHERE id != ? AND status_id = ?";
        $param = array($userId, STATUS_ACTIVED);
        $flag1 = !empty($email);
        $flag2 = !empty($phoneNumber);
        $flag3 = !empty($userName);
        if($flag1 && $flag2 && $flag3){
            $query .= " AND (email = ? OR phone_number = ? OR `user_name` = ?) LIMIT 1";
            $param[] = $email;
            $param[] = $phoneNumber;
            $param[] = $userName;
        }
        elseif($flag1 && $flag2){
            $query .= " AND (email = ? OR phone_number = ?) LIMIT 1";
            $param[] = $email;
            $param[] = $phoneNumber;
        }
        elseif($flag1 && $flag3){
            $query .= " AND (email = ? OR `user_name` = ?) LIMIT 1";
            $param[] = $email;
            $param[] = $userName;
        }
        elseif($flag2 && $flag3){
            $query .= " AND (phone_number = ? OR `user_name` = ?) LIMIT 1";
            $param[] = $phoneNumber;
            $param[] = $userName;
        }
        elseif($flag1){
            $query .= " AND email = ? LIMIT 1";
            $param[] = $email;
        }
        elseif($flag2){
            $query .= " AND phone_number = ? LIMIT 1";
            $param[] = $phoneNumber;
        }
        elseif($flag3){
            $query .= " AND `user_name` = ? LIMIT 1";
            $param[] = $userName;
        }
        $users = $this->getByQuery($query, $param);
        if (!empty($users)) return true;
        return false;
    }

    public function getCount($postData){
        $query = "status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM users WHERE status_id > 0" . $this->buildQuery($postData);
        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';
        if(isset($postData['search_text']) && !empty($postData['search_text'])) $query.=" AND ( `user_name` LIKE '%{$postData['user_name']}%' OR full_name LIKE '%{$postData['full_name']}%' OR email LIKE '%{$postData['email']}%' OR phone_number LIKE '%{$postData['phone_number']}%' OR `address` LIKE '%{$postData['address']}%')";
        if(isset($postData['status_id']) && $postData['status_id'] > 0) $query .= " AND status_id = ".$postData['status_id'];
        return $query;
    }

    public function update($postData, $userId = 0){
        $isUpdate = $userId > 0;
        $this->db_master = $this->load->database('master', TRUE);
        $this->db_master->trans_begin();
        $userId = $this->save($postData, $userId);
        if($userId > 0){
        }
        if ($this->db_master->trans_status() === false) {
            $this->db_master->trans_rollback();
            return 0;
        }
        else {
            $this->db_master->trans_commit();
            return $userId;
        }
    }

}