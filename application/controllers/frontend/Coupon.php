<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('login', $this->language);


    }

    public function index() {
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons'));
       
        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Coupons');
        $data['activeMenu'] = "coupons";
        /**
         * Commons data
         */
        $per_page = $this->input->get('per_page');
        $data['per_page'] =  $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] =  $search_text;
        $order_by = $this->input->get('order_by');
        $data['order_by'] =  $order_by;
        $serviceId = $this->input->get('service');
        $data['service'] =  $serviceId;
        $savedCoupons = $this->Mcustomercoupons->getListFieldValue(array('customer_id' => $data['customer']['id'], 'customer_coupon_status_id >' => 0), 'coupon_id');

        $serviceIds = $this->Mbusinessprofiles->getListFieldValue(array('business_status_id >' => 0), 'service_id', 0);
        if(!empty($serviceIds)) $serviceIds = array_unique($serviceIds);
        
        if(!empty($serviceId)){
            $businessProfileIds = $this->Mbusinessprofiles->getListFieldValue(array('service_id' => $serviceId), 'id', 0);
        }else{
            $businesses = $this->Mbusinessprofiles->search(array('service_ids' => $serviceIds));
            $businessProfileIds = array();
            foreach($businesses as $itemBusiness){
                $businessProfileIds[] = $itemBusiness['id'];
            }
        }
        
        
        $getData = array(
            'coupon_status_id' => STATUS_ACTIVED, 
            'search_text_fe' => $search_text, 
            'saved_coupons' => $savedCoupons,
            'business_profile_ids' => $businessProfileIds,
            'order_by' => $order_by
        );

        $data['businessProfiles'] = array();
        $data['serviceTypes'] = array();

        $data['listServices'] = $this->Mservices->getByIds(array('service_ids' => $serviceIds), $data['language_id']);
        if(!empty($serviceId) && $serviceId > 0){
            $service_type_name = "service_type_name_".$this->Mconstants->languageCodes[$data['language_id']];
            $data['serviceTypes'] = $this->Mservicetypes->getListByServices(array('service_id' => $serviceId), $service_type_name);
        }
        
        
        $rowCount = $this->Mcoupons->getCount($getData);
        $data['lists'] = array();
        
        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_COUPON;
        //$perPage = 2;
        if(is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if(!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('coupons.html');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'].'?page={$1}');
        /**
         * END - PAGINATION
         */
        
        $data['lists'] = $this->Mcoupons->search($getData, $perPage, $page);
        foreach($data['lists'] as $kCoupon => $itemCoupon){
            $data['lists'][$kCoupon]['coupon_amount_used'] = $this->Mcustomercoupons->getUsedCoupon($itemCoupon['id']);
        }
       
        $this->load->view('frontend/coupon/customer-coupon', $data);
    }

    public function detail($slug = '', $id = 0) {
        if(empty($id)){
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                redirect(base_url('coupons.html'));
            }
        }

        $this->loadModel(array('Mconfigs', 'Mservices', 'Mbusinessprofiles', 'Mcoupons', 'Mcustomercoupons'));

        $couponId = $this->Mcoupons->getFieldValue(array('id' => $id, 'coupon_status_id' => STATUS_ACTIVED), 'id', 0);

        if($couponId == 0){
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                redirect(base_url('coupons.html'));
            }
        }

        $detailInfo = $this->Mcoupons->get($couponId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($detailInfo['coupon_subject']);
        $data['activeMenu'] = "coupons";
        /**
         * Commons data
         */

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != current_url()) {
            $data['backUrl'] = $_SERVER['HTTP_REFERER'];
        }else{
            $data['backUrl'] = base_url('coupons.html');
        }

       
        $data['detailInfo'] = $detailInfo;
        $data['detailInfo']['coupon_image'] = (!empty($data['detailInfo']['coupon_image'])) ? COUPONS_PATH . $data['detailInfo']['coupon_image'] : COUPONS_PATH . NO_IMAGE ;
        $data['detailInfo']['coupon_amount_used'] = $this->Mcustomercoupons->getUsedCoupon($couponId);

        $data['businessInfo'] = $this->Mbusinessprofiles->get($data['detailInfo']['business_profile_id']);
        
        $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_id' => $data['customer']['id'], 'coupon_id' => $couponId, 'customer_coupon_status_id' => STATUS_ACTIVED), 'id', 0);
        
        $data['customerCoupon'] = array();
        if($customerCouponId > 0){
            $data['customerCoupon'] = $this->Mcustomercoupons->get($customerCouponId);
        }

        $this->load->view('frontend/coupon/um-coupon-detail', $data);
    }
    
}