<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('customer', $this->language);
        $this->lang->load('business_profile', $this->language);

    }

    public function index() {
        $this->loadModel(array('Mconfigs', 'Mservices', 'Mevents', 'Mbusinessprofiles','Mcustomerevents'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($this->lang->line('events'));
        $data['activeMenu'] = "events";
        /**
         * Commons data
         */
        
        $data['activeMenuService'] = 0;

        //$data['services'] = $this->Mservices->getHighlightListByLang($data['language_id']);
        $selected_date = $this->input->get('selected_date');
        
        $per_page = $this->input->get('per_page');
        $data['per_page'] = $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] = $search_text;
        $joinedEvents = $this->Mcustomerevents->getListFieldValue(array('customer_id' => $data['customer']['id'], 'customer_event_status_id >' => 0), 'event_id');
        
        //current day default
        if(empty($selected_date)) $selected_date = date('Y-m-d');

        $getData = array(
            'event_status_id' => STATUS_ACTIVED, 
            'search_text_fe' => $search_text, 
            'selected_date' => $selected_date,
            'joined_events' => $joinedEvents
        );
        $rowCount = $this->Mevents->getCount($getData);
        $data['lists'] = array();
        
        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_BUSINESS_PROFILE;
        //$perPage = 2;
        if(is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if(!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('events.html');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'].'?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mevents->search($getData, $perPage, $page);
        for($i = 0; $i < count($data['lists']); $i++){
            $data['lists'][$i]['business_name'] = $this->Mbusinessprofiles->getFieldValue(array('id' => $data['lists'][$i]['business_profile_id'], 'business_status_id' => STATUS_ACTIVED), 'business_name', '');
            $data['lists'][$i]['event_image'] = (!empty($data['lists'][$i]['event_image'])) ? EVENTS_PATH.$data['lists'][$i]['event_image'] : EVENTS_PATH.NO_IMAGE ;
        }

        $getDataEvent = array('event_status_id' => STATUS_ACTIVED, 'start_date' => date('Y-m-d'));
        $data['listEvents'] = $this->Mevents->search($getDataEvent);
        
        
        $dateRanges = array();
        foreach($data['listEvents'] as $eventItem){
            if(empty($dateRanges)){
                $dateRanges = getDatesFromRange($eventItem['start_date'], $eventItem['end_date']);
            }else{
                $dateRanges = array_merge($dateRanges, getDatesFromRange($eventItem['start_date'], $eventItem['end_date']));
            }
        }   
        if(!empty($dateRanges)){
            $dateRanges = array_unique($dateRanges);
        }
        $data['dateRanges'] = $dateRanges;
        

        $this->load->view('frontend/event/customer-event', $data);
    }

    public function detail($slug = '', $id = 0) {
        if(empty($id)){
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                redirect(base_url('events.html'));
            }
        }

        $this->loadModel(array('Mconfigs', 'Mservices', 'Mbusinessprofiles', 'Mevents', 'Mcustomerevents'));

        $eventId = $this->Mevents->getFieldValue(array('id' => $id, 'event_status_id' => STATUS_ACTIVED), 'id', 0);

        if($eventId == 0){
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                redirect(base_url('events.html'));
            }
        }

        $detailInfo = $this->Mevents->get($eventId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($detailInfo['event_subject']);
        $data['activeMenu'] = "events";
        /**
         * Commons data
         */

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != current_url()) {
            $data['backUrl'] = $_SERVER['HTTP_REFERER'];
        }else{
            $data['backUrl'] = base_url('coupons.html');
        }

        $data['activeMenuService'] = 0;

        $data['detailInfo'] = $detailInfo;

        $data['detailInfo']['event_image'] = (!empty($data['detailInfo']['event_image'])) ? EVENTS_PATH.$data['detailInfo']['event_image'] : EVENTS_PATH.NO_IMAGE ;

        $data['detailInfo']['event_join'] = $this->Mcustomerevents->getCount(array('event_id' => $eventId, 'customer_event_status_id > ' => 0));

        $data['businessInfo'] = $this->Mbusinessprofiles->get($data['detailInfo']['business_profile_id']);


        $customerEventId = $this->Mcustomerevents->getFieldValue(array('customer_id' => $data['customer']['id'], 'event_id' => $eventId, 'customer_event_status_id' => STATUS_ACTIVED), 'id', 0);
        
        $data['customerEvent'] = array();
        if($customerEventId > 0){
            $data['customerEvent'] = $this->Mcustomerevents->get($customerEventId);
        }

        $this->load->view('frontend/event/bp-event-detail', $data);
    }

    public function event_login() {

        $this->loadModel(array('Mconfigs'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Login to join event',
			array('scriptFooter' => array('js' => 'js/frontend/login/login.js'))
        );
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $redirectUrl = $this->input->get('redirectUrl');
        $data['redirectOldUrl'] = $redirectUrl;

        $this->load->view('frontend/event/bp-event-account', $data);
    }
    

    public function update(){
        try {
            $postData = $this->arrayFromPost(array('business_profile_id', 'event_subject', 'event_image', 'start_date', 'end_date', 'start_time', 'end_time','event_description'));
            if(!empty($postData['event_subject'])  && !empty($postData['start_date'])) {
                $eventId = $this->input->post('id');
				$this->load->model('Mevents');

                
                
                $postData['start_time'] = $postData['start_time'];
                $postData['end_time'] = $postData['end_time'];

                $postData['start_date'] = date("Y-m-d", strtotime($postData['start_date']));
                $postData['end_date'] = date("Y-m-d", strtotime($postData['end_date']));

                /**
                 * Upload if customer choose image
                 */
                $eventImageUpload = $this->input->post('event_image_upload');
                if(!empty($eventImageUpload)){
                    $imageUpload = $this->uploadImageBase64($eventImageUpload, 9);
                    $postData['event_image'] = replaceFileUrl($imageUpload, EVENTS_PATH);
                }

                $message = 'Create success';
                if ($eventId == 0){
                    $postData['event_status_id'] = STATUS_ACTIVED;
                    $postData['created_by'] = 0;
                    $postData['created_at'] = getCurentDateTime();
                }
                else {
                    $message = 'Update successful';
                    $postData['updated_by'] = 0;
                    $postData['updated_at'] = getCurentDateTime();
                }
                
                $eventId = $this->Mevents->save($postData, $eventId);
                if ($eventId > 0) {
                    echo json_encode(array('code' => 1, 'message' => $message, 'data' => $eventId));
                }
                else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
            }
            else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
     	}
    }
}