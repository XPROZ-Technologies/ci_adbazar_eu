<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language_id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
    }

    public function login() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('login_type_id', 'customer_email', 'customer_password', 'facebook_id', 'google_id'));
            $this->load->model('Mcustomers');
            $customer = [];
            if(intval($postData['login_type_id']) == 0) {
                if(empty($postData['customer_email'])) {
                    $this->error204($this->lang->line('please-enter-your-email1635566199'));
                    die;
                }
                if(empty($postData['customer_password'])) {
                    $this->error204($this->lang->line('your_password_does_not_match_p'));
                    die;
                }
                
                $customer = $this->Mcustomers->login($postData['customer_email'], $postData['customer_password']);
                
            } else {
                $fb_gg_id = $postData['facebook_id'];
                if(intval($postData['login_type_id']) == 2) $fb_gg_id = $postData['google_id'];
                $customer = $this->Mcustomers->login('', '', $fb_gg_id, $postData['login_type_id']);
            }

            if($customer) {
                if ($customer) {
                    $postData = array(
                        'token_reset' =>  guidV4('customer'),
                        'language_id' => $this->languageId
                    );
                    $this->Mcustomers->save($postData, $customer['id']);
                }
                if(empty($customer['customer_avatar'])) $customer['customer_avatar'] = base_url(CUSTOMER_PATH.NO_IMAGE);
                else $customer['customer_avatar'] = base_url(CUSTOMER_PATH.$customer['customer_avatar']);
                $customer['token_reset'] = $postData['token_reset'];
                $customer['language_id'] = $postData['language_id'];
                unset($customer['customer_password'], $customer['created_at'], $customer['created_by'], $customer['updated_at'],  $customer['updated_by'],  $customer['deleted_at']);
                $this->success200($customer);
            } else {
                $this->error204('You entered an invalid email or password. Please re-enter.');
                die;
            }
            
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function logout() {
        try {
            $this->openAllCors();
            $token = $this->input->get_request_header('X-Auth-Token', TRUE);
            if(empty($token)) {
                $this->error410('X-Auth-Token has not been uploaded yet');
                die;
            }else {
                $this->load->model('Mcustomers');
                $customerId = $this->Mcustomers->getFieldValue(array('token_reset' => $token), 'id', 0);
                if(!$customerId) {
                    $this->error204('Token does not exist');
                    die;
                } else {
                    $flag = $this->Mcustomers->save(array('token_reset' => '', 'updated_at' => getCurentDateTime()), $customerId);
                    if($flag) $this->success200($customerId, 'Logout successful');
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
            $postData = $this->arrayFromPostRawJson(array('login_type_id', 'customer_email', 'customer_password', 'confirm_password', 'customer_first_name', 'customer_last_name' , 'google_id', 'facebook_id'));
            $this->load->model('Mcustomers');
            $data = [];
            if (intval($postData['login_type_id']) == 0) {
                if (empty($postData['customer_email'])) {
                    $this->error204($this->lang->line('please_enter_a_valid_email'));
                    die;
                }
                $this->validatePassWord($postData);
               
                $customer = $this->Mcustomers->checkExist(0, $postData['customer_email']);
                if($customer) {
                    $this->error204('Email already exists in the system');
                    die;
                }
                $data['customer_password'] =  md5($postData['customer_password']);
            } else if (intval($postData['login_type_id']) == 1) { //facebook
                $data['facebook_id'] = $postData['facebook_id'];
                $data['customer_first_name'] = $postData['customer_first_name'];
                $data['customer_last_name'] = $postData['customer_last_name'];
                $data['customer_password'] = md5('12345678@aM');
            } else if (intval($postData['login_type_id']) == 2) { //google
                $data['facebook_id'] = $postData['facebook_id'];
                $data['customer_first_name'] = $postData['customer_first_name'];
                $data['customer_last_name'] = $postData['customer_last_name'];
                $data['customer_password'] = md5('12345678@aM');
            }

            $data['login_type_id'] =  $postData['login_type_id'];
            $data['customer_email'] =  strtolower($postData['customer_email']);
          
            if($data) {
                $data['created_at'] = getCurentDateTime();
                $data['created_by'] = 0;
                $data['customer_status_id'] = STATUS_WAITING_ACTIVE;
                $data['free_trial'] = STATUS_FREE_TRIAL;
                if (intval($postData['login_type_id']) == 0) {
                    $flag = $this->Mcustomers->save($data);
                } else {
                    $customer = $this->Mcustomers->checkExist(0, $postData['customer_email']);
                    $customerId = 0;
                    if (count($customer) > 0) $customerId = $customer['id'];
                    $flag = $this->Mcustomers->save($data, $customerId);
                }
                if($flag) {
                    $this->load->model('Memailqueue');
                    $dataEmail = array(
                        'name' => $postData['customer_email'],
                        'email_to' => $postData['customer_email'],
                        'email_to_name' => $postData['customer_email']
                    );
                    $this->Memailqueue->createEmail($dataEmail, 1);
                    $this->success200($flag, $this->lang->line('successfully_register_account'));
                } else {
                    $this->error400('Registration failed');
                    die;
                }

            } else {
                $this->error400('Registration failed');
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
                $this->error204($this->lang->line('please-enter-your-email1635566199'));
                die;
            }
            $this->load->model('Mcustomers');
            $customer = $this->Mcustomers->getBy(array('customer_email' => $customer_email));
            if ($customer && count($customer) > 0) {
                $tokenReset = guidV4('reset-passs');
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
                        $this->success200('', $this->lang->line('successfully-sent-password-rec1635566199'));
                        die;
                    } else {
                        $this->error400($this->lang->line('sending-password-recover-faile1635566199'));
                        die;
                    }
                } else {
                    $this->error400($this->lang->line('sending-password-recover-faile1635566199'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('email-not-exist1635566199'));
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
                $this->error204('Tokens cannot be empty');
                die;
            }
            $this->load->model('Mcustomers');
            $customerId = $this->Mcustomers->getFieldValue(array('token_reset' => $postData['token_reset']), 'id', 0);
            if ($customerId > 0) {
                $dataUpdate = array(
                    'customer_password' => md5($postData['customer_password']),
                    'token_reset' => '',
                    'updated_at' => getCurentDateTime()
                );
                $flag = $this->Mcustomers->save($dataUpdate, $customerId);
                if($flag > 0){
                    $this->success200($flag, $this->lang->line('successfully-reset-password1635566199'));
                    die;
                }else{
                    $this->error400($this->lang->line('resetting-password-failed1635566199'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('token-not-exist-or-expired1635566199'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }


    private function validatePassWord($postData) {
        if (empty($postData['customer_password']) || empty($postData['confirm_password'])) {
            $this->error204($this->lang->line('please-enter-your-new-password1635566199'));
            die;
        }
        if ($postData['customer_password'] != $postData['confirm_password']) {
            $this->error204('Password does not match');
            die;
        }
        $uppercase = preg_match('@[A-Z]@', $postData['customer_password']);
        $lowercase = preg_match('@[a-z]@', $postData['customer_password']);
        $number    = preg_match('@[0-9]@', $postData['customer_password']);
        $specialChars = preg_match('@[^\w]@', $postData['customer_password']);
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($postData['customer_password']) < 8) {
            $this->error204('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
            die;
        }
    }
}