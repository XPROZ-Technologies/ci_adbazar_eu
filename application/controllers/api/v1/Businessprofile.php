<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Businessprofile extends MY_Controller { 

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

    public function list() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('search_text', 'page_id', 'per_page', 'service_id', 'service_type_id'));
            if(empty($postData['service_type_id'])) $postData['service_type_id'] = [];
            $postData['api'] = true;
            $this->load->model(array('Mbusinessprofiles','Mservices'));
            $rowCount = $this->Mbusinessprofiles->getCountInApi($postData);
            $perPage = intval($postData['per_page']) < 1 ? DEFAULT_LIMIT :$postData['per_page'];
            $pageCount = 0;
            $page = $postData['page_id'];
            $businessProfiles = [];

            if($rowCount > 0) {
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $businessProfiles = $this->Mbusinessprofiles->getListInApi($postData, $perPage, $page);
                $serviceTypes = [];
                for($i = 0; $i < count($businessProfiles); $i++) {
                    $openStatusId = $this->checkBusinessOpenHours($businessProfiles[$i]['id']);
                    if($openStatusId) $openStatusId = 1;
                    else $openStatusId = 0;
                    $businessProfiles[$i]['open_status_id'] = $openStatusId;
                    $businessProfiles[$i]['business_avatar'] = !empty($businessProfiles[$i]['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$businessProfiles[$i]['business_avatar']) : '';
                    $serviceTypes = $this->Mservices->getServiceTypeInService($businessProfiles[$i]['id'], $postData['service_id'], $postData['service_type_id'], $this->langCode);
                    $businessProfiles[$i]['service_types'] = '';
                    if($serviceTypes) {
                        $businessProfiles[$i]['service_types'] = $serviceTypes['serviceTypeNames'];
                    }
                }
            }
            $this->success200(array(
                'service_name' => !empty($serviceTypes) && count($serviceTypes) > 0 ? $serviceTypes['serviceName']: '',
                'service_types' => !empty($serviceTypes) && count($serviceTypes) > 0 ? $serviceTypes['serviceType']: [],
                'page_id' => $page,
                'per_page' => $perPage,
                'page_count' => $pageCount,
                'totals' => $rowCount,
                'list' => $businessProfiles
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function detail() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('business_id'));
            if(empty($postData['business_id']) && $postData['business_id'] < 0) {
                $this->error204($this->lang->line('incorrect-information1635566199'));
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mservices'));
            $detail = $this->Mbusinessprofiles->get($postData['business_id'], false, '', 'id, service_id, business_name, business_slogan, business_email, business_address, business_whatsapp, business_url, country_code_id, business_phone, business_description, business_avatar, business_status_id');
            if($detail && $detail['business_status_id'] == STATUS_ACTIVED) {
                $detail['business_avatar'] = !empty($detail['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$detail['business_avatar']) : '';
                $serviceName = $this->Mservices->getFieldValue(array('id' => $detail['service_id']), 'service_name'.$this->langCode.'', '');
                $detail['service_name'] = $serviceName;
                $this->success200(array('list' => $detail));
            } else {
                $this->error204($this->lang->line('incorrect-information1635566199'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}