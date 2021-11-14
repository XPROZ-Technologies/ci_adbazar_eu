<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller { 

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
            $this->loadModel(array('Mevents', 'Mconfigs'));
            $configs = $this->Mconfigs->getListMap(1, $this->languageId);
            $events = $this->Mevents->getListHome($postData);
            for($i = 0; $i < count($events); $i++){
                $events[$i]['event_image'] = !empty($events[$i]['event_image']) ? base_url(EVENTS_PATH.$events[$i]['event_image']) : '';
            }
            $this->success200(array(
                'event_text' => $configs['EVENT_MOBILE_TEXT'],
                'event_image' => !empty($configs['EVENT_MOBILE_IMAGE']) ? base_url(CONFIG_PATH.$configs['EVENT_MOBILE_IMAGE']) : '',
                'list' => $events
            ));
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
            
            $this->loadModel(array('Mevents', 'Mconfigs'));
            $configs = $this->Mconfigs->getListMap(1, $this->languageId);
            $rowCount = $this->Mevents->getCountInApi($postData);
            $events = [];
            $perPage = intval($postData['per_page']) < 1 ? DEFAULT_LIMIT :$postData['per_page'];
            $pageCount = 0;
            if($rowCount > 0){
                $pageCount = ceil($rowCount / $perPage);
                $page = $postData['page_id'];
                if(!is_numeric($page) || $page < 1) $page = 1;
                $events = $this->Mevents->getListInApi($postData, $perPage, $page);
                for($i = 0; $i < count($events); $i++){
                    $events[$i]['event_image'] = !empty($events[$i]['event_image']) ? base_url(EVENTS_PATH.$events[$i]['event_image']) : '';
                }
            }
            $this->success200(array(
                'page_id' => $page,
                'per_page' => $perPage,
                'page_count' => $pageCount,
                'totals' => $rowCount,
                'event_text' => $configs['EVENT_MOBILE_TEXT'],
                'event_image' => !empty($configs['EVENT_MOBILE_IMAGE']) ? base_url(CONFIG_PATH.$configs['EVENT_MOBILE_IMAGE']) : '',
                'list' => $events
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

}