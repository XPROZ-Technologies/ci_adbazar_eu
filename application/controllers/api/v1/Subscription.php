<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
    }

    public function update() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'payment_id', 'subscription_id', 'token', 'ba_token', 'status'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: '.$this->lang->line('not_transmitted'));
                die;
            }
            if(!isset($postData['payment_id'])) {
                $this->error204('payment_id: '.$this->lang->line('not_transmitted'));
                die;
            }
            if(!isset($postData['subscription_id'])) {
                $this->error204('subscription_id: '.$this->lang->line('not_transmitted'));
                die;
            }
            if(!isset($postData['token'])) {
                $this->error204('token: '.$this->lang->line('not_transmitted'));
                die;
            }
            if(!isset($postData['ba_token'])) {
                $this->error204('ba_token: '.$this->lang->line('not_transmitted'));
                die;
            }
            if(empty($postData['payment_id'])) {
                $this->error204('payment_id: '.$this->lang->line('is_not_empty'));
                die;
            }
            if(empty($postData['subscription_id'])) {
                $this->error204('subscription_id: '.$this->lang->line('is_not_empty'));
                die;
            }
            if(empty($postData['token'])) {
                $this->error204('token: '.$this->lang->line('is_not_empty'));
                die;
            }
            if(empty($postData['ba_token'])) {
                $this->error204('ba_token: '.$this->lang->line('is_not_empty'));
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mbusinesspayments', 'Mpaymentplans'));
            $business = $this->Mbusinessprofiles->get($postData['business_id']);
            if(empty($business) || (!empty($business) && $business['customer_id'] != $customer['customer_id'] && $business['business_status_id'] <= 0)) {
                $this->error204($this->lang->line('business_does_not_belong_to_this_customer'));
                die;
            }
            $businessPaymentId = $this->Mbusinesspayments->getFieldValue(array('id' => $postData['payment_id'], 'business_profile_id' => $postData['business_id']), 'id', 0);
            if($businessPaymentId == 0) {
                $this->error204($this->lang->line('payment_does_not_belong_to_this_business'));
                die;
            }
            
            $flag = $this->Mbusinesspayments->save(array('payment_status_id' => STATUS_ACTIVED), $businessPaymentId);
           
            if ($flag > 0) {
                
                $dataUpdate = array(
                    'subscription_id' => $postData['subscription_id'],
                    'token' => $postData['token'],
                    'ba_token' => $postData['ba_token'],
                    'payment_status_id' => $postData['status'],
                    'is_annual_payment' => 1,
                    'updated_at' => getCurentDateTime(),
                );
                $paymentPlan = $this->Mpaymentplans->get($business['plan_id']);
                if($paymentPlan) {
                    if($paymentPlan['plan_type_id'] == 1) {
                        if(empty($business['expired_date']) || $business['expired_date'] == '0000-00-00 00:00:00') {
                            $dataUpdate['expired_date'] = date('Y-m-d H:i:s',strtotime('+30 days'));
                        } else {
                            $dataUpdate['expired_date'] =  date('Y-m-d H:i:s',strtotime('+30 days',strtotime($business['expired_date'])));
                        }
                    } else {
                        if(empty($business['expired_date']) || $business['expired_date'] == '0000-00-00 00:00:00') {
                            $dataUpdate['expired_date'] = date('Y-m-d H:i:s',strtotime('+365 days'));
                        } else {
                            $dataUpdate['expired_date'] = date('Y-m-d H:i:s',strtotime('+365 days',strtotime($business['expired_date'])));
                        }
                    }
                }
                
               // nếu plan_type_id =1  30 , 2: 365
                $this->Mbusinessprofiles->save($dataUpdate, $business['id']);

                $invoice_url = $this->create_invoice_pdf($business['id']);

                $customerInfo = $this->Mcustomers->get($customer['customer_id']);

                $this->Mbusinesspayments->save(array('invoice_url' => $invoice_url), $businessPaymentId);

                $dataEmail = array(
                    'name' => $customerInfo['customer_first_name'],
                    'email_to' => $customerInfo['customer_email'],
                    'email_to_name' => $customerInfo['customer_first_name'],
                    'business_name' => $this->Mbusinessprofiles->getNameById($business['id']),
                    'attach_file' => $invoice_url
                );
                $this->Memailqueue->createEmail($dataEmail, 13);

                $this->success200(array('business_id' => $flag), $this->lang->line('payment_success'));
                die;
            } else {
                $this->error204($this->lang->line('payment_failed'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function cancel() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: '.$this->lang->line('not_transmitted'));
                die;
            }
            $this->load->model(array('Mbusinessprofiles'));
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id'], 'business_status_id >' => 0), 'id', 0);
            if($checkExit == 0) {
                $this->error204($this->lang->line('business_does_not_belong_to_this_customer'));
                die;
            }
            $dataUpate = array(
                'subscription_id' => 0,
                'token' => '',
                'ba_token' => '',
                'updated_at' => getCurentDateTime()
            );
            $flag = $this->Mbusinessprofiles->save($dataUpdate, $checkExit);
            if ($flag > 0) {
                $this->success200(array('business_id' => $flag), $this->lang->line('successfully_cancelled_the_package'));
                die;
            } else {
                $this->error204($this->lang->line('unsuccessful_package_cancellation'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function update_auto_renew() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'is_annual_payment'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: '.$this->lang->line('not_transmitted'));
                die;
            }
           
            if(!in_array($postData['is_annual_payment'], [0, 1])) {
                $this->error204($this->lang->line('is_annual_payment_must_be_0_or_1'));
                die;
            }
            $this->load->model(array('Mbusinessprofiles'));
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id'], 'business_status_id >' => 0), 'id', 0);
            if($checkExit == 0) {
                $this->error204($this->lang->line('business_does_not_belong_to_this_customer'));
                die;
            }
            $dataUpdate = array(
                'is_annual_payment' => $postData['is_annual_payment'],
                'updated_at' => getCurentDateTime()
            );
            $flag = $this->Mbusinessprofiles->save($dataUpdate, $checkExit);
            if ($flag > 0) {
                $message = $this->lang->line("turn_off_auto_renew_success");
                if($postData['is_annual_payment'] == 1) {
                    $message = $this->lang->line("turn_on_auto_renew_success");
                }
                $this->success200(array('business_id' => $flag), $message);
                die;
            } else {
                $this->error204($this->lang->line('update_auto_renew_failed'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function info() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: '.$this->lang->line('not_transmitted'));
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mpaymentplans'));
            $business = $this->Mbusinessprofiles->get($postData['business_id']);
            if(empty($business) || (!empty($business) && $business['customer_id'] != $customer['customer_id'] && $business['business_status_id'] <= 0)) {
                $this->error204($this->lang->line('business_does_not_belong_to_this_customer'));
                die;
            }
            if(!empty($business['plan_id'])) {
                $paymentPlan = $this->Mpaymentplans->get($business['plan_id']);
            }else{
                $paymentPlan = $this->Mpaymentplans->get(1);
            }
            
            $expiredDay = 0;
            if(!empty($business['expired_date'])) {
                $datediff = strtotime($business['expired_date']) - strtotime(getCurentDateTime());
                $expiredDay = round($datediff / (60 * 60 * 24));
            }

            $paymentStatusId = 2;
            
            $expiredDate = strtotime(ddMMyyyy($business['expired_date'], 'Y-m-d'));
            $currentDate = strtotime(date('Y-m-d'));
            $isExpired = 0;
            if($currentDate > $expiredDate && !empty($business['expired_date'])) {
                $isExpired = 1;
            }

            if($business['is_trial'] == 1){
                $paymentStatusId = 2;
                $expiredDay = dateDifference(date('Y-m-d'), ddMMyyyy($business['expired_date'], 'Y-m-d'));
            }

            if($isExpired == 1 && $business['is_trial'] == 0){
                $paymentStatusId = 4;
            }else if($isExpired == 0 && $business['is_trial'] == 0 && $business['plan_id']){
                $paymentStatusId = 2;
            }

            if($business['business_status_id'] == 3 || $isExpired == 1 || $business['plan_id'] == 0){
                $paymentStatusId = 1;
            }

            $hasCancel = 0;
            $hasRenewal = 0;
            if($business['business_status_id'] == 2 && !empty($business['subscription_id']) && $isExpired == 0){ 
                $hasRenewal = 1;
                $hasCancel = 1;
            }

            $hasSwitch = 0;
            if($business['plan_id'] != 0){
                $hasSwitch = 1;
            }


            $dataReturn = array(
                "free_trial" => !empty($business['is_trial']) ? $business['is_trial'] : 0,
                "plan_amount" => isset($paymentPlan['plan_amount']) ? intval($paymentPlan['plan_amount']) : 0,
                "plan_type_id" => isset($paymentPlan['plan_type_id']) ? $paymentPlan['plan_type_id'] : 0,
                "plan_currency_id" => isset($paymentPlan['plan_currency_id']) ? $paymentPlan['plan_currency_id'] : 0,
                "amount_per_month" => isset($paymentPlan['amount_per_month']) ? $paymentPlan['amount_per_month'] : 0,
                "plan_save" => isset($paymentPlan['plan_save']) ? $paymentPlan['plan_save'] : 0,
                "plan_vat" => isset($paymentPlan['plan_vat']) ? $paymentPlan['plan_vat'] : 0,
                'expired_date' => !empty($business['expired_date']) ? ddMMyyyy($business['expired_date'], 'Y/m/d') : '',
                'expired_day' => $expiredDay,
                'payment_status_id' => $paymentStatusId,
                'has_cancel' => $hasCancel,
                'has_switch' => $hasSwitch,
                'has_renewal' => $hasRenewal,
                'renewal_status_id' => $business['is_annual_payment']
            );
            $this->success200($dataReturn);
            die;
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}