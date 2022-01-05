<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Businessmanagement extends MY_Controller { 

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

    public function my_business() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData['customer_id'] = $customer['customer_id'];
            $postData['api'] = true;
            $this->load->model(array('Mbusinessprofiles'));
            $rowCount = $this->Mbusinessprofiles->getCountInApi($postData);
            $listMyBusiness = $this->Mbusinessprofiles->getSearchMyBusiness($postData);
            for($i = 0; $i < count($listMyBusiness); $i++) {
                $listMyBusiness[$i]['business_avatar'] = !empty($listMyBusiness[$i]['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$listMyBusiness[$i]['business_avatar']): '';
            }
            $this->success200(array(
                'totals' => $rowCount,
                'list' => $listMyBusiness
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function list_plan() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('currency_code'));
            if(empty($postData['currency_code']) && !isset($this->Mconstants->currenyCodes[$postData['currency_code']])) {
                $this->error204($this->lang->line('the_currency_is_not_correct'));
                die;
            }
            $postData['customer_id'] = $customer['customer_id'];
            $postData['api'] = true;
            $this->load->model(array('Mcustomers', 'Mpaymentplans'));
            $customer = $this->Mcustomers->get($postData['customer_id']);
            $postData['plan_currency_id'] = $this->Mconstants->currenyCodes[$postData['currency_code']];
            $listPlan = $this->Mpaymentplans->getSearchListPlan($postData);
            $this->success200(array(
                'is_trial' => $customer['free_trial'],
                'currency_code' => $postData['currency_code'],
                'list' => $listPlan
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function create_business() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostApi(array('plan_id', 'is_trial'));
            $this->updateOrInsertBusiness(0, $postData['plan_id'], $postData['is_trial']);

        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function edit_business() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostApi(array('business_id'));
            $this->updateOrInsertBusiness($postData['business_id']);
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    private function updateOrInsertBusiness($businessId = 0, $planId = 0, $isTrial = 0) {
        $customer = $this->apiCheckLogin(false);
        $this->load->model('Mbusinessprofiles');
        $postData = $this->arrayFromPostApi(array('service_id', 'business_name', 'business_slogan', 'business_email', 'business_address', 'business_whatsapp', 'business_phone', 'business_description', 'country_code_id', 'open_hours', 'service_type_ids', 'country_code_whatsapp_id'));
        if ($businessId > 0) {
            $checkExit = $this->Mbusinessprofiles->countRows(array('customer_id' => $customer['customer_id'], 'id' => $businessId));
            if($checkExit <= 0) {
                $this->error204($this->lang->line('business_profile_does_not_exist'));
                die;
            }
        }
        
        if(isset($_FILES['business_avatar']) && !empty($_FILES['business_avatar']['name'])){
            $file = $_FILES['business_avatar'];
            if ($file['error'] > 0) {
                $this->error204($this->lang->line('avatar_update_failed'));
                die;
            } else {
                $business_avatar = explode('.', $file['name']);
                $fileExt = strtolower($business_avatar[count($business_avatar) - 1]);
                if(in_array($fileExt, array('jpeg', 'jpg', 'png'))) {
                    $dir = BUSINESS_PROFILE_PATH . date('Y-m-d') . '/';
                    @mkdir($dir, 0777, true);
                    @system("/bin/chown -R nginx:nginx " . $dir);
                    $filePath = $dir . uniqid() . '.' . $fileExt;
                    $flag = move_uploaded_file($file['tmp_name'], $filePath);
                    if ($flag) {
                        $business_avatar = replaceFileUrl($filePath, BUSINESS_PROFILE_PATH);
                        $postData['business_avatar'] = $business_avatar;
                    } else {
                        $this->error204($this->lang->line('avatar_update_failed'));
                        die;
                    }
                } else {
                    $this->error204($this->lang->line('the_image_is_not_in_the_correct_format_jpeg_jpg_png'));
                    die;
                }
            }
        }
        if(isset($_FILES['business_image_cover']) && !empty($_FILES['business_image_cover']['name'])){
            $file_2 = $_FILES['business_image_cover'];
            if ($file['error'] > 0) {
                $this->error204($this->lang->line('avatar_update_failed'));
                die;
            } else {
                $business_image_cover = explode('.', $file_2['name']);
                $fileExt = strtolower($business_image_cover[count($business_image_cover) - 1]);
                if(in_array($fileExt, array('jpeg', 'jpg', 'png'))) {
                    $dir = BUSINESS_PROFILE_PATH . date('Y-m-d') . '/';
                    @mkdir($dir, 0777, true);
                    @system("/bin/chown -R nginx:nginx " . $dir);
                    $filePath = $dir . uniqid() . '.' . $fileExt;
                    $flag = move_uploaded_file($file_2['tmp_name'], $filePath);
                    if ($flag) {
                        $business_image_cover = replaceFileUrl($filePath, BUSINESS_PROFILE_PATH);
                        $postData['business_image_cover'] = $business_image_cover;
                    } else {
                        $this->error204($this->lang->line('avatar_update_failed'));
                        die;
                    }
                } else {
                    $this->error204($this->lang->line('the_image_is_not_in_the_correct_format_jpeg_jpg_png'));
                    die;
                }
            }
        }
        $this->validateBusiness($postData);
        $openHours =  json_decode($postData['open_hours'], true);
        $openingHours = array();
        foreach ($this->Mconstants->dayIds as $day_id => $itemHours) {
            if (isset($open_hours[$day_id])) {
                $itemHours = $open_hours[$day_id];
                $itemDay = array();
                $itemDay['day_id'] = $day_id;
                if (isset($itemHours['opening_hours_status_id']) && $itemHours['opening_hours_status_id'] == 'on') {
                    $itemDay['opening_hours_status_id'] = STATUS_ACTIVED;
                } else {
                    $itemDay['opening_hours_status_id'] = 1;
                }

                if (!empty($itemHours['start_time'])) {
                    $itemDay['start_time'] = $itemHours['start_time'];
                } else {
                    $itemDay['start_time'] = "00:00";
                }

                if (!empty($itemHours['end_time'])) {
                    $itemDay['end_time'] = $itemHours['end_time'];
                } else {
                    $itemDay['end_time'] = "23:59";
                }
            } else {
                $itemDay = array();
                $itemDay['day_id'] = $day_id;
                $itemDay['opening_hours_status_id'] = 1;
                $itemDay['start_time'] = "00:00";
                $itemDay['end_time'] = "00:00";
            }

            $openingHours[] = $itemDay;
        }

        $service_type_ids = json_decode($postData['service_type_ids'], true);
        $businessServiceTypes = array();
        if (!empty($service_type_ids)) {
            $businessServiceTypes = $service_type_ids;
        }

        unset($postData['open_hours'], $postData['service_type_ids']);
        
        $message = 'Create a successful business profile';
        if($businessId > 0) {
            $postData['customer_id'] = $customer['customer_id'];
            $postData['updated_at'] = getCurentDateTime();
            $postData['updated_by'] = 0;
            $message = 'Update a successful business profile';
        } else {
            if(intval($isTrial) == 1){
                $date = strtotime("+3 months", strtotime(date('Y-m-d H:i:s')));
                $postData['expired_date'] = date('Y-m-d H:i:s', $date);
                
                $postData['business_status_id'] = STATUS_ACTIVED;
            } else {
                $postData['business_status_id'] = 1;
            }
            $postData['plan_id'] = $planId;
            $postData['customer_id'] = $customer['customer_id'];
            $postData['created_at'] = getCurentDateTime();
            $postData['updated_at'] = 0;
        }
        $this->load->model(array('Mopeninghours', 'Mbusinessservicetype'));
        $flag = $this->Mbusinessprofiles->save($postData, $businessId);
        if($flag) {
            if(intval($isTrial) == 1 && $businessId <= 0){
                $this->Mcustomers->save(array('free_trial' => 1, 'free_trial_type' => $planId), $customer['customer_id']);
            }
            //open hours
            if (!empty($openingHours)) {
                $resultOpenHours = $this->Mopeninghours->saveOpenHours($openingHours, $flag);
            }

            //service types
            if (!empty($businessServiceTypes)) {
                $resultServiceTypes = $this->Mbusinessservicetype->saveServiceType($businessServiceTypes, $flag);
            }
            $dataReturn = array('business_id' => $flag);
            if($businessId == 0) {
                $dataReturn['business_status_id'] = $postData['business_status_id'];
            }
            $this->success200($dataReturn, $message);
            die;
        }else {
            $this->error204($this->lang->line('business_profile_creation_failed'));
            die;
        }
    }

    private function validateBusiness($postData) {
        if(empty($postData['service_id']) && $postData['service_id'] < 0) {
            $this->error204($this->lang->line('please_select_service'));
            die;
        }
        if(empty($postData['business_name'])) {
            $this->error204($this->lang->line('please_enter_business_name'));
            die;
        }
        if(empty($postData['business_slogan'])) {
            $this->error204($this->lang->line('please_enter_business_slogan'));
            die;
        }
        if(!checkemail($postData['business_email'])) {
            $this->error204('Email not exist');
            die;
        }
        if(empty($postData['business_address'])) {
            $this->error204($this->lang->line('please_enter_business_address'));
            die;
        }
    }

    public function upload_photos() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostApi(array('business_id'));
            $this->load->model(array('Mbusinessprofiles', 'Mbusinessphotos'));
            if ($postData['business_id'] > 0) {
                $checkExit = $this->Mbusinessprofiles->countRows(array('customer_id' => $customer['customer_id'], 'id' => $postData['business_id']));
                if($checkExit <= 0) {
                    $this->error204($this->lang->line('business_profile_does_not_exist'));
                    die;
                }
                $arrPhotos = [];
                foreach($_FILES['photos']['name'] as $i => $name) {
                    // now $name holds the original file name
                    $tmp_name = $_FILES['photos']['tmp_name'][$i];
                    $error = $_FILES['photos']['error'][$i];
                    if ($error > 0) {
                        $this->error204($this->lang->line('avatar_update_failed'));
                        die;
                    }
                    $photo = explode('.', $name);
                    $fileExt = strtolower($photo[count($photo) - 1]);
                    if(in_array($fileExt, array('jpeg', 'jpg', 'png'))) {
                        $dir = BUSINESS_PROFILE_PATH . date('Y-m-d') . '/';
                        @mkdir($dir, 0777, true);
                        @system("/bin/chown -R nginx:nginx " . $dir);
                        $filePath = $dir . uniqid() . '.' . $fileExt;
                        $flag = move_uploaded_file($tmp_name, $filePath);
                        if ($flag) {
                            $photo_image = replaceFileUrl($filePath, BUSINESS_PROFILE_PATH);
                            $arrPhotos[] = $photo_image;
                        } else {
                            $this->error204($this->lang->line('avatar_update_failed'));
                            die;
                        }
                    } else {
                        $this->error204($this->lang->line('the_image_is_not_in_the_correct_format_jpeg_jpg_png'));
                        die;
                    }
                }
                if(count($arrPhotos) > 0) {
                    $flag = $this->Mbusinessphotos->savePhotos($arrPhotos, $postData['business_id']);
                    if($flag) {
                       
                        $rowCount = $this->Mbusinessphotos->getCountInApi($postData);
                        $perPage = DEFAULT_LIMIT;
                        $pageCount = 0;
                        $page = 1;
                        $businessVideos = [];

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
                        ), 'Upload image successfully');
                    } else {
                        $this->error204($this->lang->line('image_upload_failed'));
                        die;
                    }
                } else {
                    $this->error204($this->lang->line('please_add_pictures'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('business_profile_does_not_exist'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function upload_videos() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'videos'));
            $this->load->model(array('Mbusinessprofiles', 'Mbusinessvideos'));
            if ($postData['business_id'] > 0) {
                $checkExit = $this->Mbusinessprofiles->countRows(array('customer_id' => $customer['customer_id'], 'id' => $postData['business_id']));
                if($checkExit <= 0) {
                    $this->error204($this->lang->line('business_profile_does_not_exist'));
                    die;
                }
                if(empty($postData['videos']) || count($postData['videos']) <= 0) {
                    $this->error204('Please add video link');
                    die;
                }
                $flag = $this->Mbusinessvideos->saveVideos($postData['videos'], $postData['business_id']);
                if($flag) {
                    $rowCount = $this->Mbusinessvideos->getCountInApi($postData);
                    $perPage = DEFAULT_LIMIT;
                    $pageCount = 0;
                    $page = 1;
                    $businessVideos = [];

                    if($rowCount > 0) {
                        $pageCount = ceil($rowCount / $perPage);
                        if(!is_numeric($page) || $page < 1) $page = 1;
                        $businessVideos = $this->Mbusinessvideos->getListInApi($postData, $perPage, $page);
                        $videos = [];
                        for($i = 0; $i < count($businessVideos); $i++) {
                            $videos[] = $businessVideos[$i]['video_url'];
                        }
                    }
                    $this->success200(array(
                        'page_id' => $page,
                        'per_page' => $perPage,
                        'page_count' => $pageCount,
                        'totals' => $rowCount,
                        'list' => $videos
                    ), 'Download video successfully');
                } else {
                    $this->error204('Add failed video');
                    die;
                }
            } else {
                $this->error204($this->lang->line('business_profile_does_not_exist'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function create_coupon() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $this->createOrUpdateCoupon(0);
            
        } catch (\Throwable $th) {
            echo $th;
            $this->error500();
        }
    }

    public function edit_coupon() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostApi(array('coupon_id'));
            $this->createOrUpdateCoupon($postData['coupon_id']);
            
        } catch (\Throwable $th) {
            echo $th;
            $this->error500();
        }
    }

    public function cancel_coupon() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('coupon_id', 'business_id'));
            
            if ($postData['business_id'] > 0) {
                $checkExit = $this->Mbusinessprofiles->countRows(array('customer_id' => $customer['customer_id'], 'id' => $postData['business_id']));
                if($checkExit <= 0) {
                    $this->error204($this->lang->line('business_profile_does_not_exist'));
                    die;
                }

                $couponId = $postData['coupon_id'];

                $flag = $this->Mcoupons->update(array('coupon_status_id' => 0), $couponId);
                
                if ($flag > 0) {
                    $this->success200(array('coupon_id' => $flag), $this->lang->line('additional_successful1'));
                    die;
                } else {
                    $this->error204("Failed");
                    die;
                }
            }

        } catch (\Throwable $th) {
            echo $th;
            $this->error500();
        }
    }

    private function createOrUpdateCoupon($couponId = 0) {
        try {
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostApi(array('business_id', 'coupon_subject', 'coupon_amount', 'coupon_description', 'start_date', 'end_date'));
            $this->load->model(array('Mcoupons', 'Mbusinessprofiles'));
            
            if ($postData['business_id'] > 0) {
                $checkExit = $this->Mbusinessprofiles->countRows(array('customer_id' => $customer['customer_id'], 'id' => $postData['business_id']));
                if($checkExit <= 0) {
                    $this->error204($this->lang->line('business_profile_does_not_exist'));
                    die;
                }
               
                if(empty($postData['coupon_subject']) || $postData['coupon_subject'] == ""){
                    $this->error204($this->lang->line('coupon_subject_is_required'));
                    die;
                }
                $postData['start_date'] = date("Y-m-d", strtotime($postData['start_date']));
                $postData['end_date'] = date("Y-m-d", strtotime($postData['end_date']));
                $currentDay = strtotime(date('Y-m-d'));

                if(strtotime($postData['start_date']) < $currentDay || strtotime($postData['end_date']) < $currentDay){
                    $this->error204($this->lang->line('please_select_date_in_present_or_future'));
                    die;
                }
                if(strtotime($postData['start_date']) > strtotime($postData['end_date'])){
                    $this->error204($this->lang->line('please_select_different_date'));
                    die;
                }

                if(empty($postData['coupon_amount']) || $postData['coupon_amount'] == 0){
                    $this->error204($this->lang->line('amount_of_coupon_must_be_larger_than_0'));
                    die;
                }
                if(isset($_FILES['coupon_image']) && !empty($_FILES['coupon_image'])){
                    $file = $_FILES['coupon_image'];
                    if ($file['error'] > 0) {
                        $this->error204($this->lang->line('avatar_update_failed'));
                        die;
                    } else {
                        $coupon_image = explode('.', $file['name']);
                        $fileExt = strtolower($coupon_image[count($coupon_image) - 1]);
                        if(in_array($fileExt, array('jpeg', 'jpg', 'png'))) {
                            $dir = COUPONS_PATH . date('Y-m-d') . '/';
                            @mkdir($dir, 0777, true);
                            @system("/bin/chown -R nginx:nginx " . $dir);
                            $filePath = $dir . uniqid() . '.' . $fileExt;
                            $flag = move_uploaded_file($file['tmp_name'], $filePath);
                            if ($flag) {
                                $coupon_image = replaceFileUrl($filePath, COUPONS_PATH);
                                $postData['coupon_image'] = $coupon_image;
                            } else {
                                $this->error204($this->lang->line('avatar_update_failed'));
                                die;
                            }
                        } else {
                            $this->error204($this->lang->line('the_image_is_not_in_the_correct_format_jpeg_jpg_png'));
                            die;
                        }
                    }
                    
                }

                $message = 'Create success';
                if ($couponId == 0) {
                    $postData['coupon_status_id'] = STATUS_ACTIVED;
                    $postData['created_by'] = 0;
                    $postData['created_at'] = getCurentDateTime();
                } else {
                    $message = 'Update successful';
                    $postData['updated_by'] = 0;
                    $postData['updated_at'] = getCurentDateTime();
                }
                $postData['business_profile_id'] = $postData['business_id'];
                unset($postData['business_id']);
                $flag = $this->Mcoupons->update($postData, $couponId);
                
                if ($flag > 0) {
                    $this->success200(array('coupon_id' => $flag), $message);
                    die;
                } else {
                    $this->error204($this->lang->line('creating_coupon_failed'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('business_profile_does_not_exist'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function reservation() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'page_id', 'per_page', 'search_text', 'selected_date', 'book_status_id', 'order_by'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mcustomerreservations', 'Mcustomers'));
            $postData['customer_id'] = $customer['customer_id'];
            $postData['api'] = true;
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('customer_id' => $postData['customer_id'], 'id' => $postData['business_id']), 'id', 0);
            if($checkExit == 0) {
                $this->error204('Business profile does not belong to this customer');
                die;
            }
            $rowCount = $this->Mcustomerreservations->getCountApi($postData);
            $pageCount = 0;
            $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
            $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;
            $dataReturn = [];
            if($rowCount > 0) {
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $customerReservations = $this->Mcustomerreservations->searchReservationApi($postData, $perPage, $page);
                
                for($i = 0; $i < count($customerReservations); $i++) {
                    $reservation = $customerReservations[$i];
                    $customer = $this->Mcustomers->get($postData['customer_id']);
                    $firstName = !empty($customer['customer_first_name']) ? $customer['customer_first_name'].' ' : '';
                    $lastName = !empty($customer['customer_last_name']) ? $customer['customer_last_name'] : '';
                    $phoneNumber = !empty($customer['customer_phone']) ? ltrim($customer['customer_phone'], '0') : '';
                    $phoneCode = !empty($customer['customer_phone_code']) ? '+'.$customer['customer_phone_code'] : '';
                    $dataReturn[] = array(
                        "id" => $reservation['id'],
                        "book_code" => $reservation['book_code'],
                        "book_phone" => $phoneCode.$phoneNumber,
                        "book_name" => $reservation['book_name'],
                        "customer_name" => $firstName.$lastName,
                        "number_of_people" => intval($reservation['number_of_people']),
                        "date_arrived" => ddMMyyyy($reservation['date_arrived'], 'Y/m/d'),
                        "time_arrived" => ddMMyyyy($reservation['time_arrived'], 'H:i'),
                        "book_status_id" => intval($reservation['book_status_id'])
                    );
                }
            }
            $this->success200(array(
                'page_id' => $page,
                'per_page' => $perPage,
                'page_count' => $pageCount,
                'totals' => $rowCount,
                'list' => $dataReturn
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function create_event() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostApi(array('business_id', 'event_image', 'event_subject', 'start_date', 'start_time', 'end_date', 'end_time', 'event_description'));
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model(array('Mbusinessprofiles', 'Mevents'));
            $this->checkValidateCreateEvent($postData);
            if(isset($_FILES['event_image']) && !empty($_FILES['event_image'])){
                $file = $_FILES['event_image'];
                if ($file['error'] > 0) {
                    $this->error204('Event image update failed');
                    die;
                } else {
                    $event_image = explode('.', $file['name']);
                    $fileExt = strtolower($event_image[count($event_image) - 1]);
                    if(in_array($fileExt, array('jpeg', 'jpg', 'png'))) {
                        $dir = COUPONS_PATH . date('Y-m-d') . '/';
                        @mkdir($dir, 0777, true);
                        @system("/bin/chown -R nginx:nginx " . $dir);
                        $filePath = $dir . uniqid() . '.' . $fileExt;
                        $flag = move_uploaded_file($file['tmp_name'], $filePath);
                        if ($flag) {
                            $event_image = replaceFileUrl($filePath, COUPONS_PATH);
                            $postData['event_image'] = $event_image;
                        } else {
                            $this->error204('Event image update failed');
                            die;
                        }
                    } else {
                        $this->error204($this->lang->line('the_image_is_not_in_the_correct_format_jpeg_jpg_png'));
                        die;
                    }
                }
            }

            $postData['start_date'] = ddMMyyyy($postData['start_date'], 'Y-m-d');
            $postData['start_time'] = ddMMyyyy($postData['start_time'], 'H:i');

            $postData['end_date'] = ddMMyyyy($postData['end_date'], 'Y-m-d');
            $postData['end_time'] = ddMMyyyy($postData['end_time'], 'H:i');

            $postData['business_profile_id'] = $postData['business_id'];
            $postData['event_status_id'] = STATUS_ACTIVED;

            unset($postData['business_id'], $postData['customer_id']);

            $flag = $this->Mevents->save($postData);
            if ($flag > 0) {
                $this->success200(array('event_id' => $flag), 'Successful event creation');
                die;
            } else {
                $this->error204('Successful event failed');
                die;
            }

        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    private function checkValidateCreateEvent($postData) {
        if(!isset($postData['business_id'])) {
            $this->error204('business_id: not transmitted');
            die;
        }
       
        if(!isset($postData['event_subject'])) {
            $this->error204('event_subject: not transmitted');
            die;
        }
        if(!isset($postData['start_date'])) {
            $this->error204('start_date: not transmitted');
            die;
        }
        if(!isset($postData['start_time'])) {
            $this->error204('start_time: not transmitted');
            die;
        }
        if(!isset($postData['end_date'])) {
            $this->error204('end_date: not transmitted');
            die;
        }
        if(!isset($postData['end_time'])) {
            $this->error204('end_time: not transmitted');
            die;
        }
        if(!isset($postData['event_description'])) {
            $this->error204('event_description: not transmitted');
            die;
        }
        $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $postData['customer_id'], 'business_status_id >' => 0), 'id', 0);
        if(!$checkExit) {
            $this->error204('Business does not belong to this customer');
            die;
        }
        if(!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $postData['start_time'])) {
            $this->error204('start_time: not time format');
            die;
        }
        if(!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $postData['end_time'])) {
            $this->error204('end_time: not time format');
            die;
        }
        if(empty($postData['event_subject'])) {
            $this->error204('Event subject must not be empty');
            die;
        }
        if(empty($postData['start_date'])) {
            $this->error204('Start date must not be empty');
            die;
        }
        if(empty($postData['start_time'])) {
            $this->error204('Start time must not be empty');
            die;
        }
        if(empty($postData['end_date'])) {
            $this->error204('End date must not be empty');
            die;
        }
        if(empty($postData['end_time'])) {
            $this->error204('End time must not be empty');
            die;
        }
        if(empty($postData['event_description'])) {
            $this->error204('Event description must not be empty');
            die;
        }
        $startDate = ddMMyyyy($postData['start_date'], 'Y-m-d');
        $startTime = ddMMyyyy($postData['start_time'], 'H:i:s');
        $startDateTime = strtotime($startDate.' '.$startTime);

        $endDate = ddMMyyyy($postData['end_date'], 'Y-m-d');
        $emdTime = ddMMyyyy($postData['end_time'], 'H:i:s');
        $endDateTime = strtotime($endDate.' '.$emdTime);

        $dateNow = strtotime(getCurentDateTime());

        if($startDateTime < $dateNow) {
            $this->error204('Start date and start time must not be less than the current date and time');
            die;
        }
        if($endDateTime < $dateNow) {
            $this->error204('End date and end time must not be less than the current date and time');
            die;
        }

        if($endDateTime < $startDateTime) {
            $this->error204('Start date and start time must not be less than the current end date and end time');
            die;
        }


    }

    public function update_event() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostApi(array('business_id', 'event_id', 'event_image', 'event_subject', 'end_date', 'end_time', 'event_description'));
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model(array('Mbusinessprofiles', 'Mevents'));
            $dataUpdate = $this->checkValedateUpdateEvent($postData);
            $eventId = $dataUpdate['id'];
            unset($dataUpdate['id']);
            $flag = $this->Mevents->save($dataUpdate, $eventId);
            if ($flag > 0) {
                $this->success200(array('event_id' => $flag), 'Successful event update');
                die;
            } else {
                $this->error204('Event update failed');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    private function checkValedateUpdateEvent($postData) {
        if(!isset($postData['business_id'])) {
            $this->error204('business_id: not transmitted');
            die;
        }
        if(!isset($postData['event_id'])) {
            $this->error204('event_id: not transmitted');
            die;
        }

        $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $postData['customer_id'], 'business_status_id >' => 0), 'id', 0);
        if(!$checkExit) {
            $this->error204('Business does not belong to this customer');
            die;
        }

        $event = $this->Mevents->get($postData['event_id']);
        
        if($event && $event['business_profile_id'] != $postData['business_id'] && $event['event_status_id'] != STATUS_ACTIVED) {
            $this->error204('Event does not belong to this Business');
            die;
        }

        $startDate = ddMMyyyy($event['start_date'], 'Y-m-d');
        $startTime = ddMMyyyy($event['start_time'], 'H:i:s');
        $startDateTime = strtotime($startDate.' '.$startTime);

        $endDate = ddMMyyyy($postData['end_date'], 'Y-m-d');
        $emdTime = ddMMyyyy($postData['end_time'], 'H:i:s');
        $endDateTime = strtotime($endDate.' '.$emdTime);

        $dateNow = strtotime(getCurentDateTime());

        $dataUpdate = [];
        if($dateNow <= $startDateTime) {
            if(!isset($postData['end_date'])) {
                $this->error204('end_date: not transmitted');
                die;
            }
            if(!isset($postData['end_time'])) {
                $this->error204('end_time: not transmitted');
                die;
            }
            if(!isset($postData['event_description'])) {
                $this->error204('event_description: not transmitted');
                die;
            }
            if(!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $postData['end_time'])) {
                $this->error204('end_time: not time format');
                die;
            }
            if(empty($postData['event_subject'])) {
                $this->error204('Event subject must not be empty');
                die;
            }
            if(empty($postData['end_date'])) {
                $this->error204('End date must not be empty');
                die;
            }
            if(empty($postData['end_time'])) {
                $this->error204('End time must not be empty');
                die;
            }
            if(empty($postData['event_description'])) {
                $this->error204('Event description must not be empty');
                die;
            }

            if($endDateTime < $dateNow) {
                $this->error204('End date and end time must not be less than the current date and time');
                die;
            }
    
            if($endDateTime < $startDateTime) {
                $this->error204('Start date and start time must not be less than the current end date and end time');
                die;
            }

            if(isset($_FILES['event_image']) && !empty($_FILES['event_image'])){
                $file = $_FILES['event_image'];
                if ($file['error'] > 0) {
                    $this->error204('Event image update failed');
                    die;
                } else {
                    $event_image = explode('.', $file['name']);
                    $fileExt = strtolower($event_image[count($event_image) - 1]);
                    if(in_array($fileExt, array('jpeg', 'jpg', 'png'))) {
                        $dir = COUPONS_PATH . date('Y-m-d') . '/';
                        @mkdir($dir, 0777, true);
                        @system("/bin/chown -R nginx:nginx " . $dir);
                        $filePath = $dir . uniqid() . '.' . $fileExt;
                        $flag = move_uploaded_file($file['tmp_name'], $filePath);
                        if ($flag) {
                            $event_image = replaceFileUrl($filePath, COUPONS_PATH);
                            $postData['event_image'] = $event_image;
                        } else {
                            $this->error204('Event image update failed');
                            die;
                        }
                    } else {
                        $this->error204('The image is not in the correct format: jpeg, jpg, png');
                        die;
                    }
                }
            }

            $dataUpdate = array(
                'business_profile_id' => $postData['business_id'],
                'event_image' => $postData['event_image'],
                'event_subject' => $postData['event_subject'],
                'end_date' => $postData['end_date'],
                'end_time' => $postData['end_time'],
                'event_description' => $postData['event_description'],
                'updated_at' => getCurentDateTime(),
                'id' => $event['id']
            );
        } else if ($dateNow >= $startDateTime && $dateNow >= $endDateTime){
            if(!isset($postData['end_date'])) {
                $this->error204('end_date: not transmitted');
                die;
            }
            if(!isset($postData['end_time'])) {
                $this->error204('end_time: not transmitted');
                die;
            }
            if(!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $postData['end_time'])) {
                $this->error204('end_time: not time format');
                die;
            }
            if(empty($postData['end_date'])) {
                $this->error204('End date must not be empty');
                die;
            }
            if(empty($postData['end_time'])) {
                $this->error204('End time must not be empty');
                die;
            }
            $dataUpdate = array(
                'end_date' => $postData['end_date'],
                'end_time' => $postData['end_time'],
                'updated_at' => getCurentDateTime(),
                'id' => $event['id']
            );
        }


        return $dataUpdate;

    }

    public function cancel_event() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'event_id'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['event_id'])) {
                $this->error204('event_id: not transmitted');
                die;
            }

            $this->load->model(array('Mbusinessprofiles', 'Mevents'));
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id'], 'business_status_id >' => 0), 'id', 0);
            if(!$checkExit) {
                $this->error204('Business does not belong to this customer');
                die;
            }

            $checkExitEvent = $this->Mevents->getFieldValue(array('id' => $postData['event_id'], 'business_profile_id' => $postData['business_id'], 'event_status_id' => 2), 'id', 0);
            if(!$checkExitEvent) {
                $this->error204('Event does not belong to this Business');
                die;
            }
            $cancelData = array(
                'event_status_id' => 0,
                'deleted_at' => getCurentDateTime()
            );
            $flag = $this->Mevents->save($cancelData, $postData['event_id']);
            if ($flag > 0) {
                $this->success200('', 'Successful event cancellation');
                die;
            } else {
                $this->error204('Canceling failed event');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function check_coupon_code() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'customer_code'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['customer_code'])) {
                $this->error204('customer_code: not transmitted');
                die;
            }
            if(empty($postData['customer_code'])) {
                $this->error204('Customer code is not null');
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mcustomercoupons', 'Mcoupons'));
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id'], 'business_status_id >' => 0), 'id', 0);
            if(!$checkExit) {
                $this->error204('Business does not belong to this customer');
                die;
            }
            $couponId = $this->Mcustomercoupons->getFieldValue(array('customer_coupon_code' => $postData['customer_code'], 'customer_id' => $customer['customer_id'], 'customer_coupon_status_id >' => 0), 'coupon_id', 0);
            if(!$couponId) {
                $this->error204('Coupon code does not exist');
                die;
            }
            $coupon = $this->Mcoupons->get($couponId);
           
            if(!$coupon || ($coupon && $coupon['coupon_status_id'] != 2)) {
                $this->error204('Coupon code does not exist');
                die;
            }

            $startDate = strtotime(ddMMyyyy($coupon['start_date'], 'Y-m-d H:i:s'));
            $endDate = strtotime(ddMMyyyy($coupon['end_date'], 'Y-m-d H:i:s'));
           
            $dataRetrun = [];
            $dateNow = strtotime(getCurentDateTime());
            $message = 'Code has expired or cannot be used';
            if ($endDate < $dateNow || $startDate > $dateNow) {
                $dataReturn['customer_coupon_status_id'] = 3; //Mã đã hết hạn hoặc chưa thể sử dụng
            } else {
                $customercoupons = $this->Mcustomercoupons->getBy(array('customer_coupon_code' => $postData['customer_code'], 'customer_id' => $customer['customer_id'], 'customer_coupon_status_id >' => 0));
                $customercoupons = $customercoupons[0];
                if($customercoupons['customer_coupon_status_id'] == 2) {
                    $message = 'Valid code';
                    $dataReturn['customer_coupon_status_id'] = 2; //Mã hợp lệ
                } else if($customercoupons['customer_coupon_status_id'] == 1) {
                    $message = 'Code already used';
                    $dataReturn['customer_coupon_status_id'] = 1; // Mã đã được sử dụng
                }
            }
            $dataReturn['customer_code'] = $postData['customer_code'];
            $this->success200($dataReturn, $message);
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function active_coupon_code() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'customer_code'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['customer_code'])) {
                $this->error204('customer_code: not transmitted');
                die;
            }
            if(empty($postData['customer_code'])) {
                $this->error204('Customer code is not null');
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mcustomercoupons', 'Mcoupons'));
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id'], 'business_status_id >' => 0), 'id', 0);
            if(!$checkExit) {
                $this->error204('Business does not belong to this customer');
                die;
            }
            $customerCoupons = $this->Mcustomercoupons->getBy(array('customer_coupon_code' => $postData['customer_code'], 'customer_id' => $customer['customer_id'], 'customer_coupon_status_id' => 2));
            if(count($customerCoupons) == 0) {
                $this->error204('Coupon code does not exist');
                die;
            }

            $customerCoupons = $customerCoupons[0];
            $coupon = $this->Mcoupons->get($customerCoupons['coupon_id']);
           
            if(!$coupon || ($coupon && $coupon['coupon_status_id'] != 2)) {
                $this->error204('Coupon code does not exist');
                die;
            }
            $startDate = strtotime(ddMMyyyy($coupon['start_date'], 'Y-m-d H:i:s'));
            $endDate = strtotime(ddMMyyyy($coupon['end_date'], 'Y-m-d H:i:s'));
           
            $dateNow = strtotime(getCurentDateTime());

            if($startDate < $dateNow && $endDate > $dateNow) {
                $flag = $this->Mcustomercoupons->save(array(
                    'customer_coupon_status_id' => 1,
                    'updated_at' => getCurentDateTime()
                ), $customerCoupons['id']);
                if ($flag > 0) {
                    $this->success200('', 'Activation code successful');
                    die;
                } else {
                    $this->error204('Activation code failed');
                    die;
                }
            } else {
                $this->error204('Code has expired or cannot be used');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function get_billing_info() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mpaymentplans'));
            $checkExit = $this->Mbusinessprofiles->get($postData['business_id']);
            $flag = false;
            if(empty($checkExit)) $flag = true;
            if($checkExit['customer_id'] != $customer['customer_id'] && $customer['business_status_id'] <=0 ) $flag = true;
            if($flag) {
                $this->error204('Business does not belong to this customer');
                die;
            }
            $paymentPlan = $this->Mpaymentplans->get($checkExit['plan_id']);
            if(!$paymentPlan || ($paymentPlan && $paymentPlan['plan_status_id'] != STATUS_ACTIVED)) {
                $this->error204('Payment Plans do not exist');
                die;
            }
            $paymentAmount = floatval($paymentPlan['plan_amount']);
            $planVat = floatval($paymentPlan['plan_vat']);
            $vatPrice = ($planVat / 100) * floatval($paymentPlan['plan_total']);
            $totalPrice =  floatval($paymentPlan['plan_total']);
            
            
            $this->success200(array('plan_infor' => array(
                "payment_amount" => $paymentAmount,
                "plan_vat" => $planVat,
                "vat_price" => round($vatPrice),
                "total_price" => $totalPrice
            )));
            die;
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function save_billing_info() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'payment_name', 'payment_address', 'payment_company_id', 'payment_company_vat_id'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['payment_name'])) {
                $this->error204('payment_name: not transmitted');
                die;
            }
            if(!isset($postData['payment_address'])) {
                $this->error204('payment_address: not transmitted');
                die;
            }
            if(empty($postData['payment_name'])) {
                $this->error204('Payment name cannot be empty');
                die;
            }
            if(empty($postData['payment_address'])) {
                $this->error204('Payment address cannot be empty');
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mbusinesspayments', 'Mpaymentplans'));
            $business = $this->Mbusinessprofiles->get($postData['business_id']);
            if(empty($business) || (!empty($business) && $business['customer_id'] != $customer['customer_id'] && $business['business_status_id'] <= 0)) {
                $this->error204('Business does not belong to this customer');
                die;
            }

            $data = array(
                'business_profile_id' => $postData['business_id'],
                'payment_gateway_id' => 1,
                'payment_name' => $postData['payment_name'],
                'payment_address' => $postData['payment_address'],
                'payment_company_id' => isset($postData['payment_company_id']) ? $postData['payment_company_id']: '',
                'payment_compnay_vat_id' => isset($postData['payment_compnay_vat_id']) ? $postData['payment_compnay_vat_id']: '',
                'payment_status_id' => 1
            );

            $flag = $this->Mbusinesspayments->save($data);
            if ($flag > 0) {
                $dataReturn = array(
                    "payment_id" => $flag,
                    "paypal_plan_id" => $this->Mpaymentplans->getFieldValue(array('id' => $business['plan_id']), 'plan_id', '')
                );
                $this->success200($dataReturn, 'Success save billing info');
                die;
            } else {
                $this->error204('Failed to save payment information');
                die;
            }
            
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function available_plan() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'currency_code'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }

            if(!isset($postData['currency_code'])) $postData['currency_code'] = 'CZK';
            $postData['api'] = true;
            $this->load->model(array('Mbusinessprofiles', 'Mpaymentplans'));
            $business = $this->Mbusinessprofiles->get($postData['business_id']);
            if(empty($business) || (!empty($business) && $business['customer_id'] != $customer['customer_id'] && $business['business_status_id'] <= 0)) {
                $this->error204('Business does not belong to this customer');
                die;
            }
            $postData['plan_currency_id'] = $this->Mconstants->currenyCodes[$postData['currency_code']];
            $postData['customer_id'] = $customer['customer_id'];
            $listPlan = $this->Mpaymentplans->getAvailablePlan($postData);
            for($i = 0; $i < count($listPlan); $i++) {
                $selectedId = 0;
                if($listPlan[$i]['id'] == $business['plan_id']) {
                    $selectedId = 1;
                }
                $listPlan[$i]['is_selected'] = $selectedId;

                unset($listPlan[$i]['id']);
            }
            $this->success200(array(
                'currency_code' => $postData['currency_code'],
                'plans' => $listPlan
            ));
            die;
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function change_plan() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'plan_id'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['plan_id'])) {
                $this->error204('plan_id: not transmitted');
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mpaymentplans'));
            $business = $this->Mbusinessprofiles->get($postData['business_id']);
            if(empty($business) || (!empty($business) && $business['customer_id'] != $customer['customer_id'] && $business['business_status_id'] <= 0)) {
                $this->error204('Business does not belong to this customer');
                die;
            }

            $planId = $this->Mpaymentplans->getFieldValue(array('id' => $postData['plan_id'], 'plan_status_id' => 2), 'id', 0);
            if($planId == 0) {
                $this->error204('Payment plans do not exist');
                die;
            }

            $flag = $this->Mbusinessprofiles->save(
                array(
                    'plan_id' => $planId,
                    'updated_at' => getCurentDateTime(),
                ),
                $business['id']
            );
            if($flag) {
                $this->success200(array('business_id' => $flag), 'Update successfully');
                die;
            } else {
                $this->error204('Update failed');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function recall_coupon() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'coupon_id'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['coupon_id'])) {
                $this->error204('coupon_id: not transmitted');
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mcoupons'));
            $business = $this->Mbusinessprofiles->get($postData['business_id']);
            if(empty($business) || (!empty($business) && $business['customer_id'] != $customer['customer_id'] && $business['business_status_id'] <= 0)) {
                $this->error204('Business does not belong to this customer');
                die;
            }
            $coupon = $this->Mcoupons->get($postData['coupon_id']);
            if(empty($coupon)) {
                $this->error204('Coupon id does not exist');
                die;
            }
            if($coupon['business_profile_id'] != $postData['business_id']) {
                $this->error204('Coupon id does not busines profile');
                die;
            }
            $currentDate = strtotime(date('Y-m-d'));
            $startDate = strtotime($coupon['start_date']);
            if($coupon['coupon_status_id'] != 2 || $startDate < $currentDate) {
                $this->error204('Coupon inactive or not yet due');
                die;
            }
            $flag = $this->Mcoupons->save(array(
                'coupon_status_id' => 1,
                'updated_at' => getCurentDateTime()
            ), $coupon['id']);
            if($flag) {
                $this->success200('', 'Recall coupon success');
                die;
            } else {
                $this->error204('Coupon callback failed');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
   
}