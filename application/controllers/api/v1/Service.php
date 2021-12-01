<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language-id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
        $this->langCode = '_vi';
        if ($this->languageId == 1) $this->langCode = '_en';
        elseif ($this->languageId == 2) $this->langCode = '_cz';
        elseif ($this->languageId == 3) $this->langCode = '_de';
    }

    public function list_home() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $this->load->model('Mservices');
            $services = $this->Mservices->getListHome($customer['customer_id'], $this->langCode);
            for($i = 0; $i < count($services); $i++) {
                $services[$i]['service_image'] = !empty($services[$i]['service_image']) ? base_url(SERVICE_PATH.$services[$i]['service_image']) : '';
            }
            $this->success200(array('list' => $services));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function list() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $this->load->model('Mservices');
            $services = $this->Mservices->getListInApi($customer['customer_id'], $this->langCode);
            for($i = 0; $i < count($services); $i++) {
                $services[$i]['service_image'] = !empty($services[$i]['service_image']) ? base_url(SERVICE_PATH.$services[$i]['service_image']) : '';
            }
            $this->success200(array('list' => $services));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}