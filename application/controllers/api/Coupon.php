<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language_id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
    }

    public function list_home() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData['api'] = true;
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model('Mcoupons');
            $coupons = $this->Mcoupons->getListHome($postData);
            for($i = 0; $i < count($coupons); $i++){
                $coupons[$i]['coupon_image'] = !empty($coupons[$i]['coupon_image']) ? base_url(COUPONS_PATH.$coupons[$i]['coupon_image']) : '';
            }
            $this->success200(array('list' => $coupons));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function list() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('search_text', 'page_id', 'per_page'));
            $postData['api'] = true;
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model('Mcoupons');
            $rowCount = $this->Mcoupons->getCountInApi($postData);
            $coupons = [];
            $perPage = intval($postData['per_page']) < 1 ? DEFAULT_LIMIT :$postData['per_page'];
            $pageCount = 0;
            if($rowCount > 0){
                $pageCount = ceil($rowCount / $perPage);
                $page = $postData['page_id'];
                if(!is_numeric($page) || $page < 1) $page = 1;
                $coupons = $this->Mcoupons->getListInApi($postData, $perPage, $page);
                for($i = 0; $i < count($coupons); $i++){
                    $coupons[$i]['coupon_image'] = !empty($coupons[$i]['coupon_image']) ? base_url(COUPONS_PATH.$coupons[$i]['coupon_image']) : '';
                }
            }
            $this->success200(array(
                                'page_id' => $page,
                                'per_page' => $perPage,
                                'page_count' => $pageCount,
                                'totals' => $rowCount,
                                'list' => $coupons
                            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}