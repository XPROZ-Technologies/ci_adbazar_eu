<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller{

    public function index(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Configs',
			array('scriptFooter' => array('js' => array('ckeditor/ckeditor.js', 'js/backend/config/config.js')))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config')) {
			$this->loadModel(array('Mconfigs'));
			$data['listConfigs'] = $this->Mconfigs->getListMap(1); //, $user['language_id']
            //echo "<pre>";print_r($data['listConfigs']);die;
			$this->load->view('backend/config/general', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function abount(){
		$user = $this->checkUserLogin();
        $configAbountUs = $this->rsession->get('config_about_us');
		$data = $this->commonData($user,
			'About us',
			array('scriptFooter' => array('js' => array('js/backend/config/config.js')))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config/abount')) {
			$this->loadModel(array('Mconfigs'));
			$data['listConfigs'] = $this->Mconfigs->getListMap(1, $configAbountUs['language_id']);
            $data['configAbountUs'] = $configAbountUs;
			$this->load->view('backend/config/abount', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function termOfUse(){
		$user = $this->checkUserLogin();
        $configAbountUs = $this->rsession->get('config_about_us');
		$data = $this->commonData($user,
			'Term of use',
			array('scriptFooter' => array('js' => array('js/backend/config/config.js')))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config/term-of-use')) {
			$this->loadModel(array('Mconfigs'));
			$data['listConfigs'] = $this->Mconfigs->getListMap(1, $configAbountUs['language_id']);
            $data['configAbountUs'] = $configAbountUs;
			$this->load->view('backend/config/term_of_use', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function policy(){
		$user = $this->checkUserLogin();
        $configAbountUs = $this->rsession->get('config_about_us');
		$data = $this->commonData($user,
			'Privacy Policy',
			array('scriptFooter' => array('js' => array('js/backend/config/config.js')))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config/policy')) {
			$this->loadModel(array('Mconfigs'));
			$data['listConfigs'] = $this->Mconfigs->getListMap(1, $configAbountUs['language_id']);
            $data['configAbountUs'] = $configAbountUs;
			$this->load->view('backend/config/privacy_policy', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function video(){
		$user = $this->checkUserLogin();
        $configAbountUs = $this->rsession->get('config_about_us');
		$data = $this->commonData($user,
			'Video',
			array('scriptFooter' => array('js' => array('js/backend/config/config.js')))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config/policy')) {
			$this->loadModel(array('Mconfigs'));
			$data['listConfigs'] = $this->Mconfigs->getListMap(1, $configAbountUs['language_id']);
            $data['configAbountUs'] = $configAbountUs;
			$this->load->view('backend/config/video', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function changeLanguageAbount() {
        $languageId = $this->input->post('language_id');
        $language = 'english';
        switch ($languageId) {
            case 1:
                $language = 'english';
                break;
            case 2:
                $language = 'czech';
                break;
            case 3:
                $language = 'german';
                break;
            case 4:
                $language = 'vietnamese';
                break;
            default:
                $language = 'english';
                break;
        }
        $this->session->set_userdata('config_about_us', array('language_id' => $languageId));
        redirect($this->input->post('UrlOld'));
    }

    public function update($autoLoad = 1){
        $user = $this->checkUserLogin();
        $configAbountUs = $this->rsession->get('config_about_us');
        $this->load->model('Mconfigs');
        $langCode = '';
        if ($configAbountUs['language_id'] == 1) $langCode = '_en';
        elseif ($configAbountUs['language_id'] == 2) $langCode = '_zc';
        elseif ($configAbountUs['language_id'] == 3) $langCode = '_de';
        elseif ($configAbountUs['language_id'] == 4) $langCode = '';
        $listConfigs = $this->Mconfigs->getBy(array('auto_load' => $autoLoad), false, "", "id,config_code,config_value".$langCode."");
        $valueData = array();
        $updateDateTime = getCurentDateTime();
        $param = $this->input->post();
        foreach($listConfigs as $c){
            $configValue = isset($param[$c['config_code']]) ? trim($param[$c['config_code']]) : '';
            $arrImg = array('MARKER_MAP_IMAGE', 'LOGO_IMAGE_HEADER', 'SERVICE_IMAGE', 'ABOUT_US_IMAGE', 'CONTACT_US_IMAGE', 'LOGO_FOOTER_IMAGE', 'ABOUT_US_IMAGE_BANNER', 'ABOUT_US_CHILD_IMAGE_1', 'ABOUT_US_CHILD_IMAGE_2', 'NOTIFICATION_EMAIL_ADMIN');
            if(in_array($c['config_code'], $arrImg)) $configValue = replaceFileUrl($configValue, CONFIG_PATH);
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
            $configs = $this->Mconfigs->getListMap();
			$this->session->set_userdata('configs', $configs);
            echo json_encode(array('code' => 1, 'message' => 'Update successful'));
        }
        else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
    }

    public function updateItem(){
        $user = $this->checkUserLogin();
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