<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language_id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
        $this->langCode = '_vi';
        if ($this->languageId == 1) $this->langCode = '_en';
        elseif ($this->languageId == 2) $this->langCode = '_cz';
        elseif ($this->languageId == 3) $this->langCode = '_de';
    }

    public function list_home() {
        try {
            $this->openAllCors();
            $this->load->model('Mservices');
            $services = $this->Mservices->getBy(array('service_status_id' => STATUS_ACTIVED), false, "display_order", "id, service_name".$this->langCode." as service_name, service_image", 0, 0, 'ASC');
            for($i = 0; $i < count($services); $i++) {
                $services[$i]['service_image'] = !empty($services[$i]['service_image']) ? base_url(SERVICE_PATH.$services[$i]['service_image']) : '';
            }
            $this->success200(array('list' => $services));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}