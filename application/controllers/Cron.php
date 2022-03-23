<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        //$this->lang->load('login', $this->language);


    }

    public function testMail(){
        $flag = $this->sendMail('contact@adbazar.eu', 'ADB', 'levanhoanhtt@gmail.com', 'Hoan', 'Test', 'Test');
        echo $flag ? 1 : 0;
    }

    public function cronjob() {
        $this->loadModel(array('Mconfigs', 'Memailqueue'));

        $emails = $this->Memailqueue->getBy(array('is_send' => 0), false, 'created_at','', 10, 0, 'asc');

        foreach($emails as $itemEmail){
            if(empty($itemEmail['attach_file'])) {
                $resultSend  = $this->sendMail($itemEmail['email_from'], $itemEmail['email_from_name'], $itemEmail['email_to'], $itemEmail['email_to_name'], $itemEmail['email_subject'], $itemEmail['email_content']);
            } else {
                $resultSend = $this->sendMailFile($itemEmail['email_from'], $itemEmail['email_from_name'], $itemEmail['email_to'], $itemEmail['email_to_name'], $itemEmail['email_subject'],  $itemEmail['email_content'], $itemEmail['attach_file']);
            } 

            if($resultSend){
                $this->Memailqueue->save(array(
                    'is_send' => STATUS_ACTIVED,
                    'updated_at' => getCurentDateTime()
                ), $itemEmail['id']);
            }else{
                $this->Memailqueue->save(array(
                    'is_send' => 1,
                    'updated_at' => getCurentDateTime()
                ), $itemEmail['id']);
            }
        }
        
    }

    /**
     * Notify customer 3 days before expired
     */
    public function checkBusinessNextExpired() {
        $this->loadModel(array('Mconfigs', 'Mbusinessprofiles', 'Mcustomers'));

        $expiredDate = date('Y-m-d', strtotime('+3 days'));

        $dataQuery = array(
            'expired' => $expiredDate,
            'business_status_id' => STATUS_ACTIVED,
            'is_annual_payment' => 0
        );

        $listBusiness = $this->Mbusinessprofiles->search($dataQuery);

        if(!empty($listBusiness)){
            foreach($listBusiness as $item){
                $customerInfo = $this->Mcustomers->get($item['customer_id']);
                //send email here
                /**
                 * Save Email
                 */
                $this->load->model('Memailqueue');
                $dataEmail = array(
                    'name' => $customerInfo['customer_first_name'],
                    'email_to' => $customerInfo['customer_email'],
                    'email_to_name' => $customerInfo['customer_first_name'],
                    'business_name' => $item['business_name'],
                    'action' => base_url('business-management/'.$item['business_url'] . '/subscriptions'),
                    'time' => ddMMyyyy($item['expired_date'], 'd-m-Y')
                );
                $emailResult = $this->Memailqueue->createEmail($dataEmail, 6);
                /**
                 * END. Save Email
                 */
            }
        }
    }


    /**
     * Check and change status of Business Profile
     */
    public function checkPaymentBusiness() {
        $this->loadModel(array('Mconfigs', 'Mbusinessprofiles', 'Mpaymentplans', 'Mcustomers'));

        $expiredDate = date('Y-m-d');

        $dataQuery = array(
            'expired' => $expiredDate,
            'business_status_id' => STATUS_ACTIVED,
            'is_annual_payment' => 1
        );

        $listBusiness = $this->Mbusinessprofiles->search($dataQuery);

        if(!empty($listBusiness)){
            foreach($listBusiness as $item){
                //check and change status
                $data = array(
                    'subscriptionId' => $item['subscription_id'],
                    'startTime' => date('Y-m-d').'T00:00:00Z',
                    'endTime' => date('Y-m-d').'T23:59:59Z',
                );

                /**
                 * check transaction
                 */
                $isSuccess = false;
                $data = $this->checkPaymentSubscription($data);
                $transactions = $data['transactions'];
                $countTransaction = count($transactions);
                if($countTransaction > 0){
                    $countTransaction = $countTransaction - 1;
                    if(isset($transactions[$countTransaction])){
                        $payment = $transactions[$countTransaction];
                        if($payment['status'] == 'COMPLETED') {
                            $tmpTimePayment = date('Y-m-d H:i:s', strtotime($payment['time']));
                            $timePayment = strtotime($tmpTimePayment);
                            $startTimeCheck = strtotime("-1 day");
                            $endTimeCheck = strtotime("+1 day");
                            if( $startTimeCheck <= $timePayment && $endTimeCheck >= $timePayment){
                                $isSuccess = true;
                            }
                        }
                    }
                }

                $customerInfo = $this->Mcustomers->get($item['customer_id']);

                /**
                 * Extend expired date
                 */
                if($isSuccess) {
                    $planId = $item['plan_id'];

                    $planType = $this->Mpaymentplans->getFieldValue(array('id' => $planId), 'plan_type_id', 0);
                    
                    $expiredDate = strtotime("+30 day", strtotime($item['expired_date']));
                    if($planType == 2) {
                        $expiredDate = strtotime("+1 year", strtotime($item['expired_date']));
                    }

                    //update
                    $busiessId = $this->Mbussinessprofiles->save(array('expired_date' => $expiredDate), $item['id']);


                    /**
                     * Save Email
                     */
                    $this->load->model('Memailqueue');
                    $dataEmail = array(
                        'name' => $customerInfo['customer_first_name'],
                        'email_to' => $customerInfo['customer_email'],
                        'email_to_name' => $customerInfo['customer_first_name'],
                        'business_name' => $item['business_name'],
                        'url' => base_url('business-management/'.$item['business_url'] . '/subscriptions')
                    );
                    $emailResult = $this->Memailqueue->createEmail($dataEmail, 8);
                    /**
                     * END. Save Email
                     */
                }else {
                    //cancel this subscription
                    $this->cancelSubscription(array('subscriptionId' => $item['subscription_id'], 'reasonCancel' => 'Payment not recurring'));
                    
                    //update
                    $busiessId = $this->Mbussinessprofiles->save(array('is_annual_payment' => 0, 'subscription_id' => ''), $item['id']);
                
                    /**
                     * Save Email
                     */
                    $this->load->model('Memailqueue');
                    $dataEmail = array(
                        'name' => $customerInfo['customer_first_name'],
                        'email_to' => $customerInfo['customer_email'],
                        'email_to_name' => $customerInfo['customer_first_name'],
                        'business_name' => $item['business_name'],
                        'url' => base_url('business-management/'.$item['business_url'] . '/subscriptions')
                    );
                    $emailResult = $this->Memailqueue->createEmail($dataEmail, 7);
                    /**
                     * END. Save Email
                     */
                }
            }
        }
    }
    

    public function sendNoti(){
        $this->loadModel(array('Mnotificationusers', 'Mcustomertokens', 'Musertokens', 'Morders'));
        $select = 'notificationusers.NotificationUserId, notificationusers.UserId, notificationusers.UserTypeId,
        notifications.Title, notifications.Message, notifications.NotificationTypeId, notifications.ItemId';
        $listNotifications = $this->Mnotificationusers->search(array('IsSend' => 0), 20, 1, $select, 'NotificationUserId ASC', array('notification'));
        //echo '<pre>';print_r($listNotifications);exit;
        if (!empty($listNotifications)) {
            foreach ($listNotifications as $notification) {
                $model = $notification['UserTypeId'] == 1 ? 'Mcustomertokens' : 'Musertokens';
                $field_name = $notification['UserTypeId'] == 1 ? 'CustomerId' : 'UserId';
                $tokens = $this->$model->getListFieldValue(array($field_name => $notification['UserId']), 'DeviceToken');
                if (!empty($tokens)) {
                    $flag = $this->Mnotificationusers->save(array('IsSend' => 1), $notification['NotificationUserId']);
                    if ($flag) {
                        foreach ($tokens as $token) {
                            $addOn = array(
                                'NotificationTypeId' => $notification['NotificationTypeId'], 
                                'ItemId' => $notification['ItemId']
                            );
                            if(intval($notification['NotificationTypeId']) == 1){
                                $orderStatusId = $this->Morders->getListFieldValue(array('OrderId' => $notification['ItemId']), 'OrderStatusId');
                                $orderType = 0;
                                if(in_array($orderStatusId, array(4,5))){
                                    $orderType = 2;
                                }
                                if(in_array($orderStatusId, array(1,2,3))){
                                    $orderType = 1;
                                }
                                $addOn['OrderType'] = $orderType;
                            }
                            sendNotification($token, $notification['Title'], $notification['Message'], $addOn);
                            //log_message('error', $message);
                        }

                        $message =  getCurentDateTime() . ': Notification - '. $model .' - '. $notification['NotificationUserId'] . ': Send success';
                        echo $message. PHP_EOL;
                        log_message('error', $message);
                    }else{
                        $this->Mnotificationusers->save(array('IsSend' => 3), $notification['NotificationUserId']);
                        $message = getCurentDateTime() . ': Notification - '. $model .' - '. $notification['NotificationUserId'] . ': '. ERROR_COMMON_MESSAGE;
                        log_message('error', $message);
                        echo $message . PHP_EOL;
                    }
                } else {
                    $this->Mnotificationusers->save(array('IsSend' => 3), $notification['NotificationUserId']);
                    $message = getCurentDateTime() . ': Notification - '. $model .' - '. $notification['NotificationUserId'] . ': Không có DeviceToken';
                    log_message('error', $message);
                    echo $message . PHP_EOL;
                }
            }
        } else {
            $message = 'NotificationUser: Không có dữ liệu';
            log_message('error', $message);
            echo $message . PHP_EOL;
        }
    }

    public function testNotification(){
        try {
            $postData = $this->arrayFromPostRawJson(array('DeviceToken', 'NotificationTypeId', 'ItemId'));

            $DeviceToken = trim($this->input->get('DeviceToken'));
            $NotificationTypeId = trim($this->input->get('NotificationTypeId'));
            $ItemId = trim($this->input->get('ItemId'));
            
            sendNotification($postData['DeviceToken'], "Test title noti firebase".date('Y/m/d'), "Message noti firebase", array('NotificationTypeId' => $postData['NotificationTypeId'], 'ItemId' => $postData['ItemId']));
        } catch (\Throwable $th) {
            
            echo $message . PHP_EOL;
        }
    }

    /**
     * Run cron each 10 minutes
     */

    public function event24h() {
        $date24h = date('Y-m-d H:i',strtotime('+24 hours')); // lấy ngày hiện tại
        // $date24h = date('Y-m-d H:i',strtotime('+24 hours', strtotime('2021-11-17 06:58'))); // truyền theo ngày mong muốn
        $dateBefore = date('Y-m-d H:i',strtotime('-5 minutes', strtotime($date24h) ));
        $dateAfter = date('Y-m-d H:i',strtotime('+5 minutes', strtotime($date24h) ));

        $this->load->model(array('Mevents', 'Mcustomernotifications', 'Memailqueue', 'Mbusinessprofiles', 'Mcustomers'));
        $list = $this->Mevents->event24h($dateBefore, $dateAfter);
        
        for($i = 0; $i < count($list); $i++) {
            $itemEvent = $list[$i];
            // Get all customer joined event
            $customers = $this->Mcustomerevents->getBy(array('event_id' => $itemEvent['id'], 'customer_event_status_id' => STATUS_ACTIVED));
            if(count($customers) > 0) {
                for($j = 0; $j < count($customers); $j++) {
                    $itemCustomer = $customers[$j];

                    // Only send noti to register customer
                    if($itemCustomer['customer_id'] > 0) {
                        // Send noti
                        $dataNoti = array(
                            'notification_type' => 2, //Event will start next 24h
                            'customer_id'   => $itemCustomer['customer_id'],
                            'business_id'   => $itemEvent['business_profile_id'],
                            'item_id'   => $itemEvent['id'],
                            'notification_status_id'  => STATUS_ACTIVED,
                            'created_at' => getCurentDateTime()
                        );
                        $notificationId = $this->Mcustomernotifications->save($dataNoti);
                    }

                    $customerInfo = $this->Mcustomers->get($itemCustomer['customer_id']);
                    $customer_name = !empty($customerInfo['customer_first_name']) ? $customerInfo['customer_first_name'] : $customerInfo['customer_email'];
                    // Send email
                    $dataEmail = array(
                        'name' => $customer_name,
                        'email_to' => $customerInfo['customer_email'],
                        'email_to_name' => $customer_name,
                        'event_subject' => $itemEvent['event_subject'],
                        'business_name' => $this->Mbusinessprofiles->getNameById($itemEvent['business_profile_id']),
                        'url' => site_url('event/'.makeSlug($itemEvent['event_subject']).'-'.$itemEvent['id'].'.html')
                    );
                    $this->Memailqueue->createEmail($dataEmail, 9);
                }
            }
        }
    }

    /**
     * Run cron each minutes
     */

    public function reservation15m() {
        $dateStart = date('Y-m-d H:i',strtotime('+15 minutes', strtotime(date('Y-m-d H:i')) ));

        $this->load->model(array('Mcustomerreservations', 'Mcustomernotifications'));
        $list = $this->Mcustomerreservations->reservation15m($dateStart);
        if(count($list) > 0) {
            for($i = 0; $i < count($list); $i++) {
                $dateArrived =  date('Y-m-d H:i',strtotime($list[$i]['date_arrived'].' '.$list[$i]['time_arrived']));
                $currentDate = date('Y-m-d H:i',strtotime('-15 minutes', strtotime($dateArrived) ));
                $list[$i]['current_date'] = $currentDate;

                $itemReservation = $list[$i];

                // Send noti
                $dataNoti = array(
                    'notification_type' => 5, //Reservation will start in next 15p
                    'customer_id'   => $itemReservation['customer_id'],
                    'business_id'   => $itemReservation['business_profile_id'],
                    'item_id'   => $itemReservation['id'],
                    'notification_status_id'  => STATUS_ACTIVED,
                    'created_at' => getCurentDateTime()
                );
                $notificationId = $this->Mcustomernotifications->save($dataNoti);
            }
        }
        $this->success200($list);
        die;
    }

    public function sendNotificationApp()
    {
        try {
            $this->getLanguageApiNotify(true, 1);

            $this->loadModel(array('Mbusinessprofiles', 'Mcustomernotifications', 'Mcustomers', 'Mcustomerreservations'));


            $order_by = 'DESC';

            $searchData = array(
                'is_send' => 0
            );
            
            $notiData = $this->getNotificationLists($searchData, 10, 1);
            // echo "<pre>";print_r($notiData);die;
            if(!empty($notiData)) {
                for($i = 0; $i < count($notiData); $i++) {

                    $languageId = $this->Mcustomers->getFieldValue(array('id' => $notiData[$i]['customer_id']), 'language_id', 3);

                    if($languageId == 0) $languageId = 3;
                    
                    $notiItem = array(
                        "id" => $notiData[$i]['id'],
                        "title" => $notiData[$i]['text'],
                        "created_date" => ddMMyyyy($notiData[$i]['created_at'], 'Y-m-d H:i'),
                        "image" => base_url($notiData[$i]['image']),
                        "message" => $notiData[$i]['text'],
                        "item_id" => $notiData[$i]['item_id'],
                        "business_id" => $notiData[$i]['business_id'],
                        "notification_type_id" => $notiData[$i]['notification_type'],
                        "is_read" => $notiData[$i]['notification_status_id']
                    );

                    //send to app
                    $deviceToken = $this->Mcustomers->getFieldValue(array('id' => $notiData[$i]['customer_id']), 'device_token', "");
                    // echo "<pre>";print_r($notiData[$i]);die;
                    if(!empty($deviceToken)) {
                        $data = array(
                            "id" => $notiItem['id'],
                            "item_id" => $notiItem['item_id'],
                            "business_id" => $notiItem['business_id'],
                            "notification_type_id" => $notiItem['notification_type_id'],
                        );
                        sendNotificationExpo($deviceToken, $notiItem['title'], $notiItem['message'], $data);
                    }

                    $this->Mcustomernotifications->updateBy(
                        array(
                            'id' => $notiItem['id']
                        ),
                        array(
                            'is_send' => 1    
                        )
                    );
                }
            }else{
                echo "empty";
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function test_invoice() {
        $business_id = 100;
        $invoice_url = $this->create_invoice_pdf($business_id);

        $sendMail = $this->sendMailFile('info@adbazar.eu', 'ADBazar.eu', 'huongthien1993@gmail.com', 'Thien Nguyen', 'Payment invoice', "email content", $invoice_url);

        if($sendMail) {
            echo "oke";
        }else{
            echo "failed";
        }
    }
}