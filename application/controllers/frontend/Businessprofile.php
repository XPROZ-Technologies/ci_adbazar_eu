<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Businessprofile extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('login', $this->language);
    }

    public function index($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessURL = trim($slug);
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mphonecodes', 'Mbusinessprofilelocations', 'Mlocations', 'Mopeninghours'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);
        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "about-us";

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);

        $data['businessInfo'] = $businessInfo;
        $data['phoneCodeInfo'] = array();
        if ($businessInfo['country_code_id'] > 0) {
            $data['phoneCodeInfo'] = $this->Mphonecodes->get($businessInfo['country_code_id']);
        }

        $businessLocationId = $this->Mbusinessprofilelocations->getFieldValue(array('business_profile_id' => $businessInfo['id'], 'business_profile_location_status_id' => STATUS_ACTIVED), 'location_id', 0);
        $data['locationInfo'] = array();
        if ($businessLocationId > 0) {
            $data['locationInfo'] = $this->Mlocations->get($businessLocationId);
        }
        $service_type_name = "service_type_name_" . $this->Mconstants->languageCodes[$data['language_id']];
        $data['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($businessProfileId, $service_type_name);

        $businessOpeningHours = $this->Mopeninghours->getBy(array('business_profile_id' => $businessProfileId));
        $data['businessOpeningHours'] = array();
        foreach($businessOpeningHours as $itemHours){
            $data['businessOpeningHours'][$itemHours['day_id']]['day_id'] = $itemHours['day_id'];
            $data['businessOpeningHours'][$itemHours['day_id']]['start_time'] = $itemHours['start_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['end_time'] = $itemHours['end_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['opening_hours_status_id'] = $itemHours['opening_hours_status_id'];
        }
        if(!empty($data['businessOpeningHours'])) ksort($data['businessOpeningHours']);

        $this->load->view('frontend/business/bp-about-us', $data);
    }

    public function gallery($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessURL = trim($slug);
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mbusinessphotos', 'Mbusinessvideos'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);
        /**
         * Commons data
         */
        $data = $this->commonDataCustomer(
            $businessInfo['business_name'],
            array(
                'scriptHeader' => array('css' => 'vendor/plugins/slick/slick.css'),
                'scriptFooter' => array('js' => 'vendor/plugins/slick/slick.min.js')
            )
        );
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "gallery";

        $data['businessInfo'] = $businessInfo;

        $data['businessPhotos'] = $this->Mbusinessphotos->getBy(array('business_profile_id' => $businessProfileId));
        $data['businessVideos'] = $this->Mbusinessvideos->getBy(array('business_profile_id' => $businessProfileId));

        $this->load->view('frontend/business/bp-gallery', $data);
    }

    public function coupons($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessURL = trim($slug);
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);
        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "coupons";

        $data['businessInfo'] = $businessInfo;


        $per_page = $this->input->get('per_page');
        $data['per_page'] =  $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] =  $search_text;

        $getData = array(
            'coupon_status_id' => STATUS_ACTIVED,
            'search_text_fe' => $search_text,
            'business_profile_id' => $businessProfileId
        );

        $rowCount = $this->Mcoupons->getCount($getData);
        $data['lists'] = array();

        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_COUPON;
        //$perPage = 2;
        if (is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('business/' . $businessInfo['business_url'] . '/coupons');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mcoupons->search($getData, $perPage, $page);
        foreach ($data['lists'] as $kCoupon => $itemCoupon) {
            $data['lists'][$kCoupon]['coupon_amount_used'] = $this->Mcustomercoupons->getUsedCoupon($itemCoupon['id']);
        }


        $this->load->view('frontend/business/bp-coupon', $data);
    }

    public function events($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessURL = trim($slug);

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mevents'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "events";

        $data['businessInfo'] = $businessInfo;


        $per_page = $this->input->get('per_page');
        $data['per_page'] = $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] = $search_text;

        $getData = array(
            'event_status_id' => STATUS_ACTIVED,
            'search_text_fe' => $search_text,
            'business_profile_id' => $businessProfileId
        );
        $rowCount = $this->Mevents->getCount($getData);
        $data['lists'] = array();

        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_BUSINESS_PROFILE;
        //$perPage = 2;
        if (is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('business/' . $businessInfo['business_url'] . '/events');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mevents->search($getData, $perPage, $page);
        for ($i = 0; $i < count($data['lists']); $i++) {
            $data['lists'][$i]['business_name'] = $this->Mbusinessprofiles->getFieldValue(array('id' => $data['lists'][$i]['business_profile_id'], 'business_status_id' => STATUS_ACTIVED), 'business_name', '');
            $data['lists'][$i]['event_image'] = (!empty($data['lists'][$i]['event_image'])) ? EVENTS_PATH . $data['lists'][$i]['event_image'] : EVENTS_PATH . NO_IMAGE;
        }


        $this->load->view('frontend/business/bp-event', $data);
    }

    /**
     * MANAGE BUSINESS PROFILE
     */
    public function my_business()
    {
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('My Business Profile');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessProfiles = $this->Mbusinessprofiles->getCount(array('customer_id' => $data['customer']['id']));

        if ($businessProfiles == 0) {
            redirect('business-profile/select-plan');
        }

        $data['businessProfiles'] = $this->Mbusinessprofiles->search(array('customer_id' => $data['customer']['id']));

        $this->load->view('frontend/business/bm-list', $data);
    }

    public function select_plan()
    {
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('My Business Profile');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL . '?e1'));
        }

        $this->load->view('frontend/business/bm-plan', $data);
    }

    public function submitSelectPlan()
    {
        try {
            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles', 'Mcustomers'));

            $postData = $this->arrayFromPost(array('business_plan'));

            $expired_date = date('Y-m-d', strtotime("+3 months"));

            if (empty($postData['business_plan'])) {
                $this->session->set_flashdata('notice_message', "Plan does not exist");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('business-profile/select-plan?0'));
            }

            $this->loadModel(array('Mcustomers', 'Mconfigs'));

            /**
             * Commons data
             */
            $data = $this->commonDataCustomer('');
            /**
             * Commons data
             */

            if ($data['customer']['id'] == 0) {
                $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url(HOME_URL . '?e2'));
            }

            $customerId = $this->Mcustomers->getFieldValue(array('id' => $data['customer']['id'], 'customer_status_id' => STATUS_ACTIVED), 'id', 0);

            if ($customerId > 0) {
                $customerInfo = $this->Mcustomers->updateBy(
                    array(
                        'id' => $customerId
                    ),
                    array(
                        'free_trial_type' => $postData['business_plan']
                    )
                );
                if ($customerInfo) {
                    redirect(base_url('business-profile/got-free-trial?plan=' . $postData['business_plan']));
                } else {
                    $this->session->set_flashdata('notice_message', "Plan doest not exist, please try again");
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('business-profile/select-plan?1'));
                }
            } else {
                $this->session->set_flashdata('notice_message', "You do not have permission on this page");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url(HOME_URL . '?e3'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL . '?e4'));
        }
    }

    public function got_free_trial()
    {
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles', 'Mcustomers'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('My Business Profile');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $data['plan'] = $this->input->get('plan');

        if (!in_array($data['plan'], array(1, 2))) {
            $this->session->set_flashdata('notice_message', "Plan does not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('business-profile/my-business-profile'));
        }

        $this->load->view('frontend/business/bm-plan-success', $data);
    }

    public function create_new_business()
    {
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles', 'Mcustomers', 'Mservices', 'Mphonecodes'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Create New Business');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $data['plan'] = $this->input->get('plan');

        if (!in_array($data['plan'], array(1, 2))) {
            $this->session->set_flashdata('notice_message', "Plan does not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('business-profile/my-business-profile'));
        }

        $data['listServices'] = $this->Mservices->getHighlightListByLang($data['language_id']);

        $data['phoneCodes'] = $this->Mphonecodes->get();

        $this->load->view('frontend/business/bm-plan-create', $data);
    }

    public function updateBusiness()
    {
        try {
            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles', 'Mcustomers', 'Mservices', 'Mopeninghours'));

            /**
             * Commons data
             */
            $data = $this->commonDataCustomer('');
            $data['activeMenu'] = "";
            /**
             * Commons data
             */

            $postData = $this->arrayFromPost(array('service_id', 'business_name', 'business_slogan', 'business_email', 'business_address', 'business_whatsapp', 'business_url', 'business_phone', 'business_description', 'country_code_id'));


            $postData['business_status_id'] = STATUS_ACTIVED;
            $postData['customer_id'] = $data['customer']['id'];
            $postData['created_at'] = getCurentDateTime();
            $postData['created_by'] = 0; //customer create business

            
            $open_hours = $this->input->post('open_hours');
            
            $openingHours = array();
            foreach($this->Mconstants->dayIds as $day_id => $itemHours){
                
                if(isset($open_hours[$day_id])){
                    $itemHours = $open_hours[$day_id];
                    $itemDay = array();
                    $itemDay['day_id'] = $day_id;
                    if(isset($itemHours['opening_hours_status_id']) && $itemHours['opening_hours_status_id'] == 'on'){
                        $itemDay['opening_hours_status_id'] = STATUS_ACTIVED;
                    }else{
                        $itemDay['opening_hours_status_id'] = 1;
                    }   
                    
                    if(!empty($itemHours['start_time'])){
                        $itemDay['start_time'] = $itemHours['start_time'];
                    }else{
                        $itemDay['start_time'] = "00:00";
                    }

                    if(!empty($itemHours['end_time'])){
                        $itemDay['end_time'] = $itemHours['end_time'];
                    }else{
                        $itemDay['end_time'] = "23:59";
                    }
                    
                }else{
                    $itemDay = array();
                    $itemDay['day_id'] = $day_id;
                    $itemDay['opening_hours_status_id'] = 1;
                    $itemDay['start_time'] = "00:00";
                    $itemDay['end_time'] = "00:00";
                }

                $openingHours[] = $itemDay;
                
            }
            //echo "<pre>";print_r($openingHours);die;

            $businessServiceTypes = array();

            $businessProfileId = $this->Mbusinessprofiles->save($postData);
            if ($businessProfileId > 0) {
                   
                    $dataUpdate = array();
                    $businessAvatarUpload = $this->input->post('business_avatar_upload');
                    if(!empty($businessAvatarUpload)){
                        $avatarUpload = $this->uploadImageBase64($businessAvatarUpload, 7);
                        $dataUpdate['business_avatar'] = replaceFileUrl($avatarUpload, BUSINESS_PROFILE_PATH);
                    }
                    $businessCoverUpload = $this->input->post('business_cover_upload');
                    if(!empty($businessCoverUpload)){
                        $coverUpload = $this->uploadImageBase64($businessCoverUpload, 7);
                        $dataUpdate['business_image_cover'] = replaceFileUrl($coverUpload, BUSINESS_PROFILE_PATH);
                    }
                    if(!empty($dataUpdate)){
                        $businessProfileId = $this->Mbusinessprofiles->update($dataUpdate, $businessProfileId);
                    }

                    
                    $resultOpenHours = $this->Mopeninghours->saveOpenHours($openingHours, $businessProfileId);
                    
                    
                    $this->session->set_flashdata('notice_message', "Create your business profile successfully");
                    $this->session->set_flashdata('notice_type', 'success');
                    redirect(base_url('my-business-profile'));
                
            } else {
                $this->session->set_flashdata('notice_message', "Create business profile failed");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('my-business-profile?1'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('my-business-profile?2'));
        }
    }
    /**
     * END. MANAGE BUSINESS PROFILE
     */

    public function detail($slug = '', $id = 0)
    {
        if (empty($id)) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                redirect('coupons.html');
            }
        }

        $this->loadModel(array('Mconfigs', 'Mservices', 'Mbusinessprofiles', 'Mcoupons', 'Mcustomercoupons'));

        $couponId = $this->Mcoupons->getFieldValue(array('id' => $id, 'coupon_status_id' => STATUS_ACTIVED), 'id', 0);

        if ($couponId == 0) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                redirect('coupons.html');
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


        $data['detailInfo'] = $detailInfo;
        $data['detailInfo']['coupon_image'] = (!empty($data['detailInfo']['coupon_image'])) ? COUPONS_PATH . $data['detailInfo']['coupon_image'] : COUPONS_PATH . NO_IMAGE;
        $data['detailInfo']['coupon_amount_used'] = $this->Mcustomercoupons->getUsedCoupon($couponId);

        $data['businessInfo'] = $this->Mbusinessprofiles->get($data['detailInfo']['business_profile_id']);

        $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_id' => $data['customer']['id'], 'coupon_id' => $couponId, 'customer_coupon_status_id' => STATUS_ACTIVED), 'id', 0);

        $data['customerCoupon'] = array();
        if ($customerCouponId > 0) {
            $data['customerCoupon'] = $this->Mcustomercoupons->get($customerCouponId);
        }

        $this->load->view('frontend/coupon/um-coupon-detail', $data);
    }


    /**
     * BUSINESS MANAGEMENT
     */

    public function manage_about_us($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessURL = trim($slug);
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mphonecodes', 'Mbusinessprofilelocations', 'Mlocations', 'Mopeninghours'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);
        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("My Profile - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */
        

        $data['activeBusinessMenu'] = "about-us";

        $data['businessInfo'] = $businessInfo;
        $data['phoneCodeInfo'] = array();
        if ($businessInfo['country_code_id'] > 0) {
            $data['phoneCodeInfo'] = $this->Mphonecodes->get($businessInfo['country_code_id']);
        }

        
        $businessLocationId = $this->Mbusinessprofilelocations->getFieldValue(array('business_profile_id' => $businessProfileId, 'business_profile_location_status_id' => STATUS_ACTIVED), 'location_id', 0);
        $data['locationInfo'] = array();
        if ($businessLocationId > 0) {
            $data['locationInfo'] = $this->Mlocations->get($businessLocationId);
        }

        


        $service_type_name = "service_type_name_" . $this->Mconstants->languageCodes[$data['language_id']];
        $data['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($businessProfileId, $service_type_name);

        

        $businessOpeningHours = $this->Mopeninghours->getBy(array('business_profile_id' => $businessProfileId));
        $data['businessOpeningHours'] = array();
        foreach($businessOpeningHours as $itemHours){
            $data['businessOpeningHours'][$itemHours['day_id']]['day_id'] = $itemHours['day_id'];
            $data['businessOpeningHours'][$itemHours['day_id']]['start_time'] = $itemHours['start_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['end_time'] = $itemHours['end_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['opening_hours_status_id'] = $itemHours['opening_hours_status_id'];
        }
        if(!empty($data['businessOpeningHours'])) ksort($data['businessOpeningHours']);

        $this->load->view('frontend/business/bm-profile', $data);
    }

    public function manage_profile_edit($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessURL = trim($slug);
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mphonecodes', 'Mbusinessprofilelocations', 'Mlocations', 'Mopeninghours'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);
        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("My Profile - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */
        

        $data['activeBusinessMenu'] = "about-us";

        $data['businessInfo'] = $businessInfo;
        $data['phoneCodeInfo'] = array();
        if ($businessInfo['country_code_id'] > 0) {
            $data['phoneCodeInfo'] = $this->Mphonecodes->get($businessInfo['country_code_id']);
        }

        
        $businessLocationId = $this->Mbusinessprofilelocations->getFieldValue(array('business_profile_id' => $businessProfileId, 'business_profile_location_status_id' => STATUS_ACTIVED), 'location_id', 0);
        $data['locationInfo'] = array();
        if ($businessLocationId > 0) {
            $data['locationInfo'] = $this->Mlocations->get($businessLocationId);
        }
        
        $businessOpeningHours = $this->Mopeninghours->getBy(array('business_profile_id' => $businessProfileId));
        $data['businessOpeningHours'] = array();
        foreach($businessOpeningHours as $itemHours){
            $data['businessOpeningHours'][$itemHours['day_id']]['day_id'] = $itemHours['day_id'];
            $data['businessOpeningHours'][$itemHours['day_id']]['start_time'] = $itemHours['start_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['end_time'] = $itemHours['end_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['opening_hours_status_id'] = $itemHours['opening_hours_status_id'];
        }
        if(!empty($data['businessOpeningHours'])) ksort($data['businessOpeningHours']);

        $data['listServices'] = $this->Mservices->getHighlightListByLang($data['language_id']);

        $service_type_name = "service_type_name_" . $this->Mconstants->languageCodes[$data['language_id']];
        $data['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($businessProfileId, $service_type_name);

        $this->load->view('frontend/business/bm-profile-edit', $data);
    }

    public function manage_gallery($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessURL = trim($slug);
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mbusinessphotos', 'Mbusinessvideos'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);
        /**
         * Commons data
         */
        $data = $this->commonDataCustomer(
            "Gallery - ".$businessInfo['business_name'],
            array(
                'scriptHeader' => array('css' => 'vendor/plugins/slick/slick.css'),
                'scriptFooter' => array('js' => 'vendor/plugins/slick/slick.min.js')
            )
        );
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "gallery";

        $data['businessInfo'] = $businessInfo;

        $data['businessPhotos'] = $this->Mbusinessphotos->getBy(array('business_profile_id' => $businessProfileId));
        $data['businessVideos'] = $this->Mbusinessvideos->getBy(array('business_profile_id' => $businessProfileId));

        $this->load->view('frontend/business/bm-gallery', $data);
    }

    public function manage_coupons($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessURL = trim($slug);
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);
        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("Coupons - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "coupons";

        $data['businessInfo'] = $businessInfo;


        $per_page = $this->input->get('per_page');
        $data['per_page'] =  $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] =  $search_text;

        $getData = array(
            'coupon_status_id' => STATUS_ACTIVED,
            'search_text_fe' => $search_text,
            'business_profile_id' => $businessProfileId
        );

        $rowCount = $this->Mcoupons->getCount($getData);
        $data['lists'] = array();

        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_COUPON;
        //$perPage = 2;
        if (is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('business-management/' . $businessInfo['business_url'] . '/coupons');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mcoupons->search($getData, $perPage, $page);
        foreach ($data['lists'] as $kCoupon => $itemCoupon) {
            $data['lists'][$kCoupon]['coupon_amount_used'] = $this->Mcustomercoupons->getUsedCoupon($itemCoupon['id']);
        }


        $this->load->view('frontend/business/bm-coupon', $data);
    }

    public function manage_create_coupon($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessURL = trim($slug);

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mevents'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("Create Coupon - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "";

        $data['businessInfo'] = $businessInfo;


        

        $this->load->view('frontend/business/bm-coupon-create', $data);
    }

    public function manage_events($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessURL = trim($slug);

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mevents'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("Events - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "events";

        $data['businessInfo'] = $businessInfo;


        $per_page = $this->input->get('per_page');
        $data['per_page'] = $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] = $search_text;

        $getData = array(
            'event_status_id' => STATUS_ACTIVED,
            'search_text_fe' => $search_text,
            'business_profile_id' => $businessProfileId
        );
        $rowCount = $this->Mevents->getCount($getData);
        $data['lists'] = array();

        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_BUSINESS_PROFILE;
        //$perPage = 2;
        if (is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('business-management/' . $businessInfo['business_url'] . '/events');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mevents->search($getData, $perPage, $page);
        for ($i = 0; $i < count($data['lists']); $i++) {
            $data['lists'][$i]['business_name'] = $this->Mbusinessprofiles->getFieldValue(array('id' => $data['lists'][$i]['business_profile_id'], 'business_status_id' => STATUS_ACTIVED), 'business_name', '');
            $data['lists'][$i]['event_image'] = (!empty($data['lists'][$i]['event_image'])) ? EVENTS_PATH . $data['lists'][$i]['event_image'] : EVENTS_PATH . NO_IMAGE;
        }


        $this->load->view('frontend/business/bm-event', $data);
    }

    public function manage_create_event($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessURL = trim($slug);

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mevents'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("Create Event - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "";

        $data['businessInfo'] = $businessInfo;


        

        $this->load->view('frontend/business/bm-event-create', $data);
    }

    public function manage_reviews($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessURL = trim($slug);

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mevents'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("Reviews - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "reviews";

        $data['businessInfo'] = $businessInfo;

        $this->load->view('frontend/business/bm-review', $data);
    }

    public function manage_reservations($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessURL = trim($slug);

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mevents'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("Reservations - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "reservations";

        $data['businessInfo'] = $businessInfo;

        $this->load->view('frontend/business/bm-reservation', $data);
    }

    public function manage_subscriptions($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessURL = trim($slug);

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mevents'));

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
        $businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("Subscriptions - ".$businessInfo['business_name']);
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['activeBusinessMenu'] = "subscriptions";

        $data['businessInfo'] = $businessInfo;

        $this->load->view('frontend/business/bm-subscription', $data);
    }

    /**
     * END. BUSINESS PROFILE MANAGEMENT
     */
}
