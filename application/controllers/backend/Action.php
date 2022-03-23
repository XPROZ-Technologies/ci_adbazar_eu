<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action extends MY_Controller { 

	public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'Menu hệ thống nội bộ',
			array('scriptFooter' => array('js' => 'js/backend/setting/action.js'))
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/action')) {
			$data['listActiveActions'] = $this->Mactions->getHierachy();
			$this->load->view('backend/setting/action', $data);
		}
		else $this->load->view('user/permission', $data);
	}

	public function update(){
		$user = $this->checkUserLogin();
		$postData = $this->arrayFromPost(array('action_name', 'action_url', 'parent_action_id', 'display_order', 'font_awesome', 'action_level'));
		$postData['status_id'] = STATUS_ACTIVED;
		$actionId = $this->input->post('id');
		$postData['created_by'] = $user['id'];
        $postData['created_at'] = getCurentDateTime();
		$postData['updated_by'] = $user['id'];
        $postData['updated_at'] = getCurentDateTime();
		$flag = $this->Mactions->update($postData, $actionId);
		if($flag) echo json_encode(array('code' => 1, 'message' => "Cập nhật menu thành công"));
		else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}

	public function delete(){
		$this->checkUserLogin(true);
		$actionId = $this->input->post('action_id');
		if($actionId > 0){
			$flag = $this->Mactions->deleteBy($actionId);
			if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa menu thành công"));
			else echo json_encode(array('code' => 0, 'message' => "Menu này chưa xóa được vì có menu con"));
		}
		else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}
}