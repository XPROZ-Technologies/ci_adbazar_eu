<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends MY_Controller { 

    public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List Coupon',
			array(
                'scriptHeader' => array('css' => 'vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css'),
                'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'js/backend/coupon/list.js'))
            )
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'coupon')) {
            $postData = $this->arrayFromPost(array('search_text'));
			$this->load->model('Mcoupons');
            $rowCount = $this->Mcoupons->getCount($postData);
            $data['listCoupons'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['listCoupons'] = $this->Mcoupons->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
			$this->load->view('backend/coupon/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function add(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Add Coupon',
			array(
				'scriptHeader' => array('css' =>  array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css')),
				'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'js/backend/coupon/update.js'))
			)
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'coupon/coupon-create')) {
			
			$this->load->view('backend/coupon/add', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}

    public function edit($couponId = 0){
        if($couponId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Edit Coupon',
                array(
                    'scriptHeader' => array('css' =>  array('vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css','vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.min.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js','vendor/plugins/jquery-datetimepicker/jquery.datetimepicker.full.min.js', 'js/backend/coupon/update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'sys-admin/coupon-update')) {
				$this->load->model(array('Mcoupons', 'Mbusinessprofiles'));
                $coupon = $this->Mcoupons->get($couponId);
                if ($coupon && $coupon['coupon_status_id'] > 0) {
                    $data['id'] = $couponId;
                    $data['coupon'] = $coupon;
                    $data['businessprofile'] = $this->Mbusinessprofiles->get($coupon['business_profile_id']);
                }else {
                    $data['id'] = 0;
                    $data['txtError'] = ERROR_NO_DATA;
                }
                $this->load->view('backend/coupon/edit', $data);
            }
            else $this->load->view('backend/user/permission', $data);
        }
        else redirect('sys-admin/coupon');
	}

    public function update(){
        try {
            $user = $this->checkUserLogin();
            $postData = $this->arrayFromPost(array('business_profile_id', 'coupon_subject', 'coupon_image', 'coupon_amount', 'coupon_description', 'start_date', 'end_date', 'is_hot'));
            if(!empty($postData['business_profile_id'])  && !empty($postData['coupon_subject'])) {
                $couponId = $this->input->post('id');
				$this->load->model('Mcoupons');
                $postData['start_date'] = ddMMyyyyToDate($postData['start_date']);
                $postData['end_date'] = ddMMyyyyToDate($postData['end_date']);
                if(empty($postData['coupon_image'])) $postData['coupon_image'] = NO_IMAGE;
                else $postData['coupon_image'] = replaceFileUrl($postData['coupon_image'], COUPONS_PATH);
                $message = 'Create success';
                if ($couponId == 0){
                    $postData['coupon_status_id'] = STATUS_ACTIVED;
                    $postData['created_by'] = ($user) ? $user['id'] : 0;
                    $postData['created_at'] = getCurentDateTime();
                }
                else {
                    $message = $this->lang->line('update-successful1635566199');
                    $postData['updated_by'] = ($user) ? $user['id'] : 0;
                    $postData['updated_at'] = getCurentDateTime();
                }
                
                $couponId = $this->Mcoupons->update($postData, $couponId);
                if ($couponId > 0) {
                    echo json_encode(array('code' => 1, 'message' => $message, 'data' => $couponId));
                }
                else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
            }
            else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
     	}
    }

    public function getListSelect2BuinessProfile() {
        $user = $this->checkUserLogin();
        $searchText = $this->input->post('search_text');
		$this->load->model('Mbusinessprofiles');
		$list = $this->Mbusinessprofiles->getListSelect2BuinessProfile($searchText);
		echo json_encode($list);
    }

    public function changeStatus(){
		$user = $this->checkUserLogin();
		$couponId = $this->input->post('id');
		$statusId = $this->input->post('status_id');
		if($couponId > 0) {
            $deleteAt = 1;
            $message = 'Deleting the service successfully';
            if($statusId == 1) {
                $message = 'Coupon lock successful';
                $deleteAt = 0;
            } else if($statusId == 2) {
                $message = 'Coupon activation successful';
                $deleteAt = 0;
            }
			$this->loadModel(array('Mcoupons'));
			$flag = $this->Mcoupons->changeStatus($statusId, $couponId, 'coupon_status_id', $user['id'], $deleteAt);
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}

	public function isHot() {
		$user = $this->checkUserLogin();
		$couponId = $this->input->post('id');
		$isHot = $this->input->post('is_hot');
		if($couponId > 0) {
			$this->load->model('Mcoupons');
			$flag = $this->Mcoupons->changeIsHot($isHot, $couponId, '', $user['id']);
			$message = 'Activation of featured position successfully';
			if($isHot == 1) $message = 'Successfully Hide Featured Location';
			if($flag) {
				echo json_encode(array('code' => 1, 'message' => $message));
			}
			else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
		}
		else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
	}
}