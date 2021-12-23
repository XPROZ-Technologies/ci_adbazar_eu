<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends MY_Controller { 

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

    public function list() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('search_text', 'service_id'));
            $postData['api'] = true;
            $this->load->model(array('Mbusinessprofilelocations'));
            $locations = $this->Mbusinessprofilelocations->getBusinessprofileLocations($postData);
            $arrLocation = [];
            for($i = 0; $i < count($locations); $i++){
                $location = $locations[$i];
                $openStatusId = $this->checkBusinessOpenHours($location['business_profile_id']);
                if($openStatusId) $openStatusId = 2;
                else $openStatusId = 1;
                $arrLocation[] = array(
                    'id' => $location['id'],
                    'lat' => $location['lat'],
                    'lng' => $location['lng'],
                    'business_info' => array(
                        'id' => $location['business_profile_id'],
                        'business_name' => $location['business_name'],
                        'business_phone' => $location['business_phone'],
                        'business_slogan' => $location['business_slogan'],
                        'business_avatar' => !empty($location['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$location['business_avatar']): '',
                        'open_status_id' => $openStatusId
                    )
                );
            }
            $this->success200(array('list' => $arrLocation));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}