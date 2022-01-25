<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
       
        $this->fb = new Facebook\Facebook([
            'app_id' => FACEBOOK_ID,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => GRAPH_version,
        ]);

        $this->client = new Google_Client();
        $this->client->setClientId(KEY_GG.'.apps.googleusercontent.com');
        $this->client->setClientSecret(GOOGLE_SECRET);
        // $this->client->setRedirectUri(REDIRECT_URI);
        $this->client->addScope("email");
        $this->client->addScope("profile");

        $this->service = new Google_Service_Oauth2($this->client);

    }

    public function login() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('login_type_id', 'customer_email', 'customer_password', 'facebook_token', 'google_token', 'apple_token', 'device_token', 'customer_first_name', 'customer_last_name'));
            $this->load->model('Mcustomers');
            $customer = [];
            $customerNewId = 0;
            if(intval($postData['login_type_id']) == 0) {
                if(empty($postData['customer_email'])) {
                    $this->error204($this->lang->line('please_enter_your_email'));
                    die;
                }
                if(!checkemail($postData['customer_email'])) {
                    $this->error204('Email not exist');
                    die;
                }
                if(empty($postData['customer_password'])) {
                    $this->error204($this->lang->line('your_password_does_not_match_please_try_again.'));
                    die;
                }
                
                
                $customer = $this->Mcustomers->login($postData['customer_email'], $postData['customer_password']);
                
            } else if (intval($postData['login_type_id']) == 1) { // facebook
                
                if(empty($postData['facebook_token'])) {
                    $this->error204($this->lang->line('graph_returned_an_error'));
                   die;
                }
                $postData['facebook_id'] = $postData['facebook_token'];
                $postData['customer_first_name'] = isset($postData['customer_first_name']) ? $postData['customer_first_name'] : '';
                $postData['customer_last_name'] = isset($postData['customer_last_name']) ? $postData['customer_last_name'] : '';
                $customer = $this->Mcustomers->login($postData['facebook_id'], '', $postData['login_type_id']);
                
                if(!$customer) {
                   $customerCheck = $this->Mcustomers->getFieldValue(array('facebook_id' =>  $postData['facebook_id'], 'customer_status_id' => STATUS_ACTIVED), 'customer_status_id', 0);
                   if($customerCheck == 1) {
                        $this->error204($this->lang->line('login_please_active_your_account_email_link'));
                        die;
                   }
                   $customerNewId = 0;
                   $customer['id'] = 0;
                   $postData['customer_status_id'] = STATUS_WAITING_ACTIVE; 
                }
                $customerNewId = $customer['id'];
            } else if (intval($postData['login_type_id']) == 2) { // google
                $this->client->setAccessToken($postData['google_token']);
                try {
                    $googleInfo = $this->service->userinfo->get();
                    if($googleInfo) {
                        $info = json_decode(json_encode($googleInfo, true),true);
                        $postData['google_id'] = $info['id'];
                        $postData['customer_last_name'] = $info['name'];
                        $postData['customer_email'] = $info['email'];
                        $postData['customer_status_id'] = STATUS_ACTIVED;
                        $customer = $this->Mcustomers->login($postData['customer_email'], '', $postData['login_type_id']);
                        if(!$customer) {
                            $customerNewId = 0;
                            $customer['id'] = 0;
                        } 
                    } else {
                        $this->error204($this->lang->line('graph_returned_an_error'));
                        die;
                    }
                } catch (\Throwable $th) {
                    $this->error204($this->lang->line('google_sdk_returned_an_error'));
                    die;
                }
            } else if (intval($postData['login_type_id']) == 3) { // apple
                if(empty($postData['apple_token'])) {
                    $this->error204($this->lang->line('graph_returned_an_error'));
                    die;
                }

                $token = $this->Mconstants->decodeTokenJwtApple($postData['apple_token']); 
                if (count($token) == 0){
                    $this->error204($this->lang->line('graph_returned_an_error'));
                    die;
                } 
                $postData['apple_id'] = $token['sub'];
                $postData['customer_first_name'] = isset($postData['customer_first_name']) ? $postData['customer_first_name'] : '';
                $postData['customer_last_name'] = isset($postData['customer_last_name']) ? $postData['customer_last_name'] : '';
                $customer = $this->Mcustomers->login($postData['apple_id'], '', $postData['login_type_id']);
                
                if(!$customer) {
                   $customerCheck = $this->Mcustomers->getFieldValue(array('apple_id' =>  $postData['apple_id'], 'customer_status_id' => STATUS_ACTIVED), 'customer_status_id', 0);
                   if($customerCheck == 1) {
                        $this->error204($this->lang->line('login_please_active_your_account_email_link'));
                        die;
                   }
                   $customerNewId = 0;
                   $customer['id'] = 0;
                   $postData['customer_status_id'] = STATUS_WAITING_ACTIVE; 
                }

                $customerNewId = $customer['id'];
            }

            if($customer) {
                $flag = false;
                if ($customer) {
                    $this->load->library('Authorization_Token');
                    // generte a token
                    $token = $this->authorization_token->generateToken(array('id' => $customer['id'], 'created_at' => getCurentDateTime()));
                    $postData['token'] = $token;
                    $postData['language_id'] = $this->languageId;
                    $postData['device_token'] = isset($postData['device_token']) ? $postData['device_token'] : NULL;
                    unset($postData['apple_token'], $postData['facebook_token'], $postData['google_token'], $postData['customer_password'], $postData['customer_email'], $postData['customer_first_name'], $postData['customer_last_name']);
                   $flag = $this->Mcustomers->save($postData, $customer['id']);
                }
                if($flag) {
                    $customer = $this->Mcustomers->get($flag);
                    if(empty($customer['customer_avatar'])) $customer['customer_avatar'] = base_url(CUSTOMER_PATH.NO_IMAGE);
                    else $customer['customer_avatar'] = base_url(CUSTOMER_PATH.$customer['customer_avatar']);
                    unset($customer['device_token'], $customer['token_reset'], $customer['customer_password'], $customer['created_at'], $customer['created_by'], $customer['updated_at'],  $customer['updated_by'],  $customer['deleted_at']);
                    $needEmail = 0;
                    if($customerNewId == 0 && in_array(intval($postData['login_type_id']), [1,3])) {
                        $needEmail = 1;
                    }
                    $this->success200(array('customer' => $customer, 'need_email' => $needEmail));
                }
                
            } else {
                $this->error204($this->lang->line('you_entered_an_invalid_email_or_password'));
                die;
            }
            
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function logout() {
        try {
            $this->openAllCors();
            $token = $this->getAuthorizationHeader();
            // $token = $this->input->get_request_header('X-Auth-Token', TRUE);
            if(empty($token)) {
                $this->error410($this->lang->line('token_has_not_been_uploaded_yet'));
                die;
            }else {
                $this->load->model('Mcustomers');
                $customerId = $this->Mcustomers->getFieldValue(array('token' => $token, 'device_token' => NULL), 'id', 0);
                if(!$customerId) {
                    $this->error204($this->lang->line('token_does_not_exist'));
                    die;
                } else {
                    $flag = $this->Mcustomers->save(array('token' => '', 'updated_at' => getCurentDateTime()), $customerId);
                    if($flag) $this->success200($customerId, $this->lang->line('logout_successful'));
                    else $this->error500();
                }
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function sign_up(){
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('login_type_id', 'customer_email', 'customer_password', 'confirm_password' , 'google_token', 'facebook_token', 'apple_token'));
            $this->load->model('Mcustomers');
            $data = [];
            if (intval($postData['login_type_id']) == 0) {
                if (empty($postData['customer_email'])) {
                    $this->error204($this->lang->line('please_enter_a_valid_email.'));
                    die;
                }
                if(!checkemail($postData['customer_email'])) {
                    $this->error204($this->lang->line('email_does_not_exist'));
                    die;
                }
                $this->validatePassWord($postData);
               
                $customer = $this->Mcustomers->checkExist(0, $postData['customer_email']);
                if($customer) {
                    $this->error204($this->lang->line('email_already_exists_in_the_system'));
                    die;
                }
                $data['customer_password'] =  md5($postData['customer_password']);
                $data['customer_status_id'] = STATUS_WAITING_ACTIVE; 
            } else if (intval($postData['login_type_id']) == 1) { //facebook
                $data['facebook_id'] = $postData['facebook_token'];
                if(isset($postData['customer_first_name']) && !empty($postData['customer_first_name'])) {
                    $data['customer_first_name'] =  $postData['customer_first_name'];
                }
                if(isset($postData['customer_last_name']) && !empty($postData['customer_last_name'])) {
                    $data['customer_last_name'] =  $postData['customer_last_name'];
                }
                $data['customer_email'] = $postData['customer_email'];
                $data['customer_status_id'] = STATUS_WAITING_ACTIVE; 
            } else if (intval($postData['login_type_id']) == 2) { //google
                
                $this->client->setAccessToken($postData['google_token']);
                try {
                    $googleInfo = $this->service->userinfo->get();
                    if($googleInfo) {
                        $info = json_decode(json_encode($googleInfo, true),true);
                        $data['google_id'] = $info['id'];
                        $data['customer_last_name'] = $info['name'];
                        $data['customer_email'] = $info['email'];
                        $data['customer_password'] = md5('12345678@aM');
                        $data['customer_status_id'] = STATUS_ACTIVED;
                    } else {
                        $this->error204($this->lang->line('graph_returned_an_error'));
                        die;
                    }
                } catch (\Throwable $th) {
                    $this->error204($this->lang->line('google_sdk_returned_an_error'));
                    die;
                }
            }
            else if (intval($postData['login_type_id']) == 3) { // apple
                if(empty($postData['apple_token'])) {
                    $this->error204($this->lang->line('graph_returned_an_error'));
                    die;
                }

                $token = $this->Mconstants->decodeTokenJwtApple($postData['apple_token']); 
                if (count($token) == 0){
                    $this->error204($this->lang->line('graph_returned_an_error'));
                    die;
                } 
                $data['apple_id'] = $token['sub'];
                $data['customer_first_name'] = isset($postData['customer_first_name']) ? $postData['customer_first_name'] : '';
                $data['customer_last_name'] = isset($postData['customer_last_name']) ? $postData['customer_last_name'] : '';
                
                $data['customer_status_id'] = STATUS_WAITING_ACTIVE; 
            }

            $data['login_type_id'] =  $postData['login_type_id'];
            $data['customer_email'] =  strtolower($postData['customer_email']);
          
            if($data) {
                $data['created_at'] = getCurentDateTime();
                $data['created_by'] = 0;
                $data['free_trial'] = STATUS_FREE_TRIAL;
                $token_active = guidV4('reset-passs');
                $data['token_reset'] = $token_active;
                if (intval($postData['login_type_id']) == 0) {
                    $flag = $this->Mcustomers->save($data);
                } else {
                    $customer = $this->Mcustomers->checkExist(0, $postData['customer_email']);
                    $customerId = 0;
                    if ($customer && count($customer) > 0) $customerId = $customer['id'];
                    $flag = $this->Mcustomers->save($data, $customerId);
                }
                if($flag) {
                    // generate a token
                    if (!in_array(intval($postData['login_type_id']), [1,3])) {
                        $this->load->model('Memailqueue');
                        $name = !empty($postData['customer_first_name']) ? $postData['customer_first_name'] : $postData['customer_email'];
                        $dataEmail = array(
                            'name' => $name,
                            'email_to' => $postData['customer_email'],
                            'email_to_name' => $postData['customer_email'],
                            'token' => $token_active
                        );
                        $this->Memailqueue->createEmail($dataEmail, 99);
                    }
                    $this->success200($flag, $this->lang->line('successfully_registered_account'));
                } else {
                    $this->error400($this->lang->line('registration_failed'));
                    die;
                }

            } else {
                $this->error400($this->lang->line('registration_failed'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function facebook_add_email(){
        try {
            $postData = $this->arrayFromPostRawJson(array('customer_email', 'customer_id'));
            $customer_email = strtolower($postData['customer_email']);
            if (empty($customer_email)) {
                $this->error204($this->lang->line('please_enter_a_valid_email'));
                die;
            }
            $this->load->model('Mcustomers');

            // Check existing customer with waiting active and login by facebook
            // $customerId = $this->Mcustomers->getFieldValue(array('id' => $postData['customer_id'], 'login_type_id' => 1, 'customer_status_id' => STATUS_WAITING_ACTIVE), 'id', 0);
            $customer = $this->Mcustomers->get($postData['customer_id']);
            $customerId = ($customer && isset($customer['id'])) ? $customer['id'] : 0;
            if($customerId == 0) {
                $this->error204($this->lang->line('customer_doest_not_exist'));
                die;
            }
            if(!in_array($customer['login_type_id'], [1,3]) && $customer['customer_status_id'] != STATUS_WAITING_ACTIVE) {
                $this->error204($this->lang->line('customer_doest_not_exist'));
                die;
            }   

            // Check email exist on database
            $customer = $this->Mcustomers->checkExist($postData['customer_id'], $customer_email);
            if($customer) {
                $this->error204($this->lang->line('email_already_exists_in_the_system'));
                die;
            }

            // Generate token and send email
            $token_active = guidV4('facebook-add-email');
            $customerId = $this->Mcustomers->save(array('customer_email' => $customer_email, 'token_reset' => $token_active), $postData['customer_id']);
            if($customerId > 0) {
                $this->load->model('Memailqueue');
                $dataEmail = array(
                    'name' => $postData['customer_email'],
                    'email_to' => $postData['customer_email'],
                    'email_to_name' => $postData['customer_email'],
                    'token' => $token_active
                );
                $this->Memailqueue->createEmail($dataEmail, 99);
                $this->success200($customerId, $this->lang->line('update_email_for_customer_success_please_check_your_email_and_active_your_account'));
            }else{
                $this->error400($this->lang->line('update_email_for_customer_failed'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function forgot_password() {
        try {
            $postData = $this->arrayFromPostRawJson(array('customer_email'));
            $customer_email = strtolower($postData['customer_email']);
            if (empty($customer_email)) {
                $this->error204($this->lang->line('please_enter_your_email'));
                die;
            }
            $this->load->model('Mcustomers');
            $customer = $this->Mcustomers->getBy(array('customer_email' => $customer_email));
            if ($customer && count($customer) > 0) {
                $this->load->library('Authorization_Token');
                // generte a token
                $tokenReset = $this->authorization_token->generateToken(array('id' => $customer['id'], 'created_at' => getCurentDateTime()));
                $customer = $customer[0];
                $customerId = $this->Mcustomers->save(array('token_reset' => $tokenReset), $customer['id']);
                if($customerId > 0){
                    /**
                     * Save Email
                     */
                    $this->load->model('Memailqueue');
                    $dataEmail = array(
                        'name' => $customer['customer_first_name'],
                        'email_to' => $customer['customer_email'],
                        'email_to_name' => $customer['customer_first_name'],
                        'token' => $tokenReset
                    );
                    $emailResult = $this->Memailqueue->createEmail($dataEmail, 2);
                    /**
                     * END. Save Email
                     */
                    if ($emailResult){
                        $this->success200('', $this->lang->line('successfully_sent_password_recover'));
                        die;
                    } else {
                        $this->error400($this->lang->line('sending_password_recover_failed'));
                        die;
                    }
                } else {
                    $this->error400($this->lang->line('sending_password_recover_failed'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('email_does_not_exist'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function change_password() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('customer_password', 'confirm_password', 'token_reset'));
            $this->validatePassWord($postData);
            if(empty($postData['token_reset'])) {
                $this->error204($this->lang->line('tokens_cannot_be_empty'));
                die;
            }
            $this->load->model('Mcustomers');
            $customerId = $this->Mcustomers->getFieldValue(array('token_reset' => $postData['token_reset']), 'id', 0);
            if ($customerId > 0) {
                $dataUpdate = array(
                    'customer_password' => md5($postData['customer_password']),
                    'token' => '',
                    'token_reset' => '',
                    'updated_at' => getCurentDateTime()
                );
                $flag = $this->Mcustomers->save($dataUpdate, $customerId);
                if($flag > 0){
                    $this->success200($flag, $this->lang->line('successfully_reset_password'));
                    die;
                }else{
                    $this->error400($this->lang->line('resetting_password_failed'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('token_does_not_exist_or_is_expired'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }


    private function validatePassWord($postData) {
        if (empty($postData['customer_password']) || empty($postData['confirm_password'])) {
            $this->error204($this->lang->line('please_enter_your_new_password'));
            die;
        }
        if ($postData['customer_password'] != $postData['confirm_password']) {
            $this->error204($this->lang->line('password_does_not_match'));
            die;
        }
        $uppercase = preg_match('@[A-Z]@', $postData['customer_password']);
        $lowercase = preg_match('@[a-z]@', $postData['customer_password']);
        $number    = preg_match('@[0-9]@', $postData['customer_password']);
        $specialChars = preg_match('@[^\w]@', $postData['customer_password']);
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($postData['customer_password']) < 8) {
            $this->error204($this->lang->line('password_should_be_at_least_8_characters_in_length_and_should_include_at_least_one_upper_case_letter_one_number_and_one_special_character.'));
            die;
        }
    }

    public function confirm_email() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('token'));
            if(empty($postData['token'])) {
                $this->error204($this->lang->line('tokens_cannot_be_empty'));
                die;
            }
            $this->load->model('Mcustomers');
            $customer = $this->Mcustomers->getBy(array('token_reset' => $postData['token'], 'customer_status_id' => STATUS_WAITING_ACTIVE));
            if($customer) {
                $customer = $customer[0];

                $this->load->library('Authorization_Token');
                // generte a token
                $token = $this->authorization_token->generateToken(array('id' => $customer['id'], 'created_at' => getCurentDateTime()));

                $flag = $this->Mcustomers->save(['token_reset' => '', 'token' => $token, 'customer_status_id' => STATUS_ACTIVED, 'updated_at' => getCurentDateTime()], $customer['id']);
                if($flag) {
                    if(empty($customer['customer_avatar'])) $customer['customer_avatar'] = base_url(CUSTOMER_PATH.NO_IMAGE);
                    else $customer['customer_avatar'] = base_url(CUSTOMER_PATH.$customer['customer_avatar']);
                    $customer['token'] = $token;
                    $customer['customer_first_name'] = !empty($customer['customer_first_name']) ? $customer['customer_first_name'] : '';
                    $customer['customer_last_name'] = !empty($customer['customer_last_name']) ? $customer['customer_last_name'] : '';
                    $customer['customer_birthday'] = !empty($customer['customer_birthday']) ? $customer['customer_birthday'] : '';
                    $customer['customer_phone'] = !empty($customer['customer_phone']) ? $customer['customer_phone'] : '';
                    $customer['customer_occupation'] = !empty($customer['customer_occupation']) ? $customer['customer_occupation'] : '';
                    $customer['customer_address'] = !empty($customer['customer_address']) ? $customer['customer_address'] : '';
                    unset($customer['token_reset'], $customer['customer_password'], 
                        $customer['created_at'], $customer['created_by'], $customer['updated_at'],  
                        $customer['updated_by'],  $customer['deleted_at'],$customer['id'],$customer['customer_gender_id']
                        ,$customer['free_trial'],$customer['free_trial_type'],$customer['customer_status_id'],$customer['facebook_id'],$customer['google_id']
                        ,$customer['login_type_id']);
                    $this->success200(array('customer' => $customer));
                } else {
                    $this->error400($this->lang->line('account_activation_failed'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('token_does_not_exist_or_account_has_been_activated'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function remove_coupon() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('coupon_id'));
            $postData['customer_id'] = $customer['customer_id'];
            if (empty($postData['coupon_id']) && $postData['coupon_id'] < 0) {
                $this->error204($this->lang->line('incorrect_information'));
                die;
            }
            $this->load->model('Mcustomercoupons');
            $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_coupon_status_id' => 2, 'customer_id' => $postData['customer_id'], 'coupon_id' => $postData['coupon_id']), 'id', 0);
            if($customerCouponId) {
                $flag = $this->Mcustomercoupons->save(['customer_coupon_status_id' => 0, 'deleted_at' => getCurentDateTime()], $customerCouponId);
                if($flag) {
                    $this->success200('', $this->lang->line('successfully_removed!'));
                    die;
                } else {
                    $this->error204($this->lang->line('coupon_code_does_not_exist'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('coupon_code_does_not_exist'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function remove_event() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('event_id'));
            $postData['customer_id'] = $customer['customer_id'];
            if (empty($postData['event_id']) && $postData['event_id'] < 0) {
                $this->error204($this->lang->line('incorrect_information'));
                die;
            }
            $this->loadModel(array('Mevents', 'Mcustomerevents'));

            $customerEventId = $this->Mcustomerevents->getFieldValue(array('customer_id' => $postData['customer_id'], 'event_id' => $postData['event_id'], 'customer_event_status_id > ' => 0), 'id', 0);

            if ($customerEventId > 0) {
                $flag = $this->Mcustomerevents->updateBy(
                    array(
                        'customer_id' => $postData['customer_id'],
                        'event_id' => $postData['event_id']
                    ),
                    array(
                        'customer_event_status_id' => STATUS_NUMBER_ZERO
                    )
                );
                if($flag) {
                    $this->success200('', $this->lang->line('you_have_left_the_event'));
                    die;
                } else {
                    $this->error204($this->lang->line('the_event_has_ended_or_does_not_exist'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('the_event_has_ended_or_does_not_exist'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function update_profile() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostApi(array('customer_first_name', 'customer_last_name', 'customer_birthday', 'customer_gender_id', 'customer_phone', 'customer_phone_code', 'customer_occupation', 'customer_address', 'language_id'));
            
            $this->checkValidateCustomerProfile($postData);
            if(isset($_FILES['customer_avatar']) && !empty($_FILES['customer_avatar']['name'])){
                $file = $_FILES['customer_avatar'];
                $names = explode('.', $file['name']);
                $fileExt = strtolower($names[count($names) - 1]);
                if(in_array($fileExt, array('jpeg', 'jpg', 'png'))) {
                    $dir = CUSTOMER_PATH . date('Y-m-d') . '/';
                    @mkdir($dir, 0777, true);
                    @system("/bin/chown -R nginx:nginx " . $dir);
                    $filePath = $dir . uniqid() . '.' . $fileExt;
                    $flag = move_uploaded_file($file['tmp_name'], $filePath);
                    if ($flag) {
                        $photo = replaceFileUrl($filePath, CUSTOMER_PATH);
                        $postData['customer_avatar'] = $photo;
                    } else {
                        $this->error204($this->lang->line('avatar_update_failed'));
                        die;
                    }
                } else {
                    $this->error204($this->lang->line('the_image_is_not_in_the_correct_format_jpeg_jpg_png'));
                    die;
                }
            }
            $this->loadModel(array('Mcustomers'));
            $checkExit = $this->Mcustomers->get($customer['customer_id']);
            if($checkExit && $checkExit['customer_status_id'] == STATUS_ACTIVED) {
                $languageId = isset($postData['language_id']) && (in_array($postData['language_id'], [1,2,3,4])) ? $postData['language_id'] : 0;
                $postData['customer_birthday'] = ddMMyyyy($postData['customer_birthday'], 'Y-m-d');
                $postData['updated_at'] = getCurentDateTime();
                $postData['updated_by'] = 0;
                $postData['language_id'] = $languageId;

                $flag = $this->Mcustomers->save($postData, $customer['customer_id']);
                $postData['customer_email'] = $checkExit['customer_email'];
                $postData['customer_birthday'] = ddMMyyyy($postData['customer_birthday'], 'Y/m/d');
                $postData['id'] = $flag;
                $postData['customer_avatar'] = !empty($postData['customer_avatar']) ? base_url(CUSTOMER_PATH.$postData['customer_avatar']) : '';
                if($flag) {
                    $this->success200($postData, $this->lang->line('successfully_updated_account_information'));
                    die;
                } else {
                    $this->error204($this->lang->line('invalid_account_information_update'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('invalid_account_information_update'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    private function checkValidateCustomerProfile($postData) {
        if(empty($postData['customer_first_name'])) {
            $this->error204($this->lang->line('please_enter_the_first_name'));
            die;
        }
        if(empty($postData['customer_last_name'])) {
            $this->error204($this->lang->line('please_enter_the_last_name'));
            die;
        }
        if(empty($postData['customer_birthday'])) {
            $this->error204($this->lang->line('please_enter_your_date_of_birth'));
            die;
        }
        if(empty($postData['customer_gender_id']) && $postData['customer_gender_id'] < 0 && $postData['customer_gender_id'] > 4) {
            $this->error204($this->lang->line('please_enter_gender'));
            die;
        }
        if(empty($postData['customer_phone'])) {
            $this->error204($this->lang->line('invalid_phone_number'));
            die;
        }
        if(empty($postData['customer_phone_code'])) {
            $this->error204($this->lang->line('please_enter_phone_code'));
            die;
        }
        if(empty($postData['customer_occupation'])) {
            $this->error204($this->lang->line('please_enter_occupation'));
            die;
        }
        if(empty($postData['customer_address'])) {
            $this->error204($this->lang->line('please_enter_address'));
            die;
        }
    }

    public function update_password() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('current_password', 'customer_password', 'confirm_password'));
            
            $this->loadModel(array('Mcustomers'));
            $checkExit = $this->Mcustomers->get($customer['customer_id']);
            if(!$checkExit) {
                $this->error204($this->lang->line('accounts_doesnt_doing'));
                die;
            }
            if(md5($postData['current_password']) != $checkExit['customer_password']) {
                $this->error204($this->lang->line('current_password_is_incorrect'));
                die;
            }
            $this->validatePassWord($postData);
            $data['customer_password'] = md5($postData['customer_password']);
            $data['updated_at'] = getCurentDateTime();
            $data['updated_by'] = 0;
            $data['language_id'] = $this->languageId;

            $flag = $this->Mcustomers->save($data, $customer['customer_id']);
            if($flag) {
                $this->success200('', $this->lang->line('password_update_successful'));
                die;
            } else {
                $this->error204($this->lang->line('invalid_account_information_update'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}