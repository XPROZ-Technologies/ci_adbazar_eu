<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Businessprofile extends MY_Controller { 

    public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List Business Profile',
            array(
                'scriptHeader' => array('css' => 'vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css'),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'js/backend/business_profile/list.js'))
            )
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/business-profile')) {
            $postData = $this->arrayFromPost(array('search_text', 'business_status_id'));
            $this->loadModel(array('Mservices', 'Mbusinessprofiles', 'Mcustomers'));
            $rowCount = $this->Mbusinessprofiles->getCount($postData);
            $data['listProfiles'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['listProfiles'] = $this->Mbusinessprofiles->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
			$this->load->view('backend/business_profile/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Add Business Profiles',
			array(
				'scriptHeader' => array('css' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css', 'vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')),
				'scriptFooter' => array('js' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'js/backend/business_profile/update.js'))
			)
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/business-profile-add')) {
			$this->load->model('Mservices');
            $data['listServices'] = $this->Mservices->getBy(array('service_status_id' => STATUS_ACTIVED));
			$this->load->view('backend/business_profile/add', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function edit($businessProfileId = 0){
        if($businessProfileId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Edit business profile',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css', 'vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'js/backend/business_profile/update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'service/edit')) {
                $this->loadModel(array('Mservices', 'Mbusinessprofiles', 'Mcustomers', 'Mbusinessservicetype', 'Mservicetypes', 'Mopeninghours','Mphonecodes', 'Mbusinessphotos', 'Mbusinessvideos'));
                $profile = $this->Mbusinessprofiles->get($businessProfileId);
                if ($profile && $profile['business_status_id'] > 0) {
                    $data['id'] = $businessProfileId;
                    $data['profile'] = $profile;
                    $data['service'] = $this->Mservices->get($profile['service_id']);
                    $data['customer'] = $this->Mcustomers->get($profile['customer_id']);
                    $data['servicetypes'] = $this->Mservicetypes->getBy(array('service_id' => $profile['service_id']));
                    $data['businessservicetypes'] = $this->Mbusinessservicetype->getListFieldValue(array('business_profile_id' => $profile['id']), 'service_type_id');
                    $data['openinghours'] = $this->Mopeninghours->getBy(array('business_profile_id' => $businessProfileId), false, 'day_id', '',0,0, 'asc');
                    $data['phonecode'] = $this->Mphonecodes->get($profile['country_code_id']);
                    $data['businessInLocation'] = $this->Mbusinessprofiles->getBusinessInLocation($businessProfileId);
                    $data['businessphotos'] = $this->Mbusinessphotos->getBy(array('business_profile_id' => $businessProfileId));
                    $data['businessvideos'] = $this->Mbusinessvideos->getBy(array('business_profile_id' => $businessProfileId));
                }else {
                    $data['id'] = 0;
                    $data['txtError'] = ERROR_NO_DATA;
                }
                $this->load->view('backend/business_profile/edit', $data);
            }
            else $this->load->view('backend/user/permission', $data);
        }
        else redirect('backend/businessprofile');
	}

	public function update() {
		try {
            $user = $this->checkUserLogin();
            $postData = $this->arrayFromPost(array('customer_id', 'service_id', 'business_name', 'business_slogan', 'business_email', 'business_address', 'business_whatsapp', 'business_url', 'business_phone', 'business_description', 'business_avatar', 'business_image_cover', 'country_code_id'));
            $businessProfileId = $this->input->post('id');

            if(empty($postData['business_avatar'])) $postData['business_avatar'] = NO_IMAGE;
            else $postData['business_avatar'] = replaceFileUrl($postData['business_avatar'], BUSINESS_PROFILE_PATH);

			if(empty($postData['business_image_cover'])) $postData['business_image_cover'] = NO_IMAGE;
            else $postData['business_image_cover'] = replaceFileUrl($postData['business_image_cover'], BUSINESS_PROFILE_PATH);

            $message = 'Successfully added service';
            if($businessProfileId == 0){
                $postData['business_status_id'] = STATUS_ACTIVED;
                $postData['created_by'] = $user['id'];
                $postData['created_at'] = getCurentDateTime();
                if(empty($postData['business_url'])) $postData['business_url'] = makeSlug($postData['business_name']);
            }
            else{
                $message = 'Service update successful';
                $postData['updated_by'] = $user['id'];
                $postData['updated_at'] = getCurentDateTime();
            }
            $openingHours = json_decode(trim($this->input->post('OpeningHours')), true); 
            if(!is_array($openingHours)) $openingHours = array();

			$businessServiceTypes = json_decode(trim($this->input->post('BusinessServiceTypeIds')), true);
			if(!is_array($businessServiceTypes)) $businessServiceTypes = array();

            $businessPhotos = json_decode(trim($this->input->post('Photos')), true);
			if(!is_array($businessPhotos)) $businessPhotos = array(); 

            $businessVideos = json_decode(trim($this->input->post('BusinessVideos')), true);
			if(!is_array($businessVideos)) $businessVideos = array();

            $this->load->model('Mbusinessprofiles');
            $flag = $this->Mbusinessprofiles->update($postData, $businessProfileId, $businessServiceTypes, $openingHours, $user['id'], $businessPhotos, $businessVideos);
            if($flag) {
                $businessProfileLocation = $this->arrayFromPost(array('location_id', 'expired_date')); 
                $this->db->update('business_profile_locations', array('business_profile_location_status_id' => 0), array('business_profile_id' => $flag));
                if($businessProfileLocation['location_id'] > 0) {
                    $businessProfileLocationId = $this->input->post('business_profile_location_id');
                    $businessProfileLocation['expired_date'] = !empty($businessProfileLocation['expired_date']) ? ddMMyyyyToDate($businessProfileLocation['expired_date'], 'd/m/Y H:i', 'Y-m-d H:i') : NULL;
                    $businessProfileLocation['business_profile_id'] = $flag;
                    $businessProfileLocation['business_profile_location_status_id'] = STATUS_ACTIVED;
                    $this->load->model('Mbusinessprofilelocations');
                    $this->Mbusinessprofilelocations->save($businessProfileLocation, $businessProfileLocationId);
                }
                echo json_encode(array('code' => 1, 'message' => $message, 'data' => $flag));
            } 
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            var_dump($th);
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
        }
	}

    public function changeStatus(){
		$user = $this->checkUserLogin();
		$businessProfileId = $this->input->post('id');
        $statusId = $this->input->post('business_status_id');
		if($businessProfileId > 0) {
            $deleteAt = 1;
            $message = 'Delete Business Profile successfully.';
            if($statusId == 1) {
                $message = 'Business Profile locked successfully.';
                $deleteAt = 0;
            } else if($statusId == 2) {
                $message = 'Business Profile activation successful.';
                $deleteAt = 0;
            }
            $this->loadModel(array('Mbusinessprofilelocations','Mbusinessprofiles'));
			$flag = $this->Mbusinessprofiles->changeStatus($statusId, $businessProfileId, 'business_status_id', $user['id'], $deleteAt);
			if($flag) {
                $this->Mbusinessprofilelocations->changeStatusChild($statusId, $businessProfileId, 'business_profile_location_status_id', $user['id'], $deleteAt, 'business_profile_id');
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

    public function isHot() {
		$user = $this->checkUserLogin();
		$locationId = $this->input->post('id');
		$isHot = $this->input->post('is_hot');
		if($locationId > 0) {
			$this->load->model('Mbusinessprofiles');
			$flag = $this->Mbusinessprofiles->changeIsHot($isHot, $locationId, '', $user['id']);
			$message = 'Activation of featured position successfully';
			if($isHot == 1) $message = 'Successfully Hide Featured Location';
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

    public function getBusinessProfileNotInLocation() {
        $user = $this->checkUserLogin();
        $searchText = $this->input->post('search_text');
        $businessProfileLocationId = $this->input->post('business_profile_location_id');
		$this->load->model('Mbusinessprofiles');
		$list = $this->Mbusinessprofiles->getBusinessProfileNotInLocation($searchText, $businessProfileLocationId);
		echo json_encode($list);
    }

}