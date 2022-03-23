<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller { 

    public function index(){
		if(!$this->session->userdata('user')){
			$data = array('title' => 'Login');
			if ($this->session->flashdata('txtSuccess')) $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
			$this->load->helper('cookie');
			$data['userName'] = $this->input->cookie('userName', true);
			$data['userPass'] = $this->input->cookie('userPass', true);
			$this->load->view('backend/user/login', $data);
		}
		else redirect('sys-admin/dashboard');
	}

    public function checkLogin(){
        // header('Access-Control-Allow-Origin: *');
		// header('Content-Type: application/json');
		$postData = $this->arrayFromPost(array('user_name', 'user_pass', 'is_remember', 'is_get_configs'));
		$userName = $postData['user_name'];
		$userPass = $postData['user_pass'];
		if(!empty($userName) && !empty($userPass)) {
			$configs = array();
			$user = $this->Musers->login($userName, $userPass);
			if ($user) {
				if(empty($user['avatar'])) $user['avatar'] = NO_IMAGE;
				$this->session->set_userdata('user', $user);
                $this->session->set_userdata('config_about_us', array('language_id' => 1));

				if ($postData['is_get_configs'] == 1) {
					$this->load->model('Mconfigs');
					$configs = $this->Mconfigs->getListMap();
					$this->session->set_userdata('configs', $configs);
				}
				if ($postData['is_remember'] == 'on') {
					$this->load->helper('cookie');
					$this->input->set_cookie(array('name' => 'userName', 'value' => $userName, 'expire' => '86400'));
					$this->input->set_cookie(array('name' => 'userPass', 'value' => $userPass, 'expire' => '86400'));
				}
				else {
                    $this->input->set_cookie(array('name' => 'userName', 'value' => '', 'expire' => '-3600'));
                    $this->input->set_cookie(array('name' => 'userPass', 'value' => '', 'expire' => '-3600'));
                }
                $user['SessionId'] = uniqid();
				echo json_encode(array('code' => 1, 'message' => "Logged in successfully", 'data' => array('User' => $user, 'Configs' => $configs, 'message' => "Logged in successfully")));
			}
			else echo json_encode(array('code' => 0, 'message' => "Login failed"));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

    public function logout(){
		$fields = array('user', 'configs', 'config_about_us');
		foreach($fields as $field) $this->session->unset_userdata($field);
		redirect('sys-admin');
	}

    public function staff(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List staff',
			array('scriptFooter' => array('js' => 'js/backend/user/list.js'))
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/staff')) {
            $postData = $this->arrayFromPost(array('search_text', 'status_id'));
            $rowCount = $this->Musers->getCount($postData);
            $data['listUsers'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['listUsers'] = $this->Musers->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
			$this->load->view('backend/user/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Add staff',
			array(
				'scriptHeader' => array('css' => 'vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css'),
				'scriptFooter' => array('js' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'js/backend/user/update.js'))
			)
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/staff-create')) {
			$this->load->view('backend/user/add', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function edit($userId = 0){
        if($userId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Edit staff',
                array(
                    'scriptHeader' => array('css' => 'vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css'),
                    'scriptFooter' => array('js' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'js/backend/user/update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/staff-update')) {
                $staff = $this->Musers->get($userId);
                if ($staff && $staff['status_id'] > 0) {
                    $data['id'] = $userId;
                    $data['staff'] = $staff;
                }else {
                    $data['id'] = 0;
                    $data['txtError'] = ERROR_NO_DATA;
                }
                $this->load->view('backend/user/edit', $data);
            }
            else $this->load->view('backend/user/permission', $data);
        }
        else redirect('sys-admin/staff');
	}

    public function update(){
        try {
            $user = $this->checkUserLogin();
            $postData = $this->arrayFromPost(array('user_name', 'user_pass', 'full_name', 'email', 'gender_id', 'role_id', 'address', 'birth_day', 'phone_number', 'avatar', 'status_id'));
            if(!empty($postData['full_name'])  && !empty($postData['user_name'])) {
                $userId = $this->input->post('id');
                $postData['user_name'] = strtolower($postData['user_name']);
                if ($this->Musers->checkExist($userId, $postData['email'], $postData['phone_number'], $postData['user_name'])) {
                    echo json_encode(array('code' => -1, 'message' => "Phone number or Email already exists in the system"));
                }
                else {
                    $postData['birth_day'] = ddMMyyyyToDate($postData['birth_day']);
                    if(empty($postData['avatar'])) $postData['avatar'] = NO_IMAGE;
                    else $postData['avatar'] = replaceFileUrl($postData['avatar'], USER_PATH);
                    $userPass = $postData['user_pass'];
                    $message = 'Successfully added account';
                    if ($userId == 0){
                        $postData['user_pass'] = !empty($userPass) ? md5($userPass): md5('123456');
                        $postData['created_by'] = ($user) ? $user['id'] : 0;
                        $postData['created_at'] = getCurentDateTime();
                        $postData['token'] = guidV4('staff');
                    }
                    else {
                        $message = 'Account update successful';
                        unset($postData['user_pass']);
                        $newPass = trim($this->input->post('new_pass'));
                        if (!empty($newPass)) $postData['user_pass'] = md5($newPass);
                        $postData['updated_by'] = ($user) ? $user['id'] : 0;
                        $postData['updated_at'] = getCurentDateTime();
                    }
                    $userId = $this->Musers->update($postData, $userId);
                    if ($userId > 0) {
                        if($user && $user['id'] == $userId){
                            $user = array_merge($user, $postData);
                            $this->rsession->set('user', $user);
                        }
                        echo json_encode(array('code' => 1, 'message' => $message, 'data' => $userId));
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
		$userId = $this->input->post('id');
        $statusId = $this->input->post('status_id');
		if($userId > 0) {
            $deleteAt = 1;
            $message = 'Delete employee successfully.';
            if($statusId == 1) {
                $message = 'Account locked successfully.';
                $deleteAt = 0;
            } else if($statusId == 2) {
                $message = 'Account activation successful.';
                $deleteAt = 0;
            }
			$flag = $this->Musers->changeStatus($statusId, $userId, 'status_id', $user['id'], $deleteAt);
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
}