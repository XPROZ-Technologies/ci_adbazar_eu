<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        //$this->lang->load('login', $this->language);


    }

    public function index() {
        $this->loadModel(array('Mconfigs', 'Mservices', 'Mevents', 'Mbusinessprofiles','Mcustomerevents'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Notifications');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */
        
        $this->load->view('frontend/notification/customer-notification', $data);
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