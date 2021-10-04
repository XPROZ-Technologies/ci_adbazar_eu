<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller { 

	public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List Customer',
			array(
                'scriptHeader' => array('css' => ''),
                'scriptFooter' => array('js' => array('js/backend/customer/list.js'))
            )
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/customer')) {
            $postData = $this->arrayFromPost(array('search_text', 'customer_status_id'));
			$this->load->model('Mcustomers');
            $rowCount = $this->Mcustomers->getCount($postData);
            $data['lisCustomers'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['lisCustomers'] = $this->Mcustomers->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
			$this->load->view('backend/customer/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

	public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Add Customer',
			array(
				'scriptHeader' => array('css' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css', 'vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')),
				'scriptFooter' => array('js' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'js/backend/customer/update.js'))
			)
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/customer-create')) {
			$this->load->view('backend/customer/add', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

	public function edit($customerId = 0){
        if($customerId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Edit Customer',
                array(
					'scriptHeader' => array('css' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css', 'vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')),
					'scriptFooter' => array('js' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'js/backend/customer/update.js'))
				)
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/customer-update')) {
				$this->load->model('Mcustomers');
                $customer = $this->Mcustomers->get($customerId);
                if ($customer && $customer['customer_status_id'] > 0) {
                    $data['id'] = $customerId;
                    $data['customer'] = $customer;
                }else {
                    $data['id'] = 0;
                    $data['txtError'] = ERROR_NO_DATA;
                }
                $this->load->view('backend/customer/edit', $data);
            }
            else $this->load->view('backend/user/permission', $data);
        }
        else redirect('sys-admin/customer');
	}

	public function update(){
        try {
            $user = $this->checkUserLogin();
            $postData = $this->arrayFromPost(array('customer_email', 'customer_password', 'customer_first_name', 'customer_last_name', 'customer_avatar', 'customer_birthday', 'customer_gender_id', 'customer_phone', 'customer_occupation', 'customer_address', 'free_trial'));
            if(!empty($postData['customer_first_name'])  && !empty($postData['customer_last_name'])) {
                $customerId = $this->input->post('id');
				$this->load->model('Mcustomers');
                if ($this->Mcustomers->checkExist($customerId, $postData['customer_email'], $postData['customer_phone'])) {
                    echo json_encode(array('code' => -1, 'message' => "Phone number or Email already exists in the system"));
                }
                else {
                    $postData['customer_birthday'] = ddMMyyyyToDate($postData['customer_birthday']);
                    if(empty($postData['customer_avatar'])) $postData['customer_avatar'] = NO_IMAGE;
                    else $postData['customer_avatar'] = replaceFileUrl($postData['customer_avatar'], CUSTOMER_PATH);
                    $userPass = $postData['customer_password'];
                    $message = 'Successfully added account';
                    if ($customerId == 0){
						$postData['customer_status_id'] = STATUS_ACTIVED;
                        $postData['customer_password'] = !empty($userPass) ? md5($userPass): md5('123456');
                        $postData['created_by'] = ($user) ? $user['id'] : 0;
                        $postData['created_at'] = getCurentDateTime();
                    }
                    else {
                        $message = 'Account update successful';
                        unset($postData['customer_password']);
                        $newPass = trim($this->input->post('new_pass'));
                        if (!empty($newPass)) $postData['customer_password'] = md5($newPass);
                        $postData['updated_by'] = ($user) ? $user['id'] : 0;
                        $postData['updated_at'] = getCurentDateTime();
                    }
					
                    $customerId = $this->Mcustomers->save($postData, $customerId);
                    if ($customerId > 0) {
                        echo json_encode(array('code' => 1, 'message' => $message, 'data' => $customerId));
                    }
                    else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
                }
            }
            else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
     	}
    }

	public function changeStatus(){
		$user = $this->checkUserLogin();
		$customerId = $this->input->post('id');
		$statusId = $this->input->post('customer_status_id');
		if($customerId > 0) {
            $deleteAt = 1;
            $message = 'Deleting the service successfully';
            if($statusId == 1) {
                $message = 'Location lock successful';
                $deleteAt = 0;
            } else if($statusId == 2) {
                $message = 'Location activation successful';
                $deleteAt = 0;
            }
			$this->load->model('Mcustomers');
			$flag = $this->Mcustomers->changeStatus($statusId, $customerId, 'customer_status_id', $user['id'], $deleteAt);
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

    public function getListSelect2Ajax() {
        $user = $this->checkUserLogin();
		$searchText = $this->input->post('search_text');
		$this->load->model('Mcustomers');
		$list = $this->Mcustomers->getListSelect2Ajax($searchText);
		echo json_encode($list);
    }
}