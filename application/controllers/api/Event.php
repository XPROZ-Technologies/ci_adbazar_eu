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
            $this->loadModel(array('Mevents', 'Mconfigs'));
            $configs = $this->Mconfigs->getListMap(1, $this->languageId);
            $events = $this->Mevents->getListHome();
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

}