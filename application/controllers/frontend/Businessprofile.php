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
        //$this->lang->load('login', $this->language);
    }

    /**
     * USER MANAGEMENT
     */
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
        $service_type_name = "service_type_name_" . $this->Mconstants->languageShortCodes[$data['language_id']];
        $data['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($businessProfileId, $service_type_name);

        $businessOpeningHours = $this->Mopeninghours->getBy(array('business_profile_id' => $businessProfileId));
        $data['businessOpeningHours'] = array();
        foreach ($businessOpeningHours as $itemHours) {
            $data['businessOpeningHours'][$itemHours['day_id']]['day_id'] = $itemHours['day_id'];
            $data['businessOpeningHours'][$itemHours['day_id']]['start_time'] = $itemHours['start_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['end_time'] = $itemHours['end_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['opening_hours_status_id'] = $itemHours['opening_hours_status_id'];
        }
        if (!empty($data['businessOpeningHours'])) ksort($data['businessOpeningHours']);

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

    public function reviews($slug = "")
    {
        if (empty($slug)) {
            $this->session->set_flashdata('notice_message', "Business profile not exist");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $businessURL = trim($slug);

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles', 'Mcustomerreviews', 'Mcustomers'));

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

        $data['activeBusinessMenu'] = "reviews";

        $data['businessInfo'] = $businessInfo;


        $per_page = $this->input->get('per_page');
        $data['per_page'] = $per_page;
        $order_by = $this->input->get('order_by');
        $data['order_by'] =  $order_by;
        $review_star = $this->input->get('review_star');
        $data['review_star'] =  $review_star;

        $getData = array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'order_by' => $order_by,
            'review_star' => $review_star
        );
        $rowCount = $this->Mcustomerreviews->getCount($getData);
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
        $data['basePagingUrl'] = base_url('business/' . $businessInfo['business_url'] . '/reviews');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mcustomerreviews->search($getData, $perPage, $page);
        for ($i = 0; $i < count($data['lists']); $i++) {
            $customerInfo = $this->Mcustomers->getBy(array('id' => $data['lists'][$i]['customer_id'], 'customer_status_id' => STATUS_ACTIVED), false, 'created_at', 'customer_first_name, customer_last_name, customer_avatar', 0, 0, 'asc');
            $data['lists'][$i]['customerInfo'] = $customerInfo[0];
        }

        $data['count_one_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 1
        ));

        $data['count_two_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 2
        ));

        $data['count_three_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 3
        ));

        $data['count_four_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 4
        ));

        $data['count_five_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 5
        ));

        $sumReview = ($data['count_one_star'] + $data['count_two_star'] + $data['count_three_star'] + $data['count_four_star'] + $data['count_five_star']);
        $data['overall_rating'] = 0;
        if ($sumReview > 0) {
            $data['overall_rating'] = ($data['count_one_star'] * 1 + $data['count_two_star'] * 2 + $data['count_three_star'] * 3 + $data['count_four_star'] * 4 + $data['count_five_star'] * 5) / ($data['count_one_star'] + $data['count_two_star'] + $data['count_three_star'] + $data['count_four_star'] + $data['count_five_star']);
        }

        $this->load->view('frontend/business/bp-review', $data);
    }

    public function leaveReview()
    {
        try {

            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mcustomerreviews'));

            /**
             * Commons data
             */
            $data = $this->commonDataCustomer('');
            $data['activeMenu'] = "";
            /**
             * Commons data
             */

            $postData = $this->arrayFromPost(array('customer_id', 'review_star', 'customer_comment'));

            $getBusinessId = $this->input->post('business_id');

            $postData['business_id'] = $getBusinessId;
            $postData['customer_review_status_id'] = STATUS_ACTIVED;
            $postData['created_at'] = getCurentDateTime();
            $postData['created_by'] = 0; //customer create business
            //echo "<pre>";print_r($postData);exit;
            $reviewId = $this->Mcustomerreviews->save($postData);
            if ($reviewId > 0) {
                echo json_encode(array('code' => 1, 'message' => "Leave a review successfully"));
                die;
            } else {
                echo json_encode(array('code' => 1, 'message' => "Leave a review failed"));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 1, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }

    public function leaveReply()
    {
        try {

            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mcustomerreviews'));

            /**
             * Commons data
             */
            $data = $this->commonDataCustomer('');
            $data['activeMenu'] = "";
            /**
             * Commons data
             */

            $postData = $this->arrayFromPost(array('business_comment'));

            $getReviewId = $this->input->post('review_id');
            $getBusinessId = $this->input->post('business_id');

            $replyReviewId = $this->Mcustomerreviews->getFieldValue(array('id' => $getReviewId, 'business_id' => $getBusinessId), 'id', 0);
            if ($replyReviewId > 0) {

                $postData['updated_at'] = getCurentDateTime();
                $postData['updated_by'] = 0; //customer create business

                $reviewId = $this->Mcustomerreviews->save($postData, $getReviewId);
                if ($reviewId > 0) {
                    echo json_encode(array('code' => 1, 'message' => "Reply customer review successfully"));
                    die;
                } else {
                    echo json_encode(array('code' => 1, 'message' => "Reply customer review failed"));
                    die;
                }
            } else {
                echo json_encode(array('code' => 1, 'message' => "Customer review not exist"));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 1, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }

    public function removeComment()
    {
        try {

            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mcustomerreviews'));

            /**
             * Commons data
             */
            $data = $this->commonDataCustomer('');
            $data['activeMenu'] = "";
            /**
             * Commons data
             */

            $reviewId = $this->input->post('review_id');
            $getBusinessId = $this->input->post('business_id');

            $delReviewId = $this->Mcustomerreviews->getFieldValue(array('id' => $reviewId, 'business_id' => $getBusinessId), 'id', 0);
            if ($delReviewId > 0) {
                $postData['customer_review_status_id'] = 0;
                $postData['deleted_at'] = getCurentDateTime();

                $reviewId = $this->Mcustomerreviews->save($postData, $reviewId);

                if ($reviewId > 0) {
                    echo json_encode(array('code' => 1, 'message' => "Delete review successfully"));
                    die;
                } else {
                    echo json_encode(array('code' => 1, 'message' => "Delete review failed"));
                    die;
                }
            } else {
                echo json_encode(array('code' => 1, 'message' => "Review not exist"));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 1, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }

    public function reservation($slug = "")
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

        $data['activeBusinessMenu'] = "reservation";

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


        $this->load->view('frontend/business/bp-reservation', $data);
    }

    public function book_reservation($slug = "")
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

        $data['activeBusinessMenu'] = "reservation";

        $data['businessInfo'] = $businessInfo;

        $this->load->view('frontend/business/bp-reservation-book', $data);
    }
    /**
     * END. USER MANAGEMENT
     */



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
            $this->session->set_flashdata('notice_message', "Please login to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl=' . current_url()));
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
            $this->session->set_flashdata('notice_message', "Please login to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl=' . current_url()));
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
                $this->session->set_flashdata('notice_message', "Please login to view this page");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('login.html?requiredLogin=1&redirectUrl=' . current_url()));
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
            $this->session->set_flashdata('notice_message', "Please login to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl=' . current_url()));
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
            $this->session->set_flashdata('notice_message', "Please login to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl=' . current_url()));
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

    public function createBusiness()
    {
        try {
            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles', 'Mcustomers', 'Mservices', 'Mopeninghours', 'Mbusinessservicetype'));

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
            foreach ($this->Mconstants->dayIds as $day_id => $itemHours) {

                if (isset($open_hours[$day_id])) {
                    $itemHours = $open_hours[$day_id];
                    $itemDay = array();
                    $itemDay['day_id'] = $day_id;
                    if (isset($itemHours['opening_hours_status_id']) && $itemHours['opening_hours_status_id'] == 'on') {
                        $itemDay['opening_hours_status_id'] = STATUS_ACTIVED;
                    } else {
                        $itemDay['opening_hours_status_id'] = 1;
                    }

                    if (!empty($itemHours['start_time'])) {
                        $itemDay['start_time'] = $itemHours['start_time'];
                    } else {
                        $itemDay['start_time'] = "00:00";
                    }

                    if (!empty($itemHours['end_time'])) {
                        $itemDay['end_time'] = $itemHours['end_time'];
                    } else {
                        $itemDay['end_time'] = "23:59";
                    }
                } else {
                    $itemDay = array();
                    $itemDay['day_id'] = $day_id;
                    $itemDay['opening_hours_status_id'] = 1;
                    $itemDay['start_time'] = "00:00";
                    $itemDay['end_time'] = "00:00";
                }

                $openingHours[] = $itemDay;
            }

            $service_type_ids = $this->input->post('service_type_ids');
            $businessServiceTypes = array();
            if (!empty($service_type_ids)) {
                $businessServiceTypes  = $service_type_ids;
            }

            $businessProfileId = $this->Mbusinessprofiles->save($postData);
            if ($businessProfileId > 0) {

                $dataUpdate = array();
                $businessAvatarUpload = $this->input->post('business_avatar_upload');
                if (!empty($businessAvatarUpload)) {
                    $avatarUpload = $this->uploadImageBase64($businessAvatarUpload, 7);
                    $dataUpdate['business_avatar'] = replaceFileUrl($avatarUpload, BUSINESS_PROFILE_PATH);
                }
                $businessCoverUpload = $this->input->post('business_cover_upload');
                if (!empty($businessCoverUpload)) {
                    $coverUpload = $this->uploadImageBase64($businessCoverUpload, 7);
                    $dataUpdate['business_image_cover'] = replaceFileUrl($coverUpload, BUSINESS_PROFILE_PATH);
                }
                if (!empty($dataUpdate)) {
                    $businessProfileId = $this->Mbusinessprofiles->update($dataUpdate, $businessProfileId);
                }

                //open hours
                if (!empty($openingHours)) {
                    $resultOpenHours = $this->Mopeninghours->saveOpenHours($openingHours, $businessProfileId);
                }

                //service types
                if (!empty($businessServiceTypes)) {
                    $resultServiceTypes = $this->Mbusinessservicetype->saveServiceType($businessServiceTypes, $businessProfileId);
                }

                $this->session->set_flashdata('notice_message', "Create your business profile successfully");
                $this->session->set_flashdata('notice_type', 'success');
                redirect(base_url('my-business-profile'));
            } else {
                $this->session->set_flashdata('notice_message', "Create business profile failed");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('my-business-profile'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('my-business-profile'));
        }
    }
    public function updateBusiness()
    {
        try {

            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles', 'Mcustomers', 'Mservices', 'Mopeninghours', 'Mbusinessservicetype'));

            /**
             * Commons data
             */
            $data = $this->commonDataCustomer('');
            $data['activeMenu'] = "";
            /**
             * Commons data
             */

            $postData = $this->arrayFromPost(array('service_id', 'business_name', 'business_slogan', 'business_email', 'business_address', 'business_whatsapp', 'business_phone', 'business_description', 'country_code_id'));

            $getBusinessId = $this->input->post('business_id');
            $getBusinessUrl = $this->input->post('business_url');
            $busId = $this->Mbusinessprofiles->getFieldValue(array('id' => $getBusinessId, 'business_url' => $getBusinessUrl), 'id', 0);

            if ($busId == 0) {
                $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url(HOME_URL));
            }

            $postData['business_status_id'] = STATUS_ACTIVED;
            $postData['customer_id'] = $data['customer']['id'];
            $postData['updated_at'] = getCurentDateTime();
            $postData['updated_by'] = 0; //customer create business


            $open_hours = $this->input->post('open_hours');

            $openingHours = array();
            foreach ($this->Mconstants->dayIds as $day_id => $itemHours) {

                if (isset($open_hours[$day_id])) {
                    $itemHours = $open_hours[$day_id];
                    $itemDay = array();
                    $itemDay['day_id'] = $day_id;
                    if (isset($itemHours['opening_hours_status_id']) && $itemHours['opening_hours_status_id'] == 'on') {
                        $itemDay['opening_hours_status_id'] = STATUS_ACTIVED;
                    } else {
                        $itemDay['opening_hours_status_id'] = 1;
                    }

                    if (!empty($itemHours['start_time'])) {
                        $itemDay['start_time'] = $itemHours['start_time'];
                    } else {
                        $itemDay['start_time'] = "00:00";
                    }

                    if (!empty($itemHours['end_time'])) {
                        $itemDay['end_time'] = $itemHours['end_time'];
                    } else {
                        $itemDay['end_time'] = "23:59";
                    }
                } else {
                    $itemDay = array();
                    $itemDay['day_id'] = $day_id;
                    $itemDay['opening_hours_status_id'] = 1;
                    $itemDay['start_time'] = "00:00";
                    $itemDay['end_time'] = "00:00";
                }

                $openingHours[] = $itemDay;
            }
            //echo "<pre>";print_r($openingHours);die;

            $service_type_ids = $this->input->post('service_type_ids');
            $businessServiceTypes = array();
            if (!empty($service_type_ids)) {
                $businessServiceTypes  = $service_type_ids;
            }

            $businessProfileId = $this->Mbusinessprofiles->save($postData, $busId);
            if ($businessProfileId > 0) {

                $dataUpdate = array();
                $businessAvatarUpload = $this->input->post('business_avatar_upload');
                if (!empty($businessAvatarUpload)) {
                    $avatarUpload = $this->uploadImageBase64($businessAvatarUpload, 7);
                    $dataUpdate['business_avatar'] = replaceFileUrl($avatarUpload, BUSINESS_PROFILE_PATH);
                }
                $businessCoverUpload = $this->input->post('business_cover_upload');
                if (!empty($businessCoverUpload)) {
                    $coverUpload = $this->uploadImageBase64($businessCoverUpload, 7);
                    $dataUpdate['business_image_cover'] = replaceFileUrl($coverUpload, BUSINESS_PROFILE_PATH);
                }
                if (!empty($dataUpdate)) {
                    $businessProfileId = $this->Mbusinessprofiles->update($dataUpdate, $businessProfileId);
                }

                //open hours
                if (!empty($openingHours)) {
                    $resultOpenHours = $this->Mopeninghours->saveOpenHours($openingHours, $businessProfileId, true);
                }

                //service types
                if (!empty($businessServiceTypes)) {
                    $resultServiceTypes = $this->Mbusinessservicetype->saveServiceType($businessServiceTypes, $businessProfileId, true);
                }

                $this->session->set_flashdata('notice_message', "Update your business profile successfully");
                $this->session->set_flashdata('notice_type', 'success');
                redirect(base_url('business-management/' . $getBusinessUrl . '/about-us'));
            } else {
                $this->session->set_flashdata('notice_message', "Update business profile failed");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('business-management/' . $getBusinessUrl . '/about-us'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('my-business-profile'));
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
        $data = $this->commonDataCustomer("My Profile - " . $businessInfo['business_name']);
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




        $service_type_name = "service_type_name_" . $this->Mconstants->languageShortCodes[$data['language_id']];
        $data['businessServiceTypes'] = $this->Mservicetypes->getListByBusiness($businessProfileId, $service_type_name);



        $businessOpeningHours = $this->Mopeninghours->getBy(array('business_profile_id' => $businessProfileId));
        $data['businessOpeningHours'] = array();
        foreach ($businessOpeningHours as $itemHours) {
            $data['businessOpeningHours'][$itemHours['day_id']]['day_id'] = $itemHours['day_id'];
            $data['businessOpeningHours'][$itemHours['day_id']]['start_time'] = $itemHours['start_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['end_time'] = $itemHours['end_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['opening_hours_status_id'] = $itemHours['opening_hours_status_id'];
        }
        if (!empty($data['businessOpeningHours'])) ksort($data['businessOpeningHours']);

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
        $data = $this->commonDataCustomer("My Profile - " . $businessInfo['business_name']);
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
        foreach ($businessOpeningHours as $itemHours) {
            $data['businessOpeningHours'][$itemHours['day_id']]['day_id'] = $itemHours['day_id'];
            $data['businessOpeningHours'][$itemHours['day_id']]['start_time'] = $itemHours['start_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['end_time'] = $itemHours['end_time'];
            $data['businessOpeningHours'][$itemHours['day_id']]['opening_hours_status_id'] = $itemHours['opening_hours_status_id'];
        }
        if (!empty($data['businessOpeningHours'])) ksort($data['businessOpeningHours']);

        $data['listServices'] = $this->Mservices->getHighlightListByLang($data['language_id']);

        $service_type_name = "service_type_name_" . $this->Mconstants->languageShortCodes[$data['language_id']];
        $data['businessServiceTypes'] = $this->Mservicetypes->getListByServices(array('service_id' => $businessInfo['service_id']), $service_type_name);

        $selectedServiceTypes = $this->Mservicetypes->getSelectedByListBusinessId($businessInfo['id'], $service_type_name);
        $data['selectedTypes'] = array();
        foreach ($selectedServiceTypes  as $selectItemService) {
            $data['selectedTypes'][] = $selectItemService['id'];
        }

        $data['phoneCodes'] = $this->Mphonecodes->get();
        $data['phoneCodeInfo'] = array();
        if ($businessInfo['country_code_id'] > 0) {
            $data['phoneCodeInfo'] = $this->Mphonecodes->get($businessInfo['country_code_id']);
        }

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
            "Gallery - " . $businessInfo['business_name'],
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

    public function updateGallery($slug = "")
    {
        //echo "<pre>".print_r($_POST);die;

        $this->loadModel(array('Mbusinessphotos', 'Mbusinessprofiles'));

        $businessURL = trim($slug);

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            echo json_encode(array('code' => 0, 'message' => "Business profile not exist"));
            die;
        }
        //$businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        $images = $this->input->post('images');
        $uploadedImage = [];
        if (!empty($images)) {
            $images = json_decode($images);
            foreach ($images as $itemImg) {
                if (!empty($itemImg)) {
                    $imageUpload = $this->uploadImageBase64($itemImg, 7);
                    $uploadedImage[] = replaceFileUrl($imageUpload, BUSINESS_PROFILE_PATH);
                }
            }
            if (!empty($uploadedImage)) {
                $resultUpload = $this->Mbusinessphotos->savePhotos($uploadedImage, $businessProfileId);
                if ($resultUpload) {
                    echo json_encode(array('code' => 1, 'message' => "Upload success"));
                    die;
                }
            }
        }
        echo json_encode(array('code' => 0, 'message' => "Upload failed"));
        die;
    }

    public function updateVideo($slug = "")
    {
        //echo "<pre>".print_r($_POST);die;

        $this->loadModel(array('Mbusinessvideos', 'Mbusinessprofiles'));

        $businessURL = trim($slug);

        $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('business_url' => $businessURL, 'business_status_id' => STATUS_ACTIVED), 'id', 0);
        if ($businessProfileId == 0) {
            echo json_encode(array('code' => 0, 'message' => "Business profile not exist"));
            die;
        }
        //$businessInfo = $this->Mbusinessprofiles->get($businessProfileId);

        $videos = $this->input->post('videos');
        $uploadedVideo = [];
        if (!empty($videos)) {
            $videos = json_decode($videos);

            if (!empty($videos)) {
                $resultUpload = $this->Mbusinessvideos->saveVideos($videos, $businessProfileId);
                if ($resultUpload) {
                    echo json_encode(array('code' => 1, 'message' => "Upload success"));
                    die;
                }
            }
        }
        echo json_encode(array('code' => 0, 'message' => "Upload failed"));
        die;
    }

    public function deleteVideo($slug = "")
    {
        $this->loadModel(array('Mbusinessvideos'));
        $video_id = $this->input->post('video_id');
        if ($video_id > 0) {
            $resultDel = $this->Mbusinessvideos->delete($video_id);
            if ($resultDel) {
                echo json_encode(array('code' => 1, 'message' => "Successfully deleted video"));
                die;
            }
        }
        echo json_encode(array('code' => 0, 'message' => "Delete failed"));
        die;
    }

    public function deleteImage($slug = "")
    {
        $this->loadModel(array('Mbusinessphotos'));
        $image_id = $this->input->post('image_id');
        if ($image_id > 0) {
            $resultDel = $this->Mbusinessphotos->delete($image_id);
            if ($resultDel) {
                echo json_encode(array('code' => 1, 'message' => "Successfully deleted video"));
                die;
            }
        }
        echo json_encode(array('code' => 0, 'message' => "Delete failed"));
        die;
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
        $data = $this->commonDataCustomer("Coupons - " . $businessInfo['business_name']);
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
        $data = $this->commonDataCustomer("Create Coupon - " . $businessInfo['business_name']);
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
        $data = $this->commonDataCustomer("Events - " . $businessInfo['business_name']);
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
        $data = $this->commonDataCustomer("Create Event - " . $businessInfo['business_name']);
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

        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mbusinessprofiles', 'Mcustomerreviews', 'Mcustomers'));

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

        $data['activeBusinessMenu'] = "reviews";

        $data['businessInfo'] = $businessInfo;


        $per_page = $this->input->get('per_page');
        $data['per_page'] = $per_page;
        $order_by = $this->input->get('order_by');
        $data['order_by'] =  $order_by;
        $review_star = $this->input->get('review_star');
        $data['review_star'] =  $review_star;

        $getData = array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'order_by' => $order_by,
            'review_star' => $review_star
        );
        $rowCount = $this->Mcustomerreviews->getCount($getData);
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
        $data['basePagingUrl'] = base_url('business/' . $businessInfo['business_url'] . '/reviews');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mcustomerreviews->search($getData, $perPage, $page);
        for ($i = 0; $i < count($data['lists']); $i++) {
            $customerInfo = $this->Mcustomers->getBy(array('id' => $data['lists'][$i]['customer_id'], 'customer_status_id' => STATUS_ACTIVED), false, 'created_at', 'customer_first_name, customer_last_name, customer_avatar', 0, 0, 'asc');
            $data['lists'][$i]['customerInfo'] = $customerInfo[0];
        }

        $data['count_one_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 1
        ));

        $data['count_two_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 2
        ));

        $data['count_three_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 3
        ));

        $data['count_four_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 4
        ));

        $data['count_five_star'] = $this->Mcustomerreviews->getCount(array(
            'customer_review_status_id' => STATUS_ACTIVED,
            'business_id' => $businessProfileId,
            'review_star' => 5
        ));

        $sumReview = ($data['count_one_star'] + $data['count_two_star'] + $data['count_three_star'] + $data['count_four_star'] + $data['count_five_star']);
        $data['overall_rating'] = 0;
        if ($sumReview > 0) {
            $data['overall_rating'] = ($data['count_one_star'] * 1 + $data['count_two_star'] * 2 + $data['count_three_star'] * 3 + $data['count_four_star'] * 4 + $data['count_five_star'] * 5) / ($data['count_one_star'] + $data['count_two_star'] + $data['count_three_star'] + $data['count_four_star'] + $data['count_five_star']);
        }


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
        $data = $this->commonDataCustomer("Reservations - " . $businessInfo['business_name']);
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
        $data = $this->commonDataCustomer("Subscriptions - " . $businessInfo['business_name']);
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
