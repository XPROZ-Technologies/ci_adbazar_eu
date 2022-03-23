<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentplan extends MY_Controller { 

	public function index(){
		$user = $this->checkUserLogin(); 
		$data = $this->commonData($user,
			'List Payment plan',
			array(
                'scriptHeader' => array('css' => ''),
                'scriptFooter' => array('js' => '')
            )
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'backend/paymentplan')) {
            $postData = $this->arrayFromPost(array('search_text','plan_type_id','plan_currency_id'));
			$this->load->model('Mpaymentplans');
            $rowCount = $this->Mpaymentplans->getCount($postData);
            $data['lisPaymentPlans'] = array();
            if($rowCount > 0){
                $perPage = DEFAULT_LIMIT;
                $pageCount = ceil($rowCount / $perPage);
                $page = $this->input->post('page_id');
                if(!is_numeric($page) || $page < 1) $page = 1;
                $data['lisPaymentPlans'] = $this->Mpaymentplans->search($postData, $perPage, $page);
                $data['paggingHtml'] = getPaggingHtml($page, $pageCount);
            }
			$this->load->view('backend/payment_plan/list', $data);
		}
		else $this->load->view('backend/user/permission', $data);
	}
}