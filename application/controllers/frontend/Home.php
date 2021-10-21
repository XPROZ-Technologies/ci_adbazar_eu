<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
        $this->getLanguageFE();
    }

    public function index() {
        $this->loadModel(array('Mcustomers','Mconfigs', 'Mlocations', 'Mservices', 'Msliders', 'Mcoupons', 'Mbusinessprofiles', 'Mservicetypes', 'Mcustomercoupons'));
        
        /**
         * Commons data
         */


        $data = $this->commonDataCustomer($this->lang->line('homepage'));
        $data['activeMenu'] = "home";
        /**
         * Commons data
         */

        $data['listSlidersHome'] = $this->Msliders->getBy(array('slider_status_id' => STATUS_ACTIVED, 'slider_type_id' => 1), false, 'display_order','', 0, 0, 'asc');

        $data['services'] = $this->Mservices->getHighlightListByLang($data['language_id'] );

        $data['listSlidersEvent'] = $this->Msliders->getBy(array('slider_status_id' => STATUS_ACTIVED, 'slider_type_id' => 2), false, 'display_order','', 0, 0, 'asc');

        $savedCoupons = $this->Mcustomercoupons->getListFieldValue(array('customer_id' => $data['customer']['id'], 'customer_coupon_status_id >' => 0), 'coupon_id');
        $data['listCoupons'] = $this->Mcoupons->search(array('coupon_status_id' => STATUS_ACTIVED, 'is_hot' => 2, 'saved_coupons' => $savedCoupons, 'is_full' => 0));
        foreach($data['listCoupons'] as $kCoupon => $itemCoupon){
            $data['listCoupons'][$kCoupon]['coupon_amount_used'] = $this->Mcustomercoupons->getUsedCoupon($itemCoupon['id']);
        }

        $data['locations'] = $this->Mlocations->getBy(array('location_status_id' => STATUS_ACTIVED));

        
        /**
         * Business profile on Map
         */
        $service_type_name = "service_type_name_".$this->Mconstants->languageShortCodes[$data['language_id']];
        $service_id = $this->input->get('service_id');
        if(empty($service_id)){ $service_id = 0; }
        $data['service_id'] = $service_id;
        $search_text = $this->input->get('keyword');
        $data['keyword'] = $search_text;
        $getData = array('business_status_id' => STATUS_ACTIVED, 'search_text_fe' => $search_text, 'service_id' => $service_id);
        $rowCount = $this->Mbusinessprofiles->getCount($getData);
        $data['listProfiles'] = array();
        
            /**
             * PAGINATION
             */
            $perPage = DEFAULT_LIMIT_BUSINESS_PROFILE_MAP;
            //$perPage = 2;
            $per_page = $this->input->get('per_page');
            if(is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
            $pageCount = ceil($rowCount / $perPage);
            $page = $this->input->get('page');
            if(!is_numeric($page) || $page < 1) $page = 1;
            $data['basePagingUrl'] = base_url(HOME_URL);
            $data['perPage'] = $perPage;
            $data['page'] = $page;
            $data['rowCount'] = $rowCount;
            $data['paggingHtml'] = getPaggingHtmlFront_2($page, $pageCount, $data['basePagingUrl'].'?page={$1}#maps');
            /**
             * END - PAGINATION
             */
        

        $data['listProfiles'] = $this->Mbusinessprofiles->search($getData, $perPage, $page);
        for($i = 0; $i < count($data['listProfiles']); $i++){
            
            $data['listProfiles'][$i]['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($data['listProfiles'][$i]['id'], $service_type_name);
            $data['listProfiles'][$i]['isOpen'] = $this->checkBusinessOpenHours($data['listProfiles'][$i]['id']);
        }

        $service_ids = array();
        $data['listProfilesMap'] = $this->Mbusinessprofiles->search($getData);
        for($i = 0; $i < count($data['listProfilesMap']); $i++){
            if(isset($data['listProfilesMap'][$i])){
                $service_ids[] = $data['listProfilesMap'][$i]['service_id'];
                $data['listProfilesMap'][$i]['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($data['listProfilesMap'][$i]['id'], $service_type_name);
                $data['listProfilesMap'][$i]['isOpen'] = $this->checkBusinessOpenHours($data['listProfilesMap'][$i]['id']);
                $data['listProfilesMap'][$i]['locationInfo'] = $this->Mbusinessprofiles->getBusinessInLocation($data['listProfilesMap'][$i]['id']);
            }
        }
        $data['listServices'] = array();
        foreach($data['services'] as $itemService){
            if(in_array($itemService['id'], $service_ids)){
                $data['listServices'][] = $itemService;
            }
        }

        $data['home_video'] = $this->Mconfigs->getConfigValueByLang('VIDEO_URL', $data['language_id']);
       
        /**
         * END. Business profile on Map
         */

        //echo "<pre>";print_r($data['listServices']);

        $this->load->view('frontend/home/index', $data);
    }

    public function getListProfile() {
        try {
            $data = $this->commonDataCustomer('Home');

            $this->loadModel(array('Mbusinessprofiles', 'Mservicetypes'));

            $postData = $this->arrayFromPost(array('search_text', 'service_id'));
            $postData['business_status_id'] = STATUS_ACTIVED;

            $page = $this->input->post('page');
            $per_page = $this->input->post('per_page');
            $perPage = DEFAULT_LIMIT_BUSINESS_PROFILE_MAP;
            if(is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
            $rowCount = $this->Mbusinessprofiles->getCount($postData);

            $service_type_name = "service_type_name_".$this->Mconstants->languageShortCodes[$data['language_id']];

            $listProfiles = $this->Mbusinessprofiles->search($postData, $perPage, $page);
            for($i = 0; $i < count($listProfiles); $i++){
            
                $listProfiles[$i]['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($listProfiles[$i]['id'], $service_type_name);
                $listProfiles[$i]['isOpen'] = $this->checkBusinessOpenHours($listProfiles[$i]['id']);
                $listProfiles[$i]['rating'] = $this->getBusinessRating($listProfiles[$i]['id']);
            }
            $pageCount = ceil($rowCount / $perPage);

            $listProfilesMap = $this->Mbusinessprofiles->search($postData);
            $listLocations = array();
            for($i = 0; $i < count($listProfilesMap); $i++){
                if(isset($listProfilesMap[$i])){
                    $listProfilesMap[$i]['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($listProfilesMap[$i]['id'], $service_type_name);
                    $listProfilesMap[$i]['isOpen'] = $this->checkBusinessOpenHours($listProfilesMap[$i]['id']);
                    $listProfilesMap[$i]['locationInfo'] = $this->Mbusinessprofiles->getBusinessInLocation($listProfilesMap[$i]['id']);
                    $listProfilesMap[$i]['rating'] = $this->getBusinessRating($listProfilesMap[$i]['id']);
                    if(!empty($listProfilesMap[$i]['locationInfo'])){
                        $listLocations[] = $listProfilesMap[$i];
                    }
                }
            }
            echo json_encode(array('code' => 1, 'message' => 'Data', 'data' => $listProfiles, 'page' => $page, 'per_page' => $perPage, 'page_count' => $pageCount, 'listProfilesMap' => $listLocations));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        }
    }
    

    public function about() {
        $this->loadModel(array('Mcustomers','Mconfigs', 'Mlocations', 'Mservices', 'Msliders', 'Mcoupons', 'Mbusinessprofiles', 'Mservicetypes', 'Mcustomercoupons'));
        
        /**
         * Commons data
         */


        $data = $this->commonDataCustomer($this->lang->line('about_us'));
        $data['activeMenu'] = "about-us";
        /**
         * Commons data
         */

        $data['about']['img_banner'] = CONFIG_PATH . $this->Mconfigs->getConfigValueByLang('ABOUT_US_IMAGE_BANNER', $data['language_id']);
        $data['about']['child_text_1'] = $this->Mconfigs->getConfigValueByLang('ABOUT_US_CHILD_TEXT_1', $data['language_id']);
        $data['about']['child_img_1'] = CONFIG_PATH . $this->Mconfigs->getConfigValueByLang('ABOUT_US_CHILD_IMAGE_1', $data['language_id']);
        $data['about']['child_text_2'] = $this->Mconfigs->getConfigValueByLang('ABOUT_US_CHILD_TEXT_2', $data['language_id']);
        $data['about']['child_img_2'] = CONFIG_PATH . $this->Mconfigs->getConfigValueByLang('ABOUT_US_CHILD_IMAGE_2', $data['language_id']);
        $data['about']['about_text_bottom'] = $this->Mconfigs->getConfigValueByLang('ABOUT_US_TEXT', $data['language_id']);

        // echo "<pre>";
        // print_r($data['about']);
        // echo "</pre>";
        

        $this->load->view('frontend/home/about', $data);
    }

    public function term() {
        $this->loadModel(array('Mcustomers','Mconfigs'));
        
        /**
         * Commons data
         */


        $data = $this->commonDataCustomer('Term of Use');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['content'] = $this->Mconfigs->getConfigValueByLang('TERM_OF_USE', $data['language_id']);

        $this->load->view('frontend/home/term', $data);
    }

    public function privacy() {
        $this->loadModel(array('Mcustomers','Mconfigs'));
        
        /**
         * Commons data
         */


        $data = $this->commonDataCustomer('Privacy Policy');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['content'] = $this->Mconfigs->getConfigValueByLang('PRIVACY_POLICY', $data['language_id']);
        

        $this->load->view('frontend/home/term', $data);
    }
}