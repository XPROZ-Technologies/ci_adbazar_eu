<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->db_slave = $this->load->database('slave', TRUE);
        $this->db_master = $this->load->database('master', TRUE);
        if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Bangkok');
        // $user = $this->Musers->get(1); $this->session->set_userdata('user', $user);
      
    }

    protected function commonData($user, $title, $data = array()){
        $data['user'] = $user;
        $data['title'] = $title;
        $data['listActions'] = $this->Mactions->getByUserId($user['id']);
        return $data;
    }

    protected function commonDataCustomer($title, $data = array()){
        $data['customer'] = $this->checkLoginCustomer();
        $data['title'] = $title;
        $this->load->model('Mservices');
        $this->load->model('Mconfigs');
        if($data['customer']['language_id'] == 0) $language_id = $this->Mconstants->languageDefault; else $language_id = $data['customer']['language_id'];
        $data['configs'] = $this->Mconfigs->getListMap();
        
        $data['menuServices'] = $this->Mservices->getServiceMenus($language_id);
        $data['language_id'] =  $language_id;
        $this->load->model('Mcustomernotifications');
        $data['notiBadge'] = $this->Mcustomernotifications->getCount(array('customer_id' => $data['customer']['id'], 'notification_status_id' => STATUS_ACTIVED));
        $data['notiHeader'] = $this->getNotificationLists(array('customer_id' => $data['customer']['id']), 5, 1);

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
    protected function checkLoginCustomer($language_id = 0) {
        $this->load->helper('cookie');
        $customers = json_decode($this->input->cookie('customer', true), true);
        if (isset($customers) && $customers['id'] > 0) {
            // check login customer
            $this->load->model('Mcustomers');
            $customers = $this->Mcustomers->get($customers['id'], true, "", "customer_email, customer_first_name, customer_last_name, customer_avatar, customer_phone, customer_phone_code, id, language_id, login_type_id");
            $customers['is_logged_in'] = 1;
            $customers['language_id'] = $customers['language_id'] == 0 ? 1 : $customers['language_id'];
            $customers['language_name'] = $customers['language_id'] == 0 ? 'english' : $this->Mconstants->languageCodes[$customers['language_id']];
        } else {
            // customer not login
            if (empty($customers) || $customers == NULL) {
                // nếu customer ko chọn ngôn ngữ sẽ gán ngôn ngữ tiếng anh
                $customers = array('language_id' => 1, 'language_name' => 'english', 'id' => 0);
            } else {
                $customers = array('language_id' => $customers['language_id'], 'language_name' => $customers['language_name'], 'id' => 0);
            }
            $customers['is_logged_in'] = 0;
        }
        if($language_id > 0){
            $customers['language_id'] = $language_id;
            $customers['language_name'] = $this->Mconstants->languageCodes[$language_id];
        }
        $this->input->set_cookie($this->configValueCookie('customer', json_encode($customers)));
        return $customers;
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

    protected function configValueCookie($name = 'customer', $value = '', $expire = '7200') {
        return array(
            'name'   => $name,
            'value'  => $value , //json_encode(array('language_id' => $languageId, 'language_name' => $language, 'id' => 0)),                            
            'expire' => $expire

        );
    }

    /**
     * Check business open or closed
    */
    protected function checkBusinessOpenHours($businessId = 0){
        return true;
    } 

    /**
     * Send email
     */

    protected function sendMail($emailFrom, $nameFrom, $emailTo, $nameTo, $subject, $message){
        //$this->load->library('email');
        // $config = Array(
        //     'protocol'  => 'smtp',
        //     'smtp_host' => 'ssl://smtp.googlemail.com',
        //     'smtp_port' => '465',
        //     'smtp_user' => 'mailout.dkh@gmail.com',
        //     'smtp_pass' => 'fqvpygxkmeotvqfz',
        //     'mailtype'  => 'html',
        //     'starttls'  => true,
        //     'newline'   => "\r\n"
        // );

        //smtpout.asia.secureserver.net

        $config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtpout.asia.secureserver.net',
            'smtp_port' => '465',
            'smtp_user' => 'server@adbazar.eu',
            'smtp_pass' => 'changeM3!!Adbazar12345',
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
        );

        $this->load->library('email', $config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($emailFrom, $nameFrom);
        $this->email->to($emailTo, $nameTo);
        $this->email->subject($subject);
        $this->email->message($message);
        if($this->email->send()) return true;
        return false;
    }

    /**
     * example
     * example public function index() {
     *    $flag =  $this->sendMail('facebook12636@gmail.com', 'man', 'haminhman2011@gmail.com', 'Gửi mail', 'ahhihi');
     *    echo 'kkk'.$flag;die;
     * }
     */

     /**
      * Custom Upload without POST
      */

    public function uploadImageBase64($fileBase64 = "", $fileTypeId = 0){
	    if(!empty($fileBase64) & $fileTypeId > 0){
            $fileBase64 = str_replace('[removed]', '', $fileBase64);
            $dir = '';
            $fileExt = 'png';
	        if($fileTypeId == 1) $dir = PRODUCT_PATH;
            elseif($fileTypeId == 2) $dir = USER_PATH;
	        elseif($fileTypeId == 3) $dir = CUSTOMER_PATH;
            elseif($fileTypeId == 4) $dir = SLIDER_PATH;
            elseif($fileTypeId == 5) $dir = CONFIG_PATH;
            elseif($fileTypeId == 6) $dir = SERVICE_PATH;
            elseif($fileTypeId == 7) $dir = BUSINESS_PROFILE_PATH; 
            elseif($fileTypeId == 8) $dir = COUPONS_PATH;
            elseif($fileTypeId == 9) $dir = EVENTS_PATH;
	       
            if(!empty($dir)){
                $dir = $dir . date('Y-m-d') . '/';
                @mkdir($dir, 0777, true);
                @system("/bin/chown -R nginx:nginx ".$dir);
                if($fileExt == 'png') $fileBase64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $fileBase64));
                else $fileBase64 = base64_decode(preg_replace('#^data:application/\w+;base64,#i', '', $fileBase64));
                $filePath = $dir . uniqid() . '.' . $fileExt;
                $flag = file_put_contents($filePath, $fileBase64);
                if($flag !== false) {
                    return $filePath;
                }
            }
            
        }
        return "";
    }

    public function getLanguageFE() {
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('login', $this->language);
        $this->lang->load('customer', $this->language);
        $this->lang->load('business_profile', $this->language);
        $this->lang->load('business_management', $this->language);
        $this->lang->load('user_account_management', $this->language);
    }

    public function getNotificationLists($searchData = array(), $perPage = 50, $page = 0)
    {
        $this->loadModel(array('Mbusinessprofiles', 'Mcustomernotifications', 'Mcustomers', 'Mcustomerreservations', 'Mcustomerreviews'));
        
        $lists = $this->Mcustomernotifications->search($searchData, $perPage, $page);
      
        if (!empty($lists)) {
            foreach($lists as $i => $notificationInfo){
            
                $notificationText = "";
                $notificationImg = CUSTOMER_PATH . NO_IMAGE;
                if($notificationInfo['notification_type'] == 0){
                   //busines has review
                   $customerImg = $this->Mcustomers->getFieldValue(array('id' =>  $notificationInfo['customer_id']), 'customer_avatar', '');
                   if(!empty($customerImg)){
                    $notificationImg = CUSTOMER_PATH . $customerImg;
                   }
                   $businessName = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_name', '');
                   $notificationText = $businessName." had just a review";
                }else if($notificationInfo['notification_type'] == 1){
                    // business reply customer review
                    $businessImg = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_avatar', '');
                    if(!empty($businessImg)){
                        $notificationImg = BUSINESS_PROFILE_PATH . $businessImg;
                    }
                    $businessName = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_name', '');
                    $notificationText = $businessName." replied to your comment";
                }else if($notificationInfo['notification_type'] == 2){
                }else if($notificationInfo['notification_type'] == 3){
                }else if($notificationInfo['notification_type'] == 4){
                    // customer cancel reservation
                    $customerImg = $this->Mcustomers->getFieldValue(array('id' =>  $notificationInfo['customer_id']), 'customer_avatar', '');
                    if(!empty($customerImg)){
                        $notificationImg = CUSTOMER_PATH . $customerImg;
                    }
                    $reservationCode = $this->Mcustomerreservations->getFieldValue(array('id' => $notificationInfo['item_id']), 'book_code', '');
                    $notificationText = "Reservation ".$reservationCode." has been cancelled";
                }else if($notificationInfo['notification_type'] == 5){
                }else if($notificationInfo['notification_type'] == 6){
                }else if($notificationInfo['notification_type'] == 7){
                    // business decline reservation
                    $businessImg = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_avatar', '');
                    if(!empty($businessImg)){
                        $notificationImg = BUSINESS_PROFILE_PATH . $businessImg;
                    }
                    $businessName = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_name', '');
                    $reservationCode = $this->Mcustomerreservations->getFieldValue(array('id' => $notificationInfo['item_id']), 'book_code', '');
                    $notificationText = "Reservation ".$reservationCode." at ".$businessName." has been declined";
                }
                    
                $lists[$i]['text'] = $notificationText;
                $lists[$i]['image'] = $notificationImg;
            }
        }
        return $lists;
    }

    public function getBusinessRating($businessProfileId = 0){
        $data = array();

        if($businessProfileId > 0){
            $this->load->model('Mcustomerreviews');
            $data['count_one_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 1
            ));

            $data['count_two_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 2
            ));

            $data['count_three_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 3
            ));

            $data['count_four_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 4
            ));

            $data['count_five_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 5
            ));

            $sumReview = ($data['count_one_star'] + $data['count_two_star'] + $data['count_three_star'] + $data['count_four_star'] + $data['count_five_star']);
            $data['sumReview'] = $sumReview;
            $data['overall_rating'] = 0;
            if ($sumReview > 0) {
                $data['overall_rating'] = ($data['count_one_star'] * 1 + $data['count_two_star'] * 2 + $data['count_three_star'] * 3 + $data['count_four_star'] * 4 + $data['count_five_star'] * 5) / ($data['count_one_star'] + $data['count_two_star'] + $data['count_three_star'] + $data['count_four_star'] + $data['count_five_star']);
            }
        }
        
        return $data;
    }
}