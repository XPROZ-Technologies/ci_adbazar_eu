<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language-id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
    }

    public function list_home() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData['api'] = true;
            $postData['customer_id'] = $customer['customer_id'];
            $this->loadModel(array('Mevents', 'Mconfigs'));
            $configs = $this->Mconfigs->getListMap(1, $this->languageId);
            $events = $this->Mevents->getListHome($postData);
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

    public function list() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('search_text', 'page_id', 'per_page', 'selected_date', 'business_id', 'order_by'));
            if(empty($postData['selected_date'])) $postData['selected_date'] = ddMMyyyy(date('Y-m-d'), 'Y-m-d');
            else $postData['selected_date'] = ddMMyyyy($postData['selected_date'], 'Y-m-d');
            $postData['api'] = true;
            $postData['customer_id'] = $customer['customer_id'];
            
            $this->loadModel(array('Mevents', 'Mconfigs', 'Mbusinessprofiles'));
            $rowCount = $this->Mevents->getCountInApi($postData);
            $events = [];
            $perPage = intval($postData['per_page']) < 1 ? DEFAULT_LIMIT :$postData['per_page'];
            $pageCount = 0;
            $page = $postData['page_id'];
            if($rowCount > 0){
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $events = $this->Mevents->getListInApi($postData, $perPage, $page);
                for($i = 0; $i < count($events); $i++){
                    $events[$i]['event_image'] = !empty($events[$i]['event_image']) ? base_url(EVENTS_PATH.$events[$i]['event_image']) : '';
                }
            }
            $businessInfo = (object) [];
            if(isset($postData['business_id']) && intval($postData['business_id']) > 0) {
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
            }
            $this->success200(array(
                'page_id' => $page,
                'per_page' => $perPage,
                'page_count' => $pageCount,
                'totals' => $rowCount,
                'business_info' => $businessInfo,
                'list' => $events
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function join() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('event_id', 'customer_first_name', 'customer_last_name', 'customer_email'));
            $postData['customer_id'] = $customer['customer_id'];
            if (empty($postData['event_id']) && $postData['event_id'] < 0) {
                $this->error204('Incorrect information');
                die;
            }
            $this->loadModel(array('Mevents', 'Mcustomerevents'));
            if($customer['customer_id'] == 0) {
                $checkExit = $this->Mcustomerevents->getFieldValue(array('email' => $postData['customer_email']), 'id', 0);
                if($checkExit > 0) {
                    $this->error204('This email has registered to participate in the event');
                    die;
                }
            }
            
            if(intval($postData['customer_id']) > 0) {
                $customerCouponId = $this->Mcustomerevents->getFieldValue(array('customer_id' => $postData['customer_id'], 'event_id' => $postData['event_id'], 'customer_event_status_id >' => 0), 'id', 0);
                if ($customerCouponId > 0) {
                    $this->error204('You have joined this event');
                    die;
                }
                $eventInfo = $this->Mevents->get($postData['event_id']);
                if ($eventInfo && $eventInfo['id']) {
                    //join event
                    $customerEventId = $this->Mcustomerevents->save(array(
                        'customer_id' => $postData['customer_id'],
                        'event_id' => $postData['event_id'],
                        'first_name' => $postData['customer_first_name'],
                        'last_name' => $postData['customer_last_name'],
                        'email' => $postData['customer_email'],
                        'customer_event_status_id' => STATUS_ACTIVED
                    ));
    
                    if($customerEventId > 0){
                        $this->loadModel(array('Mcustomers', 'Mbusinessprofiles'));
                        $customerInfo = $this->Mcustomers->get($postData['customer_id']);
                        
                        $businessName = $this->Mbusinessprofiles->getFieldValue(array('id' => $eventInfo['business_profile_id']), 'business_name', '');
                        /**
                         * Save Email
                         */
                        $this->load->model('Memailqueue');
                        $dataEmail = array(
                            'name' => $customerInfo['customer_first_name'],
                            'email_to' => $customerInfo['customer_email'],
                            'email_to_name' => $customerInfo['customer_first_name'],
                            'event_name' => $eventInfo['event_subject'],
                            'event_url' => base_url('event/'.makeSlug($eventInfo['event_subject']) . '-' . $eventInfo['id'].'.html'),
                            'business_name' => $businessName
                        );
                        $emailResult = $this->Memailqueue->createEmail($dataEmail, 4);
                        /**
                         * END. Save Email
                         */
                    }
                    $this->success200('', 'You have been successfully registered for the event!');
                    die;
                } else {
                    $this->error204('Event has expired');
                    die;
                }
            } else {
                if (empty($postData['event_id']) || empty($postData['customer_first_name']) || empty($postData['customer_last_name']) || empty($postData['customer_email'])) {
                    $this->error204('Incorrect information');
                    die;
                }
                //join event
                $flag = $this->Mcustomerevents->save(array(
                    'customer_id' => 0,
                    'event_id' => $postData['event_id'],
                    'first_name' => $postData['customer_first_name'],
                    'last_name' => $postData['customer_last_name'],
                    'email' => $postData['customer_email'],
                    'is_guest' => 1,
                    'customer_event_status_id' => STATUS_ACTIVED
                ));

                if($flag) {
                    $this->success200('', 'You have been successfully registered for the event!');
                    die;
                } else {
                    $this->error204('Event has expired');
                    die;
                }
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function detail() {
        try {
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('event_id'));
            $postData['customer_id'] = $customer['customer_id'];
            if (empty($postData['event_id']) && $postData['event_id'] < 0) {
                $this->error204('Incorrect information');
                die;
            }
            $this->load->model('Mevents');
            $detail = $this->Mevents->getDetailEvent($postData);
            if(count($detail) > 0) {
                $detail = $detail[0];
                $detail['event_image'] = !empty($detail['event_image']) ? base_url(COUPONS_PATH.$detail['event_image']) : '';
                $detail['business_info'] = array(
                    'id' => $detail['business_profile_id'],
                    'business_name' => $detail['business_name'],
                    'business_avatar' => !empty($detail['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$detail['business_avatar']) : '',
                    'business_address' => $detail['business_address'],
                    'business_phone' => $detail['business_phone']
                );
                $detail['joined_event'] = 0;
                if(!empty($detail['customer_id']) && intval($detail['customer_id']) == intval($postData['customer_id'])) {
                    $detail['joined_event'] = 1;
                }
                unset($detail['business_profile_id'], $detail['customer_id'], $detail['business_avatar'], $detail['business_address'], $detail['business_phone']);
                $this->success200($detail);
            } else {
                $this->error204('No data');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function customer_events() {
        try {
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('search_text', 'page_id', 'per_page'));
            $postData['api'] = true;
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model(array('Mcustomerevents'));
            $rowCount = $this->Mcustomerevents->getCountInApi($postData);
            $perPage = intval($postData['per_page']) < 1 ? DEFAULT_LIMIT :$postData['per_page'];
            $pageCount = 0;
            $page = $postData['page_id'];
            $events = [];
            if($rowCount > 0){
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $events = $this->Mcustomerevents->getListInApi($postData, $perPage, $page);
                for($i = 0; $i < count($events); $i++){
                    $events[$i]['event_image'] = !empty($events[$i]['event_image']) ? base_url(EVENTS_PATH.$events[$i]['event_image']) : '';
                }
            }
            $this->success200(array(
                'page_id' => $page,
                'per_page' => $perPage,
                'page_count' => $pageCount,
                'totals' => $rowCount,
                'list' => $events
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function calendar() {
        try {
            $customer = $this->apiCheckLogin(true);
            $this->load->model(array('Mevents'));
            $calendar = $this->Mevents->getCalendar();
            $arrCalendar = [];
            if(count($calendar) > 0) {
                $calendar = $calendar[0];
                $period = new DatePeriod(
                    new DateTime($calendar['start_date']),
                    new DateInterval('P1D'),
                    new DateTime($calendar['end_date'])
                );
                foreach ($period as $key => $value) {
                    $arrCalendar[] =  $value->format('Y/m/d');
                  
                }
                $arrCalendar[] =$calendar['end_date'];
                
            }
           
            $this->success200(array(
                'dates' => $arrCalendar
            ));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

}