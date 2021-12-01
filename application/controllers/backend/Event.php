<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller { 

    public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List Event',
			array(
                'scriptHeader' => array('css' => ''),
                'scriptFooter' => array('js' => array('js/backend/event/list.js'))
            )
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/event')) {
            $postData = $this->arrayFromPost(array('search_text'));
			$this->load->model(array('Mevents', 'Mbusinessprofiles'));
            $rowCount = $this->Mevents->getCount($postData);
            $data['listEvents'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['listEvents'] = $this->Mevents->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
			$this->load->view('backend/event/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Add Event',
			array(
				'scriptHeader' => array('css' => 'vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css'),
				'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-datetimepicker/moment.min.js','vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'js/backend/event/update.js'))
			)
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/event-create')) {
			
			$this->load->view('backend/event/add', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function edit($eventId = 0){
        if($eventId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Edit Event',
                array(
                    'scriptHeader' => array('css' => 'vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css'),
                    'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-datetimepicker/moment.min.js','vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'js/backend/event/update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/event-update')) {
				$this->load->model(array('Mevents', 'Mbusinessprofiles'));
                $event = $this->Mevents->get($eventId);
                if ($event && $event['event_status_id'] > 0) {
                    $data['id'] = $eventId;
                    $data['event'] = $event;
                    $data['businessprofile'] = $this->Mbusinessprofiles->get($event['business_profile_id']);
                }else {
                    $data['id'] = 0;
                    $data['txtError'] = ERROR_NO_DATA;
                }
                $this->load->view('backend/event/edit', $data);
            }
            else $this->load->view('backend/user/permission', $data);
        }
        else redirect('sys-admin/event');
	}


    public function update(){
        try {
            $user = $this->checkUserLogin();
            $postData = $this->arrayFromPost(array('business_profile_id', 'event_subject', 'event_image', 'start_date', 'end_date', 'event_description'));
            if(!empty($postData['event_subject'])  && !empty($postData['start_date'])) {
                $eventId = $this->input->post('id');
				$this->load->model('Mevents');
                $postData['start_time'] = ddMMyyyyToDate($postData['start_date'], 'd/m/Y H:i', 'H:i');
                $postData['end_time'] = ddMMyyyyToDate($postData['end_date'], 'd/m/Y H:i', 'H:i');

                $postData['start_date'] = ddMMyyyyToDate($postData['start_date'], 'd/m/Y H:i', 'Y-m-d');
                $postData['end_date'] = ddMMyyyyToDate($postData['end_date'], 'd/m/Y H:i', 'Y-m-d');

                if(empty($postData['event_image'])) $postData['event_image'] = NO_IMAGE;
                else $postData['event_image'] = replaceFileUrl($postData['event_image'], EVENTS_PATH);
                $message = 'Create success';
                if ($eventId == 0){
                    $postData['event_status_id'] = STATUS_ACTIVED;
                    $postData['created_by'] = ($user) ? $user['id'] : 0;
                    $postData['created_at'] = getCurentDateTime();
                }
                else {
                    $message = 'Update successful';
                    $postData['updated_by'] = ($user) ? $user['id'] : 0;
                    $postData['updated_at'] = getCurentDateTime();
                }
                
                $eventId = $this->Mevents->save($postData, $eventId);
                if ($eventId > 0) {
                    echo json_encode(array('code' => 1, 'message' => $message, 'data' => $eventId));
                }
                else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
            }
            else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
     	}
    }

    public function changeStatus(){
		$user = $this->checkUserLogin();
		$eventId = $this->input->post('id');
		$statusId = $this->input->post('status_id');
		if($eventId > 0) {
            $deleteAt = 1;
            $message = 'Deleting the service successfully';
            if($statusId == 1) {
                $message = 'Event lock successful';
                $deleteAt = 0;
            } else if($statusId == 2) {
                $message = 'Event activation successful';
                $deleteAt = 0;
            }
			$this->loadModel(array('Mevents'));
			$flag = $this->Mevents->changeStatus($statusId, $eventId, 'event_status_id', $user['id'], $deleteAt);
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
}