<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apple extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
    }

    function verifyReceipt() {
        return json_decode('{
            "environment": "Production",
            "receipt": {
              "receipt_type": "Production",
              "adam_id": 123,
              "app_item_id": 123,
              "bundle_id": "com.adapty.sample_app",
              "application_version": "1",
              "download_id": 123,
              "version_external_identifier": 123,
              "receipt_creation_date": "2021-04-28 19:42:01 Etc/GMT",
              "receipt_creation_date_ms": "1619638921000",
              "receipt_creation_date_pst": "2021-04-28 12:42:01 America/Los_Angeles",
              "request_date": "2021-08-09 18:26:02 Etc/GMT",
              "request_date_ms": "1628533562696",
              "request_date_pst": "2021-08-09 11:26:02 America/Los_Angeles",
              "original_purchase_date": "2017-04-09 21:18:41 Etc/GMT",
              "original_purchase_date_ms": "1491772721000",
              "original_purchase_date_pst": "2017-04-09 14:18:41 America/Los_Angeles",
              "original_application_version": "1",
              "in_app": [
                {
                  "quantity": "1",
                  "product_id": "basic_subscription_1_month",
                  "transaction_id": "1000000831360853",
                  "original_transaction_id": "1000000831360853",
                  "purchase_date": "2021-04-28 19:41:58 Etc/GMT",
                  "purchase_date_ms": "1619638918000",
                  "purchase_date_pst": "2021-04-28 12:41:58 America/Los_Angeles",
                  "original_purchase_date": "2021-04-28 19:41:58 Etc/GMT",
                  "original_purchase_date_ms": "1619638918000",
                  "original_purchase_date_pst": "2021-04-28 12:41:58 America/Los_Angeles",
                  "expires_date": "2021-05-05 19:41:58 Etc/GMT",
                  "expires_date_ms": "1620243718000",
                  "expires_date_pst": "2021-05-05 12:41:58 America/Los_Angeles",
                  "web_order_line_item_id": "230000397200750",
                  "is_trial_period": "true",
                  "is_in_intro_offer_period": "false",
                  "in_app_ownership_type": "PURCHASED"
                }
              ]
            },
            "latest_receipt_info": [
              {
                "quantity": "1",
                "product_id": "basic_subscription_1_month",
                "transaction_id": "230001020690335",
                "original_transaction_id": "1000000831360853",
                "purchase_date": "2021-08-04 19:41:58 Etc/GMT",
                "purchase_date_ms": "1628106118000",
                "purchase_date_pst": "2021-08-04 12:41:58 America/Los_Angeles",
                "original_purchase_date": "2021-04-28 19:41:58 Etc/GMT",
                "original_purchase_date_ms": "1619638918000",
                "original_purchase_date_pst": "2021-04-28 12:41:58 America/Los_Angeles",
                "expires_date": "2021-08-11 19:41:58 Etc/GMT",
                "expires_date_ms": "1628710918000",
                "expires_date_pst": "2021-08-11 12:41:58 America/Los_Angeles",
                "web_order_line_item_id": "230000438372383",
                "is_trial_period": "false",
                "is_in_intro_offer_period": "false",
                "in_app_ownership_type": "PURCHASED",
                "subscription_group_identifier": "272394410"
              },
              {
                "quantity": "1",
                "product_id": "basic_subscription_1_month",
                "transaction_id": "230001017218955",
                "original_transaction_id": "1000000831360853",
                "purchase_date": "2021-07-28 19:41:58 Etc/GMT",
                "purchase_date_ms": "1627501318000",
                "purchase_date_pst": "2021-07-28 12:41:58 America/Los_Angeles",
                "original_purchase_date": "2021-04-28 19:41:58 Etc/GMT",
                "original_purchase_date_ms": "1619638918000",
                "original_purchase_date_pst": "2021-04-28 12:41:58 America/Los_Angeles",
                "expires_date": "2021-08-04 19:41:58 Etc/GMT",
                "expires_date_ms": "1628106118000",
                "expires_date_pst": "2021-08-04 12:41:58 America/Los_Angeles",
                "web_order_line_item_id": "230000849023623",
                "is_trial_period": "false",
                "is_in_intro_offer_period": "false",
                "in_app_ownership_type": "PURCHASED",
                "subscription_group_identifier": "272394410"
              }
            ],
            "latest_receipt": "MIIUVQY...4rVpL8NlYh2/8l7rk0BcStXjQ==",
            "pending_renewal_info": [
              {
                "auto_renew_product_id": "basic_subscription_1_month",
                "product_id": "basic_subscription_1_month",
                "original_transaction_id": "1000000831360853",
                "auto_renew_status": "1"
              }
            ],
            "status": 0
          }', true);
    }

    public function verify() {
        //try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'receipt_data', 'payment_id'));
            $postData['customer_id'] = $customer['customer_id'];
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: '.$this->lang->line('not_transmitted'));
                die;
            }
           
            if(!isset($postData['receipt_data'])) {
                $this->error204('receipt_data: '.$this->lang->line('not_transmitted'));
                die;
            }
            if(!isset($postData['payment_id'])) {
                $this->error204('payment_id: '.$this->lang->line('not_transmitted'));
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mbusinesspayments', 'Mpaymentplans', 'Mcustomers', 'Memailqueue'));
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $postData['customer_id'], 'business_status_id >' => 0), 'id', 0);
            if(!$checkExit) {
                $this->error204($this->lang->line('business_does_not_belong_to_this_customer'));
                die;
            }

            $checkPayment = $this->Mbusinesspayments->getFieldValue(array('business_profile_id' => $postData['business_id'], 'id' => $postData['payment_id']), 'id', 0);
            if(!$checkPayment) {
                $this->error204($this->lang->line('payment_does_not_belong_to_this_customer'));
                die;
            }
            // receipt_data bắn lên trên apple qua api 
            //https://sandbox.itunes.apple.com/verifyReceipt
            // có response về
            $this->load->helper('slug');
            $body = array(
                "receipt-data" => $postData['receipt_data'],
                "password" => APPLE_VERIFY_RECEIPT_PASSWORD
            );
            // $body = json_decode('{
            //     "receipt-data": "receipt",
            //     "password": "779a40adef34447ca59b6f71d69292f2",
            //     "exclude-old-transactions": false
            // }');
            $verifyReceipt = callApiApple(APPLE_VERIFY_RECEIPT_HOST, $body, 'POST');
            $verifyReceipt = $this->verifyReceipt();
            if(isset($verifyReceipt['status']) && $verifyReceipt['status'] == 0) {
                $originalTransactionId = isset($verifyReceipt['receipt']['in_app']) && count($verifyReceipt['receipt']['in_app']) > 0 ? $verifyReceipt['receipt']['in_app'][0]['original_transaction_id'] : 0;
                
                if($originalTransactionId > 0) {
                    $data = array(
                        'original_transaction_id' => $originalTransactionId,
                        'receipt_json' => json_encode($verifyReceipt, true),
                        'updated_at' => getCurentDateTime(),
                        'updated_by' => 0
                    );
                    $flag = $this->Mbusinesspayments->save($data, $checkPayment);
                    if($flag) {
                        $businessProfile = $this->Mbusinessprofiles->get($postData['business_id']);
                        $dataUpdate = array(
                            'subscription_id' => $businessProfile['subscription_id'],
                            'payment_status_id' => 1,
                            'is_annual_payment' => 1,
                            'updated_at' => getCurentDateTime(),
                        );
                        $paymentPlan = $this->Mpaymentplans->get($businessProfile['plan_id']);
                        if($paymentPlan) {
                            if($paymentPlan['plan_type_id'] == 1) {
                                if(empty($businessProfile['expired_date']) || $businessProfile['expired_date'] == '0000-00-00 00:00:00') {
                                    $dataUpdate['expired_date'] = date('Y-m-d H:i:s',strtotime('+30 days'));
                                } else {
                                    $dataUpdate['expired_date'] =  date('Y-m-d H:i:s',strtotime('+30 days',strtotime($businessProfile['expired_date'])));
                                }
                            } else {
                                if(empty($businessProfile['expired_date']) || $businessProfile['expired_date'] == '0000-00-00 00:00:00') {
                                    $dataUpdate['expired_date'] = date('Y-m-d H:i:s',strtotime('+365 days'));
                                } else {
                                    $dataUpdate['expired_date'] = date('Y-m-d H:i:s',strtotime('+365 days',strtotime($businessProfile['expired_date'])));
                                }
                            }
                        }
                        
                       // nếu plan_type_id =1  30 , 2: 365
                        $this->Mbusinessprofiles->save($dataUpdate, $businessProfile['id']);
        
                        $invoice_url = $this->create_invoice_pdf($businessProfile['id']);
        
                        $customerInfo = $this->Mcustomers->get($customer['customer_id']);
        
                        $this->Mbusinesspayments->save(array('invoice_url' => $invoice_url), $businessPaymentId);
        
                        $dataEmail = array(
                            'name' => $customerInfo['customer_first_name'],
                            'email_to' => $customerInfo['customer_email'],
                            'email_to_name' => $customerInfo['customer_first_name'],
                            'business_name' => $businessProfile['business_name'],
                            'attach_file' => $invoice_url
                        );
                        $this->Memailqueue->createEmail($dataEmail, 13);

                        $this->success200(array('business_id' => $postData['business_id'], 'payment_id' => $flag), $this->lang->line('update_successful'));
                        die;
                    } else {
                        $this->error204($this->lang->line('update_failed'));
                        die;
                    }

                } else {
                    $this->error204($this->lang->line('failed'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('failed'));
                die;
            }
        /*}
        catch (\Throwable $th) {
            $this->error500();
        }*/
    }

    public function webhook() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $data = json_decode(file_get_contents('php://input'), true);
            if(count($data) > 0) {
                if(isset($data['unified_receipt']) && isset($data['unified_receipt']['latest_receipt_info']) && isset($data['unified_receipt']['latest_receipt_info'][0]) && isset($data['unified_receipt']['latest_receipt_info'][0]['original_transaction_id']) ) {
                    $originalTransactionId = $data['unified_receipt']['latest_receipt_info'][0]['original_transaction_id'];
                    $this->load->model(array('Mbusinesspayments'));
                    $checkPayment = $this->Mbusinesspayments->getFieldValue(array('original_transaction_id' => $originalTransactionId), 'id', 0);
                    if($checkPayment) {
                        $data = array(
                            'webhook_json' => json_encode($data, true),
                            'updated_at' => getCurentDateTime(),
                            'updated_by' => 0
                        );
    
                        $flag = $this->Mbusinesspayments->save($data, $checkPayment);
                        if ($flag) {
                            $this->success200('', $this->lang->line('update_successful'));
                            die;
                        } else {
                            $this->error204($this->lang->line('failed'));
                            die;
                        }
                    } else {
                        $this->error204($this->lang->line('failed'));
                        die;
                    }

                } else {
                    $this->error204($this->lang->line('failed'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('failed'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

}