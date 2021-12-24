<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language-id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
        $this->langCode = '_vi';
        if ($this->languageId == 1) $this->langCode = '_en';
        elseif ($this->languageId == 2) $this->langCode = '_cz';
        elseif ($this->languageId == 3) $this->langCode = '_de';
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
                $coupons[$i]['coupon_used'] = !empty($coupons[$i]['coupon_used']) ? $coupons[$i]['coupon_used'] : 0;
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
            $postData = $this->arrayFromPostRawJson(array('search_text', 'page_id', 'per_page', 'service_id', 'service_type_id', 'order_by', 'business_id'));
            if(empty($postData['service_type_id'])) $postData['service_type_id'] = [];
            if(empty($postData['service_id'])) $postData['service_id'] = [];
            
            $postData['api'] = true;
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model(array('Mcoupons', 'Mbusinessprofiles'));
            $rowCount = $this->Mcoupons->getCountInApi($postData);
            $coupons = [];
            $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
            $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;
            $pageCount = 0;
            if($rowCount > 0){
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $coupons = $this->Mcoupons->getListInApi($postData, $perPage, $page);
                for($i = 0; $i < count($coupons); $i++){
                    $coupons[$i]['coupon_image'] = !empty($coupons[$i]['coupon_image']) ? base_url(COUPONS_PATH.$coupons[$i]['coupon_image']) : '';
                }
            }
            $businessInfo = (object) [];
            if(isset($postData['business_id']) && intval($postData['business_id']) > 0) {
                $business = $this->Mbusinessprofiles->get($postData['business_id']);
                if($business) {
                    $businessInfo = array(
                        'id' => $business['id'],
                        'business_name' => $business['business_name'],
                        'business_slogan' => $business['business_slogan'],
                        'business_avatar' => !empty($business['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$business['business_avatar']): '',
                        'business_image_cover' => !empty($business['business_image_cover']) ? base_url(BUSINESS_PROFILE_PATH.$business['business_avatar']) :''
                    );
                }
            }
            
            $this->success200(array(
                                'page_id' => $page,
                                'per_page' => $perPage,
                                'page_count' => $pageCount,
                                'totals' => $rowCount,
                                'business_info' => $businessInfo,
                                'list' => $coupons
                            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function services_in_coupon() {
        try {
            $this->openAllCors();
            $this->load->model('Mcoupons');
            $postData = $this->arrayFromPostRawJson(array('customer_id'));
            if(!isset($postData['customer_id'])) $postData['customer_id'] = 0;
            $services = $this->Mcoupons->getServicesInCoupon($postData['customer_id'], $this->langCode);
            $this->success200(array('list' => $services));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function get() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin();
            $postData = $this->arrayFromPostRawJson(array('coupon_id'));
            $postData['customer_id'] = $customer['customer_id'];
            if (empty($postData['coupon_id']) && $postData['coupon_id'] < 0) {
                $this->error204('Incorrect information');
                die;
            }
            $this->loadModel(array('Mcoupons', 'Mcustomercoupons'));
            $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_id' => $postData['customer_id'], 'coupon_id' => $postData['coupon_id'], 'customer_coupon_status_id >' => 0), 'id', 0);

            if ($customerCouponId > 0) {
                $this->error204('You have saved this coupon code');
                die;
            }
            $couponInfo = $this->Mcoupons->get($postData['coupon_id']);
            if($couponInfo) {
                //check used - in past
                $pastUsed = $this->Mcustomercoupons->getUsedCoupon($couponInfo['id']);

                //save coupon code
                $customer_coupon_code = $this->Mcoupons->genCouponCode($couponInfo['coupon_code'], $couponInfo['coupon_amount'], $this->Mcustomercoupons->getUsedCoupon($couponInfo['id']));
                if (!empty($customer_coupon_code) && $pastUsed < $couponInfo['coupon_amount']) {
                    $customerCouponId = $this->Mcustomercoupons->save(array(
                        'customer_id' => $postData['customer_id'],
                        'coupon_id' => $postData['coupon_id'],
                        'customer_coupon_status_id' => STATUS_ACTIVED,
                        'customer_coupon_code' => $customer_coupon_code
                    ));

                    //check used - in present
                    $presentUsed = $this->Mcustomercoupons->getUsedCoupon($postData['coupon_id']);
                    if($presentUsed >= $couponInfo['coupon_amount']){
                        $this->Mcoupons->save(array('is_full' => 1), $postData['coupon_id']);
                    }
                    $this->success200('', 'Successfully Saved!');
                    die;
                } else {
                    $this->error500();
                }
            } else {
                $this->error500();
            }   
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function detail() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('coupon_id'));
            $postData['customer_id'] = $customer['customer_id'];
            if (empty($postData['coupon_id']) && $postData['coupon_id'] < 0) {
                $this->error204('Incorrect information');
                die;
            }
            $this->load->model('Mcoupons');
            $detail = $this->Mcoupons->getDetailCoupon($postData);
            if(count($detail) > 0) {
                $detail = $detail[0];
                $detail['coupon_image'] = !empty($detail['coupon_image']) ? base_url(COUPONS_PATH.$detail['coupon_image']) : '';
                $detail['business_info'] = array(
                    'id' => $detail['business_profile_id'],
                    'business_name' => $detail['business_name'],
                    'business_avatar' => !empty($detail['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$detail['business_avatar']) : '',
                    'business_address' => $detail['business_address'],
                    'business_phone' => $detail['business_phone']
                );
                $detail['get_coupon'] = 0;
                if(!empty($detail['customer_id']) && intval($detail['customer_id']) == intval($postData['customer_id'])) {
                    $detail['get_coupon'] = 1;
                }
                unset($detail['business_profile_id'], $detail['customer_id'], $detail['business_avatar'], $detail['business_address'], $detail['business_phone']);
                $this->success200($detail);
            } else {
                $this->error204('No data');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function customer_coupons() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('service_id', 'order_by', 'search_text', 'page_id', 'per_page'));
            $postData['api'] = true;
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model(array('Mcustomercoupons'));
            $rowCount = $this->Mcustomercoupons->getCountInApi($postData);
            $pageCount = 0;
            $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
            $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;
            $coupons = [];
            if($rowCount > 0){
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $coupons = $this->Mcustomercoupons->getListInApi($postData, $perPage, $page);
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