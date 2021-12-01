<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Businesspayment extends MY_Controller { 

	public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List Business payment',
			array(
                'scriptHeader' => array('css' => ''),
                'scriptFooter' => array('js' => '')
            )
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'backend/businesspayment')) {
            $postData = $this->arrayFromPost(array('search_text','business_profile_id','payment_gateway_id'));
			$this->load->model(array('Mbusinesspayments','Mbusinessprofiles'));
            $rowCount = $this->Mbusinesspayments->getCount($postData);
            $data['lisBusinessPayments'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['lisBusinessPayments'] = $this->Mbusinesspayments->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
            $data['listBusinessProfiles'] = $this->Mbusinessprofiles->getBy(array('business_status_id' => STATUS_ACTIVED));
			$this->load->view('backend/business_payment/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}
}