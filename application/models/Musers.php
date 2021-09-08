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



    public function selectHtml($listUsers, $selectName, $objId = 0, $isAll = false, $txtAll = "", $isDisable = false, $isShowPhone = true, $attrSelect = ''){
        $id = str_replace('[]', '', lcfirst($selectName));
        echo '<select class="form-control select2" name="'.$selectName.'" id="'.$id.'"'.$attrSelect.'>';
        if($isAll){
            if(empty($txtAll)) echo '<option value="0">Tất cả</option>';
            else echo '<option value="0">'.$txtAll.'</option>';
        }
        $isSelectMutiple = is_array($objId);
        foreach($listUsers as $obj){
            $selected = '';
            if(!$isSelectMutiple) {
                if ($obj['id'] == $objId) $selected = ' selected="selected"';
            }
            elseif(in_array($obj['id'], $objId)) $selected = ' selected="selected"';
            if($isDisable && $obj['status_id'] != STATUS_ACTIVED) $selected .= ' disabled';
            if($isShowPhone && !empty($obj['phone_number'])) echo '<option value="'.$obj['id'].'"'.$selected.'>'.$obj['full_name'].' - '.$obj['phone_number'].'</option>';
            else echo '<option value="'.$obj['id'].'"'.$selected.'>'.$obj['full_name'].'</option>';
        }
        echo '</select>';
    }

    public function searchByFilter($searchText, $itemFilters, $limit, $page){
        $queryCount = "select users.id AS totalRow from users {joins} where {wheres}";
        $query = "select {selects} from users {joins} where {wheres} ORDER BY users.created_at DESC LIMIT {limits}";
        $selects = [
            'users.*'
        ];
        $joins = [
        ];
        $wheres = array('status_id > 0');
        $dataBind = [];
        
        $whereSearch= '';
        $searchText = strtolower($searchText);
        //search theo text
        if(!empty($searchText)){
            if(preg_match('/\d{4}-\d{2}-\d{2}/im',$searchText)){
                $whereSearch = 'users.created_at like ?';
                $dataBind[] = "$searchText%";
            }
            else{
                $whereSearch = 'users.user_name like ? or users.full_name like ? or users.email like ? or users.phone_number like ?';
                for( $i = 0; $i < 4; $i++) $dataBind[] = "%$searchText%";
            }
        }
        if(!empty($whereSearch)) {
            $whereSearch = "( $whereSearch )";
            $wheres[] = $whereSearch;
        }
        //search theo bộ lọc ,
        if (!empty($itemFilters) && count($itemFilters)) {
            foreach ($itemFilters as $item) {
                $filed_name = $item['field_name'];
                $conds = $item['conds'];
                //$cond[0] là điều kiện ví dụ : < > = like .....   $cons[1] và $cond[2]  là gía trị điều kiện như 2017-01-02 và 2017-01-01
                switch ($filed_name) {
                    case 'user_status':
                        $wheres[] = "users.status_id $conds[0] ?";
                        $dataBind[] = $conds[1];
                        break;
                    case 'user_create_date':
                        if ($conds[0] == 'between') {
                            $wheres[] = 'users.created_at between ? and ?';
                            $dataBind[] = @ddMMyyyyToDate($conds[1]);
                            $dataBind[] = @ddMMyyyyToDate($conds[2], 'd/m/Y', 'Y-m-d 23:59:59');
                        }
                        elseif($conds[0] == '<'){
                            $wheres[] = "users.created_at < ?";
                            $dataBind[] = @ddMMyyyyToDate($conds[1], 'd/m/Y', 'Y-m-d 23:59:59');
                        }
                        elseif($conds[0] == '>'){
                            $wheres[] = "users.created_at > ?";
                            $dataBind[] = @ddMMyyyyToDate($conds[1]);
                        }
                        else{
                            $wheres[] = "DATE(users.created_at) $conds[0] ?";
                            $dataBind[] = $conds[1];
                        }
                        break;
                    default :
                        break;
                }
            }
        }
        $selects_string = implode(',', $selects);
        $wheres_string = implode(' and ', $wheres);
        $joins_string = implode(' ', $joins);
        $query = str_replace('{selects}', $selects_string, $query);
        $query = str_replace('{joins}', $joins_string, $query);
        $query = str_replace('{wheres}', $wheres_string, $query);
        $query = str_replace('{limits}', $limit * ($page - 1) . "," . $limit, $query);
        $queryCount = str_replace('{joins}', $joins_string, $queryCount);
        $queryCount = str_replace('{wheres}', $wheres_string, $queryCount);
        if (count($wheres) == 0){
            $query = str_replace('where', '', $query);
            $queryCount = str_replace('where', '', $queryCount);
        }
        $dataStaffs = $this->getByQuery($query, $dataBind);
        $userStatus = $this->Mconstants->userStatus;
        $labelCss = $this->Mconstants->labelCss;
        for ($i = 0; $i < count($dataStaffs); $i++) {
            $dataStaffs[$i]['status_name'] = $dataStaffs[$i]['status_id'] > 0 ? $this->Mconstants->userStatus[$dataStaffs[$i]['status_id']] : '';
            $dataStaffs[$i]['created_at'] = ddMMyyyy($dataStaffs[$i]['created_at'], 'd/m/Y');
            $dataStaffs[$i]['label_css'] = $labelCss; 
        }
        $data = array();
        $totalRows = $this->getByQuery($queryCount, $dataBind);
        $totalRow = count($totalRows);
        $totalIds = array();
        foreach ($totalRows as $v) $totalIds[] = intval($v['totalRow']);
        $pageSize = ceil($totalRow / $limit);
        $data['dataTables'] = $dataStaffs;
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        $data['callBackTable'] = 'renderContentStaffs';
        $data['callBackTagFilter'] = 'renderTagFilter';
        $data['totalRow'] = $totalRow;
        $data['totalIds'] = json_encode($totalIds);
        return $data;
    }
}