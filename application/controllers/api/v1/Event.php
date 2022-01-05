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
            $pageCount = 0;
            $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
            $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;
           
            if($rowCount > 0){
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $events = $this->Mevents->getListInApi($postData, $perPage, $page);
                for($i = 0; $i < count($events); $i++){
                    $currentDate = strtotime(getCurentDateTime());
                    $startDate = strtotime($events[$i]['start_date'].' '.$events[$i]['start_time'].":00");
                    $endDate = strtotime($events[$i]['end_date'].' '.$events[$i]['start_time'].":00");
                    //  1: Upcoming : start_date start_time > current_date
                    if($startDate > $currentDate) {
                        $events[$i]['event_status_id'] = 1;
                    } else if ($startDate < $currentDate && $currentDate < $endDate) {
                        // 2: Ongoing: start_date start_time < current_date < end_date end_time
                        $events[$i]['event_status_id'] = 2;
                    } else if ($endDate < $currentDate) {
                        // 3: Expired: end_date end_time < current_date
                        $events[$i]['event_status_id'] = 3;
                    } else {
                        // 4: Cancelled: event_status_id = 1
                        $events[$i]['event_status_id'] = 4;
                    }
                    $events[$i]['event_image'] = !empty($events[$i]['event_image']) ? base_url(EVENTS_PATH.$events[$i]['event_image']) : '';
                }
            }
           
            $businessInfo = (object) [];
           
            if(isset($postData['business_id']) && intval($postData['business_id']) > 0) {
                
                $business = $this->Mbusinessprofiles->get($postData['business_id']);
                
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
                $this->error204($this->lang->line('incorrect_information'));
                die;
            }
            $this->loadModel(array('Mevents', 'Mcustomerevents'));
            if($customer['customer_id'] == 0) {
                $checkExit = $this->Mcustomerevents->getFieldValue(array('email' => $postData['customer_email']), 'id', 0);
                if($checkExit > 0) {
                    $this->error204($this->lang->line('this_email_has_registered_to_participate_in_the_event'));
                    die;
                }
            }
            
            if(intval($postData['customer_id']) > 0) {
                $customerCouponId = $this->Mcustomerevents->getFieldValue(array('customer_id' => $postData['customer_id'], 'event_id' => $postData['event_id'], 'customer_event_status_id >' => 0), 'id', 0);
                if ($customerCouponId > 0) {
                    $this->error204($this->lang->line('you_have_joined_this_event'));
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
                    $this->success200('', $this->lang->line('you_have_been_successfully_registered_for_the_event!'));
                    die;
                } else {
                    $this->error204($this->lang->line('event_has_expired'));
                    die;
                }
            } else {
                if (empty($postData['event_id']) || empty($postData['customer_first_name']) || empty($postData['customer_last_name']) || empty($postData['customer_email'])) {
                    $this->error204($this->lang->line('incorrect_information'));
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
                    $this->success200('', $this->lang->line('you_have_been_successfully_registered_for_the_event!'));
                    die;
                } else {
                    $this->error204($this->lang->line('event_has_expired'));
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
                $this->error204($this->lang->line('incorrect_information'));
                die;
            }
            $this->load->model('Mevents');
            $detail = $this->Mevents->getDetailEvent($postData);
            if(count($detail) > 0) {
                $detail = $detail[0];
                $detail['event_image'] = !empty($detail['event_image']) ? base_url(EVENTS_PATH.$detail['event_image']) : '';
                $detail['business_info'] = array(
                    'id' => $detail['business_profile_id'],
                    'business_name' => $detail['business_name'],
                    'business_avatar' => !empty($detail['business_avatar']) ? base_url(BUSINESS_PROFILE_PATH.$detail['business_avatar']) : '',
                    'business_address' => $detail['business_address'],
                    'business_phone' => $detail['business_phone']
                );
                $detail['joined_event'] = 2;
                if(!empty($detail['customer_id']) && intval($detail['customer_id']) == intval($postData['customer_id'])) {
                    $detail['joined_event'] = 1;
                }
                unset($detail['business_profile_id'], $detail['customer_id'], $detail['business_avatar'], $detail['business_address'], $detail['business_phone']);
                $this->success200($detail);
            } else {
                $this->error204($this->lang->line('no_data'));
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
            $pageCount = 0;
            $events = [];
            $perPage = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;
            $page = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;
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
                $arrCalendar[] = ddMMyyyy($calendar['end_date'], 'Y/m/d');
                
            }
           
            $this->success200(array(
                'dates' => $arrCalendar
            ));
        } catch (Exception $e) {
            $this->error500($e->getMessage());
        }
    }

    public function event24h() {
        // $date24h = date('Y-m-d H:i',strtotime('+24 hours')); // lấy ngày hiện tại
        $date24h = date('Y-m-d H:i',strtotime('+24 hours', strtotime('2021-11-17 06:58'))); // truyền theo ngày mong muốn
        $dateBefore = date('Y-m-d H:i',strtotime('-5 minutes', strtotime($date24h) ));
        $dateAfter = date('Y-m-d H:i',strtotime('+5 minutes', strtotime($date24h) ));

        $this->load->model(array('Mevents'));
        $list = $this->Mevents->event24h($dateBefore, $dateAfter);
        $this->success200($list);
        die;

    }

}