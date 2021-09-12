<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Bangkok');
        // $user = $this->Musers->get(1); $this->session->set_userdata('user', $user);
      
    }

    protected function commonData($user, $title, $data = array()){
        $data['user'] = $user;
        $data['title'] = $title;
        $data['listActions'] = $this->Mactions->getByUserId($user['id']);
        return $data;
    }

    // check login phía quản trị
    protected function checkUserLogin($isApi = false){
        $user = $this->rsession->get('user');
        if($user){
            $statusId = STATUS_ACTIVED;// $this->Musers->getFieldValue(array('UserId' => $user['UserId']), 'StatusId', 0);
            if($statusId == STATUS_ACTIVED) {
                return $user;
            } 
            else{
                $this->rsession->delete('user');
                //$fields = array('user', 'configs');
                //foreach($fields as $field) $this->session->unset_userdata($field);
                if($isApi) echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
                else redirect('sys-admin?redirectUrl='.current_url());
                die();
            }
        }
        else{
            if($isApi) echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
            else redirect('sys-admin?redirectUrl='.current_url());
            die();
        }
    }

    // check ngôn ngữ và login phía customer (end user)
    protected function checkLoginCustomer() {
        $this->load->helper('cookie');
        $customers = json_decode($this->input->cookie('customer', true), true);
        if (isset($customers) && $customers['id'] > 0) {
            // check login customer
        } else {
            // customer not login
            if (empty($customers) || $customers == NULL) {
                // nếu customer ko chọn ngôn ngữ sẽ gán ngôn ngữ tiếng anh
                $customers = json_encode(array('language_id' => 1, 'language_name' => 'english', 'id' => 0));
            } else {
                $customers = json_encode(array('language_id' => $customers['language_id'], 'language_name' => $customers['language_name'], 'id' => 0));
            }
        }
        $this->input->set_cookie($this->configValueCookie('customer', $customers));
        return json_decode($customers, true);
    }

    protected function loadModel($models = array()){
        foreach($models as $model) $this->load->model($model);
    }

    protected function arrayFromPost($fields) {
        $data = array();
        foreach ($fields as $field) $data[$field] = trim($this->input->post($field));
        return $data;
    }

    protected function arrayFromGet($fields) {
        $data = array();
        foreach ($fields as $field) $data[$field] = trim($this->input->get($field));
        return $data;
    }

    protected function checkPermission($roleId) {
        $flag = false;
        if($roleId == 1) $flag = true;
        return $flag;
    }

    //api
    protected function openAllCors(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        //header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        header('Access-Control-Allow-Headers: *');
        $this->logError();
    }

    protected function arrayFromPostRawJson($fields) {
        $data = json_decode(file_get_contents('php://input'), true);
        $outPut = array();
        foreach ($fields as $field) {
            if(isset($data[$field])){
                $outPut[$field] = ($data[$field]);
            }
            else $outPut[$field] = null;
        }
        return $outPut;
    }

    protected function logError(){
        log_message('error', $this->router->fetch_class().'/'.$this->router->fetch_method().': Server: '.json_encode($_SERVER));
        log_message('error', $this->router->fetch_class().'/'.$this->router->fetch_method().': Input: '.file_get_contents('php://input'));
        log_message('error', '=======================================');
    }

    protected function configValueCookie($name = 'customer', $value = '') {
        return array(
            'name'   => $name,
            'value'  => $value , //json_encode(array('language_id' => $languageId, 'language_name' => $language, 'id' => 0)),                            
            'expire' => '7200'

        );
    }


}