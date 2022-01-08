<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Businessprofile extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
    }

    public function list() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('search_text', 'page_id', 'per_page', 'service_id', 'service_type_id'));
            if(empty($postData['service_type_id'])) $postData['service_type_id'] = [];
            if(empty($postData['service_id'])) $postData['service_ids'] = [];
            else $postData['service_ids'] = $postData['service_id'];
            unset($postData['service_id']);
            $postData['api'] = true;
            $this->load->model(array('Mbusinessprofiles','Mservices'));
            $postData['business_status_id'] = STATUS_ACTIVED;
            $rowCount = $this->Mbusinessprofiles->getCountInApi($postData);
            $pageCount = 0;
            $businessProfiles = [];

            $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
            $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;

            if($rowCount > 0) {
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $businessProfiles = $this->Mbusinessprofiles->getListInApi($postData, $perPage, $page);
                $serviceTypes = [];
                $businessIds = [];
                for($i = 0; $i < count($businessProfiles); $i++) {
                    $businessIds[] = $businessProfiles[$i]['id'];
                    $openStatusId = $this->checkBusinessOpenHours($businessProfiles[$i]['id']);
                    if($openStatusId) $openStatusId = 2;
                    else $openStatusId = 1;
                    $businessProfiles[$i]['star'] = !empty($businessProfiles[$i]['star']) ? $businessProfiles[$i]['star'] : '0';
                    $businessProfiles[$i]['open_status_id'] = $openStatusId;
                    $businessProfiles[$i]['business_avatar'] = !empty($businessProfiles[$i]['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$businessProfiles[$i]['business_avatar']) : '';
                    $serviceTypes = $this->Mservices->getServiceTypeInService($businessProfiles[$i]['id'], $this->langCode);
                    $businessProfiles[$i]['service_types'] = '';
                    if($serviceTypes) {
                        $businessProfiles[$i]['service_types'] = $serviceTypes['serviceTypeNames'];
                    }
                }
                
            }
            $serviceTypesAll = $this->Mservices->getServiceTypeInServiceAll($postData['service_ids'], $postData['service_type_id'], $this->langCode);
            $this->success200(array(
                'service_name' => !empty($serviceTypesAll) && count($serviceTypesAll) > 0 ? $serviceTypesAll['serviceName']: '',
                'service_types' => !empty($serviceTypesAll) && count($serviceTypesAll) > 0 ? $serviceTypesAll['serviceType']: [],
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
                $this->error204($this->lang->line('incorrect_information'));
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mservicetypes', 'Mopeninghours', 'Mphonecodes'));
            $detail = $this->Mbusinessprofiles->getDetailInApi($postData['business_id']);
            if($detail && count($detail) > 0) {
                $detail = $detail[0];
                $serviceTypes = $this->Mservicetypes->getServiceTypeInService($detail['service_id'], $this->langCode);
                $openingHours = $this->Mopeninghours->getBy(array('business_profile_id' => $detail['id']), false, 'day_id', 'opening_hours_status_id as open_status_id, day_id, start_time, end_time', 0,0, 'asc');
                $openStatusId = $this->checkBusinessOpenHours($detail['id']);
                if($openStatusId) $openStatusId = 2; // mở cửa
                else $openStatusId = 1; // dóng cửa
                $businessPhoneCode = $this->Mphonecodes->getFieldValue(array('id' => $detail['country_code_id']), 'phonecode','');
                $whatsappPhoneCode = $this->Mphonecodes->getFieldValue(array('id' => $detail['country_code_whatsapp_id']), 'phonecode','');
                $data = array(
                    'business_info' => array(
                        "id" => $detail['id'],
                        "business_name" => $detail['business_name'],
                        "service_types" => $serviceTypes,
                        "business_slogan" => $detail['business_slogan'],
                        "business_phone" => $businessPhoneCode.ltrim($detail['business_phone'], '0'),
                        "business_whatsapp" => $whatsappPhoneCode.ltrim($detail['business_whatsapp'], '0'),
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
                        "number_of_reviews" => $detail['number_of_reviews'],
                        'is_annual_payment' => $detail['is_annual_payment'],
                        'business_status_id' => $detail['business_status_id']
                    ),
                    'open_hours' => $openingHours
                );
                $this->success200($data);
            } else {
                $this->error204($this->lang->line('incorrect_information'));
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
                $this->load->model(array('Mbusinessphotos', 'Mbusinessprofiles'));
                $rowCount = $this->Mbusinessphotos->getCountInApi($postData);
                $pageCount = 0;
                $businessPhotos = [];

                $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
                $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;

                if($rowCount > 0) {
                    $pageCount = ceil($rowCount / $perPage);
                    if(!is_numeric($page) || $page < 1) $page = 1;
                    $businessPhotos = $this->Mbusinessphotos->getListInApi($postData, $perPage, $page);
                    $photos = [];
                    for($i = 0; $i < count($businessPhotos); $i++) {
                        $photos[] = !empty($businessPhotos[$i]['photo_image']) ? base_url(BUSINESS_PROFILE_PATH.$businessPhotos[$i]['photo_image']) : '';
                    }
                }
                $business = $this->Mbusinessprofiles->get($postData['business_id']);
                $businessInfo = '';
                if($business) {
                    $businessInfo = array(
                        'id' => $business['id'],
                        'business_name' => $business['business_name'],
                        'business_slogan' => $business['business_slogan'],
                        'business_avatar' => !empty($business['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$business['business_avatar']): '',
                        'business_image_cover' => !empty($business['business_image_cover']) ? base_url(BUSINESS_PROFILE_PATH.$business['business_avatar']) :''
                    );
                }
                
                $this->success200(array(
                    'page_id' => $page,
                    'per_page' => $perPage,
                    'page_count' => $pageCount,
                    'totals' => $rowCount,
                    'business_info' => $businessInfo,
                    'list' => $photos
                ));
            } else {
                $this->error204($this->lang->line('business_id_does_not_exist'));
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
                $this->load->model(array('Mbusinessvideos', 'Mbusinessprofiles'));
                $rowCount = $this->Mbusinessvideos->getCountInApi($postData);
                $pageCount = 0;
                $businessVideos = [];

                $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
                $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;

                if($rowCount > 0) {
                    $pageCount = ceil($rowCount / $perPage);
                    if(!is_numeric($page) || $page < 1) $page = 1;
                    $businessVideos = $this->Mbusinessvideos->getListInApi($postData, $perPage, $page);
                    $videos = [];
                    for($i = 0; $i < count($businessVideos); $i++) {
                        $videos[] = $businessVideos[$i]['video_url'];
                    }
                }
                $business = $this->Mbusinessprofiles->get($postData['business_id']);
                $businessInfo = '';
                if($business) {
                    $businessInfo = array(
                        'id' => $business['id'],
                        'business_name' => $business['business_name'],
                        'business_slogan' => $business['business_slogan'],
                        'business_avatar' => !empty($business['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$business['business_avatar']): '',
                        'business_image_cover' => !empty($business['business_image_cover']) ? base_url(BUSINESS_PROFILE_PATH.$business['business_avatar']) :''
                    );
                }
                $this->success200(array(
                    'page_id' => $page,
                    'per_page' => $perPage,
                    'page_count' => $pageCount,
                    'totals' => $rowCount,
                    'business_info' => $businessInfo,
                    'list' => $videos
                ));
            } else {
                $this->error204($this->lang->line('business_id_does_not_exist'));
                die;
            }
            
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function reviews() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'page_id', 'per_page', 'has_image', 'review_star', 'order_by'));
            $postData['customer_id'] = $customer['customer_id'];
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                $postData['api'] = true;
                $this->load->model(array('Mcustomerreviews', 'Mcustomers', 'Mbusinessprofiles'));
                $rowCount = $this->Mcustomerreviews->getCountInApi($postData);
                $pageCount = 0;

                $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
                $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;

                $reviews = [];
                $allowReview = 0;
                if(intval($postData['customer_id']) > 0) {
                    $checkCustomerReviewId = $this->Mcustomerreviews->getFieldValue(array('customer_id' => $postData['customer_id'], 'business_id' => $postData['business_id'], 'customer_review_status_id' => 2), 'id', 0);
                    if($checkCustomerReviewId == 0) $allowReview = 1;
                    else $allowReview = 0;
                }
                if($rowCount > 0) {
                    $pageCount = ceil($rowCount / $perPage);
                    if(!is_numeric($page) || $page < 1) $page = 1;
                    $customerReviews = $this->Mcustomerreviews->getListInApi($postData, $perPage, $page);
                  
                    for($i = 0; $i < count($customerReviews); $i++) {
                        $data = $customerReviews[$i];
                        $customer = $this->Mcustomers->get($data['customer_id']);
                        $reviews[] = array(
                            'id' => $data['id'],
                            'review_star' => $data['review_star'],
                            'photo' => !empty($data['photo']) ? base_url(REVIEW_PATH.$data['photo']) : '',
                            'customer_comment' => nl2br(strip_tags($data['customer_comment'])),
                            'customer_name' => isset($customer['customer_last_name']) ? $customer['customer_last_name'] : '',
                            'customer_avatar' => isset($customer['customer_avatar']) && !empty($customer['customer_avatar']) ? base_url(CUSTOMER_PATH.$customer['customer_avatar']) : '',
                            'created_date' => ddMMyyyy($data['created_at'], 'Y/m/d'),
                            "reply" => array(
                                'business_name' => $this->Mbusinessprofiles->getFieldValue(array('id' => $data['business_id']), 'business_name', ''),
                                'business_comment' => nl2br(strip_tags($data['business_comment'])),
                                'created_date' => ddMMyyyy($data['updated_at'], 'Y/m/d')
                            ),
                            'has_image' => intval($data['is_image'])

                        );
                    }
                }
                $businessProfile = $this->Mcustomerreviews->getRatingAndBusinesInfo($postData['business_id']);
                $businessInfo = '';
                $ratingInfo = '';
                if($businessProfile) {
                    $businessInfo = array(
                        'id' => $businessProfile['id'],
                        'business_name' => $businessProfile['business_name'],
                        'business_slogan' => $businessProfile['business_slogan'],
                        'business_avatar' => !empty($businessProfile['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$businessProfile['business_avatar']): '',
                        'business_image_cover' => !empty($businessProfile['business_image_cover']) ? base_url(BUSINESS_PROFILE_PATH.$businessProfile['business_avatar']) :''
                    );
                    
                }
                $ratingInfo = array(
                    "overall_rating" =>  isset($businessProfile['overall_rating']) ? $businessProfile['overall_rating'] : 0,
                    "count_one_star" =>  isset($businessProfile['count_one_star']) ? $businessProfile['count_one_star'] : 0,
                    "count_two_star" =>  isset($businessProfile['count_two_star']) ? $businessProfile['count_two_star'] : 0,
                    "count_three_star" => isset($businessProfile['count_three_star']) ? $businessProfile['count_three_star'] : 0,
                    "count_four_star" =>  isset($businessProfile['count_four_star']) ? $businessProfile['count_four_star'] : 0,
                    "count_five_star" =>  isset($businessProfile['count_five_star']) ? $businessProfile['count_five_star'] : 0
                );
                $this->success200(array(
                    'page_id' => $page,
                    'per_page' => $perPage,
                    'page_count' => $pageCount,
                    'totals' => $rowCount,
                    'allow_review' => $allowReview,
                    'business_info' => $businessInfo,
                    'rating_info' => $ratingInfo,
                    'list' => $reviews
                ));
            } else {
                $this->error204($this->lang->line('business_id_does_not_exist'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function customer_reservation() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'page_id', 'per_page', 'search_text', 'book_status_id', 'service_type_id', 'order_by'));
           
            if(!isset($postData['business_id'])) $postData['business_id'] = 0;
            $postData['customer_id'] = $customer['customer_id'];
            $postData['api'] = true;
            $this->load->model(array('Mcustomerreservations','Mbusinessprofiles'));
            $rowCount = $this->Mcustomerreservations->getCountApi($postData);
            $pageCount = 0;
            $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
            $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;
            $customerReservations = [];
            $datas = [];
            if($rowCount > 0) {
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $customerReservations = $this->Mcustomerreservations->searchApi($postData, $perPage, $page);
                
                for($i = 0; $i < count($customerReservations); $i++) {
                    $data = $customerReservations[$i];
                    $businessInfo = $this->Mbusinessprofiles->get($data['business_profile_id']);
                    $datas[] = array(
                        'id' => $data['id'],
                        'book_code' => $data['book_code'],
                        'number_of_people' => $data['number_of_people'],
                        'date_arrived' => ddMMyyyy($data['date_arrived'], 'Y/m/d'),
                        'time_arrived' => ddMMyyyy($data['time_arrived'], 'H:i'),
                        'book_status_id' => $data['book_status_id'],
                        'business_info' => array(
                            "id" =>  $businessInfo['id'],
                            "business_name" =>  $businessInfo['business_name'],
                            "business_avatar" =>  !empty($businessInfo['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$businessInfo['business_avatar']):'',
                        )
                    );
                }
            }
            $dataReturn = array(
                'page_id' => $page,
                'per_page' => $perPage,
                'page_count' => $pageCount,
                'totals' => $rowCount,
                'list' => $datas
            );
            $allowBook = STATUS_NUMBER_ONE;
            if($postData['business_id'] > 0) {
                $business = $this->Mbusinessprofiles->get($postData['business_id']);
                $businessInfo = '';
                if($business) {
                    if(intval($business['allow_book']) == STATUS_ACTIVED) $allowBook = STATUS_ACTIVED;
                    $businessInfo = array(
                        'id' => $business['id'],
                        'business_name' => $business['business_name'],
                        'business_slogan' => $business['business_slogan'],
                        'business_avatar' => !empty($business['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$business['business_avatar']): '',
                        'business_image_cover' => !empty($business['business_image_cover']) ? base_url(BUSINESS_PROFILE_PATH.$business['business_avatar']) :''
                    );
                }
                $dataReturn['business_info'] = $businessInfo;
            }
            $dataReturn['allow_book'] = $allowBook;
            
            $this->success200($dataReturn);
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}