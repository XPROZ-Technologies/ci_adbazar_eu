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
                    if($openStatusId) $openStatusId = 2;
                    else $openStatusId = 1;
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
            $this->load->model(array('Mbusinessprofiles', 'Mservicetypes', 'Mopeninghours'));
            $detail = $this->Mbusinessprofiles->getDetailInApi($postData['business_id']);
            if($detail && count($detail) > 0) {
                $detail = $detail[0];
                $serviceTypes = $this->Mservicetypes->getServiceTypeInService($detail['service_id'], $this->langCode);
                $openingHours = $this->Mopeninghours->getBy(array('business_profile_id' => $detail['id']), false, 'day_id', 'opening_hours_status_id as open_status_id, day_id, start_time, end_time', 0,0, 'asc');
                $openStatusId = $this->checkBusinessOpenHours($detail['id']);
                if($openStatusId) $openStatusId = 2;
                else $openStatusId = 1;
                $data = array(
                    'business_info' => array(
                        "id" => $detail['id'],
                        "business_name" => $detail['business_name'],
                        "service_types" => $serviceTypes,
                        "business_slogan" => $detail['business_slogan'],
                        "business_phone" => $detail['business_phone'],
                        "business_whatsapp" => $detail['business_whatsapp'],
                        "business_email" => $detail['business_email'],
                        "business_address" => $detail['business_address'],
                        "business_avatar" => !empty($detail['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$detail['business_avatar']) : '',
                        "business_image_cover" => !empty($detail['business_image_cover']) ? base_url(BUSINESS_PROFILE_PATH.$detail['business_image_cover']) : '',
                        "business_description" => $detail['business_description'],
                        "open_status_id" => $openStatusId,
                        "has_location" => $detail['has_location'],
                        "lat" => $detail['lat'],
                        "lng" => $detail['lng'],
                        "star" => $detail['star'],
                        "number_of_reviews" => $detail['number_of_reviews']
                    ),
                    'open_hours' => $openingHours
                );
                $this->success200($data);
            } else {
                $this->error204($this->lang->line('incorrect-information1635566199'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function photos() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('business_id', 'page_id', 'per_page'));
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                $postData['api'] = true;
                $this->load->model('Mbusinessphotos');
                $rowCount = $this->Mbusinessphotos->getCountInApi($postData);
                $perPage = intval($postData['per_page']) < 1 ? DEFAULT_LIMIT :$postData['per_page'];
                $pageCount = 0;
                $page = $postData['page_id'];
                $businessPhotos = [];

                if($rowCount > 0) {
                    $pageCount = ceil($rowCount / $perPage);
                    if(!is_numeric($page) || $page < 1) $page = 1;
                    $businessPhotos = $this->Mbusinessphotos->getListInApi($postData, $perPage, $page);
                    $photos = [];
                    for($i = 0; $i < count($businessPhotos); $i++) {
                        $photos[] = !empty($businessPhotos[$i]['photo_image']) ? base_url(BUSINESS_PROFILE_PATH.$businessPhotos[$i]['photo_image']) : '';
                    }
                }
                $this->success200(array(
                    'page_id' => $page,
                    'per_page' => $perPage,
                    'page_count' => $pageCount,
                    'totals' => $rowCount,
                    'list' => $photos
                ));
            } else {
                $this->error204('business_id does not exist');
                die;
            }
            
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function videos() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('business_id', 'page_id', 'per_page'));
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                $postData['api'] = true;
                $this->load->model('Mbusinessvideos');
                $rowCount = $this->Mbusinessvideos->getCountInApi($postData);
                $perPage = intval($postData['per_page']) < 1 ? DEFAULT_LIMIT :$postData['per_page'];
                $pageCount = 0;
                $page = $postData['page_id'];
                $businessVideos = [];

                if($rowCount > 0) {
                    $pageCount = ceil($rowCount / $perPage);
                    if(!is_numeric($page) || $page < 1) $page = 1;
                    $businessVideos = $this->Mbusinessvideos->getListInApi($postData, $perPage, $page);
                    $videos = [];
                    for($i = 0; $i < count($businessVideos); $i++) {
                        $videos[] = !empty($businessVideos[$i]['video_url']) ? base_url(BUSINESS_PROFILE_PATH.$businessVideos[$i]['video_url']) : '';
                    }
                }
                $this->success200(array(
                    'page_id' => $page,
                    'per_page' => $perPage,
                    'page_count' => $pageCount,
                    'totals' => $rowCount,
                    'list' => $videos
                ));
            } else {
                $this->error204('business_id does not exist');
                die;
            }
            
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}