<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Controller { 

    public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List Service',
            array(
                'scriptHeader' => array('css' => 'vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css'),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'js/backend/service/list.js'))
            )
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'service')) {
            $postData = $this->arrayFromPost(array('search_text', 'service_status_id'));
            $this->load->model('Mservices');
            $rowCount = $this->Mservices->getCount($postData);
            $data['listServices'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['listServices'] = $this->Mservices->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
			$this->load->view('backend/service/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Add Service',
			array(
				'scriptHeader' => array('css' => ''),
				'scriptFooter' => array('js' => array('js/backend/service/update.js'))
			)
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'service/add')) {
			$this->load->view('backend/service/add', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function edit($serviceId = 0){
        if($serviceId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Edit staff',
                array(
                    'scriptHeader' => array('css' => 'vendor/plugins/datepicker/datepicker3.css'),
                    'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/backend/service/update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'service/edit')) {
                $this->loadModel(array('Mservices', 'Mservicetypes'));
                $service = $this->Mservices->get($serviceId);
                if ($service && $service['service_status_id'] > 0) {
                    $data['id'] = $serviceId;
                    $data['service'] = $service;
                    $data['serviceTypes'] = $this->Mservicetypes->getList($serviceId);
                }else {
                    $data['id'] = 0;
                    $data['txtError'] = ERROR_NO_DATA;
                }
                $this->load->view('backend/service/edit', $data);
            }
            else $this->load->view('backend/user/permission', $data);
        }
        else redirect('backend/service');
	}


    public function update(){
        try {
            $user = $this->checkUserLogin();
            $postData = $this->arrayFromPost(array('service_name_vi', 'service_name_en', 'service_name_cz', 'service_name_de', 'display_order', 'service_image'));
            $serviceId = $this->input->post('id');
            if(empty($postData['service_image'])) $postData['service_image'] = NO_IMAGE;
            else $postData['service_image'] = replaceFileUrl($postData['service_image'], SERVICE_PATH);
            $message = 'Successfully added service';
            if($serviceId == 0){
                $postData['service_status_id'] = STATUS_ACTIVED;
                $postData['created_by'] = $user['id'];
                $postData['created_at'] = getCurentDateTime();
            }
            else{
                $message = 'Service update successful';
                $postData['updated_by'] = $user['id'];
                $postData['updated_at'] = getCurentDateTime();
            }

            $serviceTypes = json_decode(trim($this->input->post('ServiceTypes')), true);
            if(!is_array($serviceTypes)) $serviceTypes = array();
            $this->load->model('Mservices');
            $flag = $this->Mservices->update($postData, $serviceId, $serviceTypes, $user['id']);
            if($flag) echo json_encode(array('code' => 1, 'message' => $message, 'data' => $flag));
            else echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra, vui lòng thử lại.'));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
        }

    }

    public function changeStatus(){
		$user = $this->checkUserLogin();
		$serviceId = $this->input->post('id');
        $statusId = $this->input->post('service_status_id');
		if($serviceId > 0) {
            $deleteAt = 1;
            $message = 'Deleting the service successfully';
            if($statusId == 1) {
                $message = 'Service key successful.';
                $deleteAt = 0;
            } else if($statusId == 2) {
                $message = 'Service activation successful.';
                $deleteAt = 0;
            }
            $this->load->model('Mservices');
			$flag = $this->Mservices->changeStatus($statusId, $serviceId, 'service_status_id', $user['id'], $deleteAt);
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

    public function isHot() {
		$user = $this->checkUserLogin();
		$serviceId = $this->input->post('id');
		$isHot = $this->input->post('is_hot');
		if($serviceId > 0) {
			$this->load->model('Mservices');
			$flag = $this->Mservices->changeIsHot($isHot, $serviceId, '', $user['id']);
			$message = 'Activation of featured position successfully';
			if($isHot == 'OFF') $message = 'Successfully Hide Featured Location';
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
}