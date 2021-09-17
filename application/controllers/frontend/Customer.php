<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('customer', $this->language);
    }

    public function index() {
        //$customer = $this->checkLoginCustomer();
        //$data['customer'] = $customer;
        //$this->load->view('frontend/site/home', $data);
    }

    public function checkLogin(){
		$postData = $this->arrayFromPost(array('customer_email', 'customer_password', 'is_remember'));
		$customerEmail = $postData['customer_email'];
		$customerPass = $postData['customer_password'];
		if(!empty($customerEmail) && !empty($customerPass)) {
			$configs = array();
            $this->load->model('Mcustomers');
			$customer = $this->Mcustomers->login($customerEmail, $customerPass);
			if ($customer) {
				if(empty($customer['customer_avatar'])) $customer['customer_'] = NO_IMAGE;
				$this->session->set_userdata('customer', $customer);
				
				if ($postData['is_remember'] == 'on') {
					$this->load->helper('cookie');
					$this->input->set_cookie(array('name' => 'customerEmail', 'value' => $customerEmail, 'expire' => '86400'));
					$this->input->set_cookie(array('name' => 'customerPass', 'value' => $customerPass, 'expire' => '86400'));
				}
				else {
                    $this->input->set_cookie(array('name' => 'customerEmail', 'value' => '', 'expire' => '-3600'));
                    $this->input->set_cookie(array('name' => 'customerPass', 'value' => '', 'expire' => '-3600'));
                }
                $user['SessionId'] = uniqid();
				echo json_encode(array('code' => 1, 'message' => $this->lang->line('customer_login_success'), 'data' => array('customer' => $customer, 'Configs' => $configs, 'message' => $this->lang->line('customer_login_success'))));
			}
			else echo json_encode(array('code' => 0, 'message' => $this->lang->line('customer_login_failed')));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

    public function register(){
        try {
            $postData = $this->arrayFromPost(array('customer_email', 'customer_password'));
            if(!empty($postData['customer_email'])) {
                $postData['customer_email'] = strtolower($postData['customer_email']);
                $this->load->model('Mcustomers');
                if ($this->Mcustomers->checkExist(0,$postData['customer_email'])) {
                    echo json_encode(array('code' => -1, 'message' => $this->lang->line('customer_phone_or_email_exists')));
                }
                else {
                    $customerPass = $postData['customer_password'];
                    $message = 'Successfully register account';
                    $postData['customer_status_id'] = STATUS_WAITING_ACTIVE;
                    $postData['free_trial'] = STATUS_FREE_TRIAL;
                    $postData['customer_password'] = !empty($customerPass) ? md5($customerPass): md5('123456');
                    $postData['created_by'] = 0;
                    $postData['created_at'] = getCurentDateTime();
                    
                    $customerId = $this->Mcustomers->update($postData);
                    if ($customerId > 0) {
                        echo json_encode(array('code' => 1, 'message' => $message, 'data' => $customerId));
                    }
                    else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
                }
            }
            else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => $e->getMessage()));
            //echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
     	}
    }

    public function loginFb() {
        try {
            $postData = $this->arrayFromPost(array('customer_email', 'customer_first_name', 'customer_last_name', 'login_type_id'));
            $id = $this->input->post('id');
            if($postData['login_type_id'] == 1) $postData['facebook_id'] = $id;
            else if($postData['login_type_id'] == 2) $postData['google_id'] = $id;
            
            $postData['customer_email'] = strtolower($postData['customer_email']);
            $this->load->model('Mcustomers');
            $customer = $this->Mcustomers->checkExist(0,$postData['customer_email']);
            $customerId = 0;
            if(count($customer) > 0) $customerId = $customer['id'];
            $message = 'Successfully register account';
            if($customerId == 0) {
                $postData['created_by'] = 0;
                $postData['created_at'] = getCurentDateTime();
                $postData['customer_status_id'] = STATUS_WAITING_ACTIVE;
                $postData['free_trial'] = STATUS_FREE_TRIAL;
                $postData['customer_password'] =  md5('123456');
            } else {
                $postData['updated_by'] = 0;
                $postData['updated_at'] = getCurentDateTime();
            }
            $flag = $this->Mcustomers->save($postData, $customerId);
            if ($flag > 0) {
                $customer = $this->Mcustomers->get($flag);
                $this->session->set_userdata('customer', $customer);
                $this->load->helper('cookie');
                $this->input->set_cookie(array('name' => 'customerEmail', 'value' => $customer['customer_email'], 'expire' => '86400'));
                $this->input->set_cookie(array('name' => 'customerPass', 'value' => $customer['customer_password'], 'expire' => '86400'));
                echo json_encode(array('code' => 1, 'message' => $message, 'data' => $flag));
            }
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
        }

    }

    public function logout(){
		$fields = array('customer');
		foreach($fields as $field) $this->session->unset_userdata($field);
		echo json_encode(array('code' => 1, 'message' => 'Logout Successfully'));
	}

}