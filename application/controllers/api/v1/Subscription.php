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

                $invoice_url = $this->create_invoice_pdf($business_id);

                $customerInfo = $this->Mcustomers->get($customer['customer_id']);

                $sendMail = $this->sendMailFile('info@adbazar.eu', 'ADBazar.eu', $customerInfo['customer_email'], $customerInfo['customer_first_name'], 'Payment invoice', $invoice_url);

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
            $paymentPlan = $this->Mpaymentplans->get($business['plan_id']);
            $expiredDay = 0;
            if(!empty($business['expired_date'])) {
                $datediff = strtotime($business['expired_date']) - strtotime(getCurentDateTime());
                $expiredDay = round($datediff / (60 * 60 * 24));
            }
            $dataReturn = array(
                "plan_type_id" => isset($paymentPlan['plan_type_id']) ? $paymentPlan['plan_type_id'] : 0,
                "plan_currency_id" => isset($paymentPlan['plan_currency_id']) ? $paymentPlan['plan_currency_id'] : 0,
                "amount_per_month" => isset($paymentPlan['amount_per_month']) ? $paymentPlan['amount_per_month'] : 0,
                "plan_save" => isset($paymentPlan['plan_save']) ? $paymentPlan['plan_save'] : 0,
                "plan_vat" => isset($paymentPlan['plan_vat']) ? $paymentPlan['plan_vat'] : 0,
                'expired_date' => !empty($business['expired_date']) ? ddMMyyyy($business['expired_date'], 'Y/m/d') : '',
                'expired_day' => $expiredDay

            );
            $this->success200($dataReturn);
            die;
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}