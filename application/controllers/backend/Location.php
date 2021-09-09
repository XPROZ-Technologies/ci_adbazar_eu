<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends MY_Controller { 

	public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List location',
			array('scriptFooter' => array('js' => 'js/backend/location/list.js'))
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'location')) {
            $postData = $this->arrayFromPost(array('search_text'));
			$this->load->model('Mlocations');
            $rowCount = $this->Mlocations->getCount($postData);
            $data['lisLocations'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['lisLocations'] = $this->Mlocations->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
			$this->load->view('backend/location/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Add location',
			array(
				'scriptHeader' => array('css' => ''),
				'scriptFooter' => array('js' => array('js/backend/location/update.js'))
			)
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'location/add')) {
			
			$this->load->view('backend/location/add', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

	public function edit($locationId = 0){
        if($locationId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Edit location',
                array(
                    'scriptHeader' => array('css' => ''),
                    'scriptFooter' => array('js' => array('js/backend/location/update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'location/edit')) {
				$this->load->model('Mlocations');
                $location = $this->Mlocations->get($locationId);
                if ($location && $location['location_status_id'] == STATUS_ACTIVED) {
                    $data['id'] = $locationId;
                    $data['location'] = $location;
                }else {
                    $data['id'] = 0;
                    $data['txtError'] = ERROR_NO_DATA;
                }
                $this->load->view('backend/location/edit', $data);
            }
            else $this->load->view('backend/user/permission', $data);
        }
        else redirect('backend/location');
	}

	public function update(){
        try {
            $user = $this->checkUserLogin();
            $postData = $this->arrayFromPost(array('location_name', 'lat', 'lng'));
            if(!empty($postData['location_name'])  && !empty($postData['lat']) && !empty($postData['lng'])) {
                $locationId = $this->input->post('id');

				$message = 'Add location successfully';
				if ($locationId == 0){
					$postData['location_status_id'] = STATUS_ACTIVED;
					$postData['created_by'] = ($user) ? $user['id'] : 0;
					$postData['created_at'] = getCurentDateTime();
				} else {
					$message = 'Location update successful';
					$postData['updated_by'] = ($user) ? $user['id'] : 0;
					$postData['updated_at'] = getCurentDateTime();
				}

				$this->load->model('Mlocations');
				$locationId = $this->Mlocations->save($postData, $locationId);

				if ($locationId > 0) echo json_encode(array('code' => 1, 'message' => $message, 'data' => $locationId));
				else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
            }
            else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
     	}
    }

	public function changeStatus(){
		$user = $this->checkUserLogin();
		$userId = $this->input->post('id');
		if($userId > 0) {
            $deleteAt = 1;
            $message = 'Delete employee successfully.';
			$this->load->model('Mlocations');
			$flag = $this->Mlocations->changeStatus(0, $userId, 'location_status_id', $user['id'], $deleteAt);
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
}