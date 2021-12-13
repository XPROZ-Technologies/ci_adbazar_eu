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
                $this->error204('The currency is not correct');
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
        $postData = $this->arrayFromPostApi(array('service_id', 'business_name', 'business_slogan', 'business_email', 'business_address', 'business_whatsapp', 'business_phone', 'business_description', 'country_code_id', 'open_hours', 'service_type_ids'));
        if ($businessId > 0) {
            $checkExit = $this->Mbusinessprofiles->countRows(array('customer_id' => $customer['customer_id'], 'id' => $businessId));
            if($checkExit <= 0) {
                $this->error204('Business profile does not exist');
                die;
            }
        }
        
        if(isset($_FILES['business_avatar']) && !empty($_FILES['business_avatar'])){
            $file = $_FILES['business_avatar'];
            if ($file['error'] > 0) {
                $this->error204('Avatar update failed');
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
                        $this->error204('Avatar update failed');
                        die;
                    }
                } else {
                    $this->error204('The image is not in the correct format: jpeg, jpg, png');
                    die;
                }
            }
        }
        if(isset($_FILES['business_image_cover']) && !empty($_FILES['business_image_cover'])){
            $file_2 = $_FILES['business_image_cover'];
            if ($file['error'] > 0) {
                $this->error204('Image conver update failed');
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
                        $this->error204('Image conver update failed');
                        die;
                    }
                } else {
                    $this->error204('The conver is not in the correct format: jpeg, jpg, png');
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
            }
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

            $this->success200(array('business_id' => $flag), $message);
            die;
        }else {
            $this->error204('Business profile creation failed');
            die;
        }
    }

    private function validateBusiness($postData) {
        if(empty($postData['service_id']) && $postData['service_id'] < 0) {
            $this->error204('Please select service');
            die;
        }
        if(empty($postData['business_name'])) {
            $this->error204('Please enter business name');
            die;
        }
        if(empty($postData['business_slogan'])) {
            $this->error204('Please enter business slogan');
            die;
        }
        if(!checkemail($postData['business_email'])) {
            $this->error204('Email not exist');
            die;
        }
        if(empty($postData['business_address'])) {
            $this->error204('Please enter business address');
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
                    $this->error204('Business profile does not exist');
                    die;
                }
                $arrPhotos = [];
                foreach($_FILES['photos']['name'] as $i => $name) {
                    // now $name holds the original file name
                    $tmp_name = $_FILES['photos']['tmp_name'][$i];
                    $error = $_FILES['photos']['error'][$i];
                    if ($error > 0) {
                        $this->error204('Avatar update failed');
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
                            $this->error204('Avatar update failed');
                            die;
                        }
                    } else {
                        $this->error204('The image is not in the correct format: jpeg, jpg, png');
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
                        $this->error204('Image upload failed');
                        die;
                    }
                } else {
                    $this->error204('Please add pictures');
                    die;
                }
            } else {
                $this->error204('Business profile does not exist');
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
                    $this->error204('Business profile does not exist');
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
                $this->error204('Business profile does not exist');
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

    private function createOrUpdateCoupon($couponId = 0) {
        try {
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostApi(array('business_id', 'coupon_subject', 'coupon_amount', 'coupon_description', 'start_date', 'end_date'));
            $this->load->model(array('Mcoupons', 'Mbusinessprofiles'));
            
            if ($postData['business_id'] > 0) {
                $checkExit = $this->Mbusinessprofiles->countRows(array('customer_id' => $customer['customer_id'], 'id' => $postData['business_id']));
                if($checkExit <= 0) {
                    $this->error204('Business profile does not exist');
                    die;
                }
               
                if(empty($postData['coupon_subject']) || $postData['coupon_subject'] == ""){
                    $this->error204('Coupon subject is required');
                    die;
                }
                $postData['start_date'] = date("Y-m-d", strtotime($postData['start_date']));
                $postData['end_date'] = date("Y-m-d", strtotime($postData['end_date']));
                $currentDay = strtotime(date('Y-m-d'));

                if(strtotime($postData['start_date']) < $currentDay || strtotime($postData['end_date']) < $currentDay){
                    $this->error204('Please select date in present or future');
                    die;
                }
                if(strtotime($postData['start_date']) > strtotime($postData['end_date'])){
                    $this->error204('Please select different date');
                    die;
                }

                if(empty($postData['coupon_amount']) || $postData['coupon_amount'] == 0){
                    $this->error204('Amount of coupon must be larger than 0');
                    die;
                }
                if(isset($_FILES['coupon_image']) && !empty($_FILES['coupon_image'])){
                    $file = $_FILES['coupon_image'];
                    if ($file['error'] > 0) {
                        $this->error204('Avatar update failed');
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
                                $this->error204('Avatar update failed');
                                die;
                            }
                        } else {
                            $this->error204('The image is not in the correct format: jpeg, jpg, png');
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
                    $this->error204('Creating coupon failed');
                    die;
                }
            } else {
                $this->error204('Business profile does not exist');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

   
}