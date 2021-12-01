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

    public function cronjob() {
        $this->loadModel(array('Mconfigs', 'Memailqueue'));

        $emails = $this->Memailqueue->getBy(array('is_send' => 0), false, 'created_at','', 10, 0, 'asc');

        foreach($emails as $itemEmail){
            $resultSend  = $this->sendMail($itemEmail['email_from'], $itemEmail['email_from_name'], $itemEmail['email_to'], $itemEmail['email_to_name'], $itemEmail['email_subject'], $itemEmail['email_content']);
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
    
}