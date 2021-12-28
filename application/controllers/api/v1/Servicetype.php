<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicetype extends MY_Controller { 

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

    // public function list() {
    //     try {
    //         $this->openAllCors();
    //         $customer = $this->apiCheckLogin(false);
    //         $postData = $this->arrayFromPostRawJson(array('business_id'));
    //         if(!isset($postData['business_id'])) {
    //             $this->error204('business_id: not transmitted');
    //             die;
    //         }
    //         $this->load->model(array('Mcustomerreservations'));

    //         $listServiceType = $this->Mcustomerreservations->getListServiceType($customer['customer_id'], $postData['business_id'], $this->langCode);
    //         $this->success200(array(
    //             "list"=> $listServiceType
    //         ));
    //     } catch (\Throwable $th) {
    //         $this->error500();
    //     }
    // }

    public function list() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $this->load->model(array('Mcustomerreservations'));

            $listServiceType = $this->Mcustomerreservations->getListServiceType($customer['customer_id'], $this->langCode);
            $this->success200(array(
                "list"=> $listServiceType
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}