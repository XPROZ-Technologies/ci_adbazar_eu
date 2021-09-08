<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller{

    public function index(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Cấu hình chung',
			array('scriptFooter' => array('js' => array('js/backend/config/config.js')))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config')) {
			$this->loadModel(array('Mconfigs'));
			$data['listConfigs'] = $this->Mconfigs->getListMap(1); //, $user['language_id']
			$this->load->view('backend/config/general', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function update($autoLoad = 1){
        $user = $this->checkUserLogin();
        $user['language_id'] = 1;
        $this->load->model('Mconfigs');
        $langCode = '';
        if($user['language_id'] == 2) $langCode = '_en';
        $listConfigs = $this->Mconfigs->getBy(array('auto_load' => $autoLoad), false, "", "id,config_code,config_value".$langCode."");
        $valueData = array();
        $updateDateTime = getCurentDateTime();
        $param = $this->input->post();
        foreach($listConfigs as $c){
            $configValue = isset($param[$c['config_code']]) ? trim($param[$c['config_code']]) : '';
            if($c['config_code'] == 'LOGO_IMAGE_HEADER' || $c['config_code'] == 'COUPON_IMAGE' || $c['config_code'] == 'ABOUT_US_IMAGE' || $c['config_code'] == 'CONTACT_US_IMAGE') $configValue = replaceFileUrl($configValue, CONFIG_PATH);
            // else if($c['config_code'] == 'PAY_IMAGES' || $c['config_code'] == 'ICON_PAYMENT_UNIT') {
            //     $images = json_decode($configValue, true);
            //     $arrImg = [];
            //     if(!empty($images)) {
            //         foreach($images as $image) {
            //             $arrImg[] = replaceFileUrl($image, CONFIG_PATH);
            //         }
            //     }
                
            //     $configValue = json_encode($arrImg);
            // }
            foreach ($param as $key => $value) {
                if($key == $c['config_code'] && $c['config_value'.$langCode.''] != $configValue){
                    $valueData[] = array('id' => $c['id'], 'config_value'.$langCode.'' => $configValue, 'updated_by' => $user['id'], 'updated_at' => $updateDateTime);
                }
            }
        }
        $flag = $this->Mconfigs->updateBatch($valueData);
        if($flag){
            echo json_encode(array('code' => 1, 'message' => 'Update successful'));
        }
        else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
    }

    public function updateItem(){
        $user = $this->checkUserLogin(true);
        $configCode = trim($this->input->post('config_code'));
        $configValue = trim($this->input->post('config_value'));
        if(!empty($configCode) && !empty($configValue)){
            $this->load->model('Mconfigs');
            $flag = $this->Mconfigs->updateItem($configCode, $configValue, $user['id']);
            if($flag) echo json_encode(array('code' => 1, 'message' => 'Update successful'));
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        }
        else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
    }
   
}