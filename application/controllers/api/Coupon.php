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
            $this->load->model('Mcoupons');
            $coupons = $this->Mcoupons->getListHome();
            for($i = 0; $i < count($coupons); $i++){
                $coupons[$i]['coupon_image'] = !empty($coupons[$i]['coupon_image']) ? base_url(COUPONS_PATH.$coupons[$i]['coupon_image']) : '';
            }
            $this->success200(array('list' => $coupons));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}