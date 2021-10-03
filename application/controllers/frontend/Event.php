<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('login', $this->language);


    }

    public function index() {
        $this->loadModel(array('Mconfigs', 'Mservices', 'Mevents', 'Mbusinessprofiles','Mcustomerevents'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Events');
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
            'start_date' => date('Y-m-d'), 
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

        $this->load->view('frontend/event/customer-event', $data);
    }

    public function detail($slug = '', $id = 0) {
        if(empty($id)){
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                redirect('events.html');
            }
        }

        $this->loadModel(array('Mconfigs', 'Mservices', 'Mbusinessprofiles', 'Mevents', 'Mcustomerevents'));

        $eventId = $this->Mevents->getFieldValue(array('id' => $id, 'event_status_id' => STATUS_ACTIVED), 'id', 0);

        if($eventId == 0){
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                redirect('events.html');
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
    
}