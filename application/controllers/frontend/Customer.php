<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        
        $this->getLanguageFE();
    }

    public function index()
    {
        //$customer = $this->checkLoginCustomer();
        //$data['customer'] = $customer;
        //$this->load->view('frontend/site/home', $data);
    }

    public function checkLogin()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_email', 'customer_password', 'is_remember', 'redirectOldUrl'));
            $customerEmail = $postData['customer_email'];
            $customerPass = $postData['customer_password'];
            if (!empty($customerEmail) && !empty($customerPass)) {
                $configs = array();
                $this->load->model('Mcustomers');
                $customer = $this->Mcustomers->login($customerEmail, $customerPass);

                if ($customer) {
                    $this->Mcustomers->save(
                        array('login_type_id' => 0),
                        $customer['id']
                    );

                    $customer['login_type_id'] = 0;

                    $this->session->set_userdata('customer', $customer);

                    if (empty($customer['language_id'])) {
                        $customer['language_id'] = $this->Mconstants->languageDefault;
                    }
                    //$customer_cookie = array('login_type_id' => $customer['login_type_id'], 'customer_name' => $customer['customer_first_name'], 'language_id' => $customer['language_id'], 'language_name' => $this->Mconstants->languageShortCodes[$customer['language_id']], 'customer_avatar' => $customer['customer_avatar'], 'id' => $customer['id']);

                    $customer['language_name'] = $this->Mconstants->languageCodes[$customer['language_id']];

                    if ($postData['is_remember'] == 'on') {
                        $this->load->helper('cookie');
                        $this->input->set_cookie($this->configValueCookie('customer', json_encode($customer), '3600'));
                    } else {
                        $this->input->set_cookie($this->configValueCookie('customer', json_encode($customer), '-3600'));
                    }

                    $user['SessionId'] = uniqid();

                    $this->session->set_flashdata('notice_message', $this->lang->line('22112021_login_successful'));
                    $this->session->set_flashdata('notice_type', 'success');
                    if(!empty($postData['redirectOldUrl'])){
                        redirect($postData['redirectOldUrl']);
                    }else{
                        redirect(base_url(HOME_URL));
                    }
                    
                } else {
                    $this->session->set_flashdata('notice_message', $this->lang->line('22112021_login_failed'));
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('login.html'));
                }
            } else {
                $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('login.html'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?3'));
        }
    }

    public function register()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_email', 'customer_password'));

            if (!empty($postData['customer_email'])) {
                $confirmPassword = $this->input->post('confirm_password');
                if ($confirmPassword !== $postData['customer_password']) {
                    $this->session->set_flashdata('notice_message', $this->lang->line('passwords-does-not-match1635566199'));
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('signup.html?1'));
                }

                $postData['customer_email'] = strtolower($postData['customer_email']);
                $this->load->model('Mcustomers');
                if ($this->Mcustomers->checkExist(0, $postData['customer_email'])) {
                    $this->session->set_flashdata('notice_message', $this->lang->line('221121_email_already_exist'));
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('signup.html?2'));
                } else {
                    $customerPass = $postData['customer_password'];
                    $postData['customer_status_id'] = STATUS_WAITING_ACTIVE;
                    $postData['free_trial'] = STATUS_FREE_TRIAL;
                    $postData['customer_password'] = !empty($customerPass) ? md5($customerPass) : md5('123456');
                    $postData['created_by'] = 0;
                    $postData['login_type_id'] = 0;
                    $postData['created_at'] = getCurentDateTime();
                    $token_active = guidV4('acctive-email'.time());
                    $postData['token_reset'] = $token_active;

                    $customerId = $this->Mcustomers->update($postData);
                    if ($customerId > 0) {
                        /**
                         * Save Email
                         */
                        $this->load->model('Memailqueue');
                        $dataEmail = array(
                            'name' => $postData['customer_email'],
                            'email_to' => $postData['customer_email'],
                            'email_to_name' => $postData['customer_email'],
                            'token' => $token_active
                        );
                        $emailResult = $this->Memailqueue->createEmail($dataEmail, 99);
                        /**
                         * END. Save Email
                         */
                        
                        $this->session->set_flashdata('notice_message', $this->lang->line('221121_please_enter_your_email'));
                        $this->session->set_flashdata('notice_type', 'success');
                        redirect(base_url('login.html'));
                    } else {
                        $this->session->set_flashdata('notice_message', $this->lang->line('221121_register_failed_please_try_again'));
                        $this->session->set_flashdata('notice_type', 'error');
                        redirect(base_url('signup.html?3'));
                    }
                }
            } else {
                $this->session->set_flashdata('notice_message', $this->lang->line('221121_please_enter_your_email'));
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('signup.html?4'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('signup.html?5'));
        }
    }

    public function forgotPassword(){
        try {
            $postData = $this->arrayFromPost(array('email'));

            if (!empty($postData['email'])) {
                

                $customer_email = strtolower($postData['email']);

                $this->load->model('Mcustomers');
                

                $customerId = $this->Mcustomers->getFieldValue(array('customer_email' => $customer_email), 'id', 0);
                if ($customerId > 0) {
                    $token = guidV4('reset-passs');
                    $dataUpdate = array(
                        'token_reset' => $token
                    );
                    $customerId = $this->Mcustomers->save($dataUpdate, $customerId);
                    if($customerId > 0){
                        $customerInfo = $this->Mcustomers->get($customerId);
                        /**
                         * Save Email
                         */
                        $this->load->model('Memailqueue');
                        $dataEmail = array(
                            'name' => $customerInfo['customer_first_name'],
                            'email_to' => $customerInfo['customer_email'],
                            'email_to_name' => $customerInfo['customer_first_name'],
                            'token' => $token
                        );
                        $emailResult = $this->Memailqueue->createEmail($dataEmail, 2);
                        /**
                         * END. Save Email
                         */
                        if($emailResult){
                            echo json_encode(array('code' => 1, 'message' => $this->lang->line('successfully-sent-password-rec1635566199')));die;
                        }else{
                            echo json_encode(array('code' => 0, 'message' => $this->lang->line('sending-password-recover-faile1635566199').' 1'));die;
                        }
                    }else{
                        echo json_encode(array('code' => 0, 'message' => $this->lang->line('sending-password-recover-faile1635566199').' 2'));die;
                    }
                    
                } else {
                    echo json_encode(array('code' => 0, 'message' => $this->lang->line('email-not-exist1635566199')));die;
                }
                
            } else {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('please-enter-your-email1635566199')));die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));die;
        }
    }

    public function submitChangePassword(){
        try {
            $postData = $this->arrayFromPost(array('customer_password', 'rePassword', 'token'));

            if (!empty($postData['customer_password']) && !empty($postData['rePassword'])) {
                
                if($postData['customer_password'] != $postData['rePassword']){
                    echo json_encode(array('code' => 0, 'message' => $this->lang->line('passwords-does-not-match1635566199')));die;
                }
              
                $this->load->model('Mcustomers');
                

                $customerId = $this->Mcustomers->getFieldValue(array('token_reset' => $postData['token']), 'id', 0);
                if ($customerId > 0) {
                    
                    $dataUpdate = array(
                        'customer_password' => md5($postData['customer_password']),
                        'token_reset' => ''
                    );
                    $customerId = $this->Mcustomers->save($dataUpdate, $customerId);
                    if($customerId > 0){
                       echo json_encode(array('code' => 1, 'message' => $this->lang->line('successfully-reset-password1635566199')));die;
                      
                    }else{
                        echo json_encode(array('code' => 0, 'message' => $this->lang->line('resetting-password-failed1635566199')));die;
                    }
                    
                } else {
                    echo json_encode(array('code' => 0, 'message' => $this->lang->line('token-not-exist-or-expired1635566199')));die;
                }
                
            } else {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('please-enter-your-new-password1635566199')));die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));die;
        }
    }

    public function loginFb()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_email', 'customer_first_name', 'customer_last_name', 'login_type_id'));
            $id = $this->input->post('id');
            if ($postData['login_type_id'] == 1) $postData['facebook_id'] = $id;
            else if ($postData['login_type_id'] == 2) $postData['google_id'] = $id;

            $postData['customer_email'] = strtolower($postData['customer_email']);
            $this->load->model('Mcustomers');
            $customer = $this->Mcustomers->checkExist(0, $postData['customer_email']);
            $customerId = 0;
            if (count($customer) > 0) $customerId = $customer['id'];
            $message = 'Successfully register account';
            $customer['language_id'] = 1;

            if ($customerId == 0) {
                $postData['created_by'] = 0;
                $postData['created_at'] = getCurentDateTime();
                $postData['customer_status_id'] = STATUS_WAITING_ACTIVE;
                $postData['free_trial'] = STATUS_FREE_TRIAL;
                $postData['customer_password'] =  md5('123456');
            } else {
                $postData['updated_by'] = 0;
                $postData['updated_at'] = getCurentDateTime();
            }
            $flag = $this->Mcustomers->save($postData, $customerId);
            if ($flag > 0) {
                $customer = $this->Mcustomers->get($flag);
                $customer['language_name'] = $customer['language_id'] == 0 ? 'english' : $this->Mconstants->languageCodes[$customer['language_id']];
                $this->load->helper('cookie');
                $this->input->set_cookie($this->configValueCookie('customer', json_encode($customer), '3600'));
                echo json_encode(array('code' => 1, 'message' => $message, 'data' => $flag));
            } else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
        }
    }

    public function logout()
    {
        $this->load->helper('cookie');
        $fields = array('customer');
        delete_cookie('customer');
        echo json_encode(array('code' => 1, 'message' => ''));
    }

    public function customerGetCoupon()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_id', 'coupon_id'));
            if (empty($postData['customer_id']) || empty($postData['coupon_id'])) {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('incorrect-information1635566199')));
                die;
            }
            $this->loadModel(array('Mcoupons', 'Mcustomercoupons'));

            $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_id' => $postData['customer_id'], 'coupon_id' => $postData['coupon_id'], 'customer_coupon_status_id >' => 0), 'id', 0);

            if ($customerCouponId > 0) {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('you-have-saved-this-coupon-cod1635566199')));
                die;
            }

            $couponId = $this->Mcoupons->getFieldValue(array('id' => $postData['coupon_id']), 'id', 0);

            if ($couponId > 0) {
                $couponInfo = $this->Mcoupons->get($couponId);

                //check used - in past
                $pastUsed = $this->Mcustomercoupons->getUsedCoupon($postData['coupon_id']);

                //save coupon code
                $customer_coupon_code = $this->Mcoupons->genCouponCode($couponInfo['coupon_code'], $couponInfo['coupon_amount'], $this->Mcustomercoupons->getUsedCoupon($postData['coupon_id']));
                if (!empty($customer_coupon_code) && $pastUsed < $couponInfo['coupon_amount']) {
                    $customerCouponId = $this->Mcustomercoupons->save(array(
                        'customer_id' => $postData['customer_id'],
                        'coupon_id' => $postData['coupon_id'],
                        'customer_coupon_status_id' => STATUS_ACTIVED,
                        'customer_coupon_code' => $customer_coupon_code
                    ));

                    //check used - in present
                    $presentUsed = $this->Mcustomercoupons->getUsedCoupon($postData['coupon_id']);
                    if($presentUsed >= $couponInfo['coupon_amount']){
                        $this->Mcoupons->save(array('is_full' => 1), $postData['coupon_id']);
                    }

                    echo json_encode(array('code' => 1, 'message' => $this->lang->line('successfully-saved!1635566199')));
                    die;
                } else {
                    echo json_encode(array('code' => 0, 'message' => $this->lang->line('expired-coupon-code1635566199')));
                    die;
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }

    public function customerRemoveCoupon()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_id', 'coupon_id'));
            if (empty($postData['customer_id']) || empty($postData['coupon_id'])) {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('incorrect-information1635566199')));
                die;
            }
            $this->loadModel(array('Mcoupons', 'Mcustomercoupons'));

            $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_id' => $postData['customer_id'], 'coupon_id' => $postData['coupon_id'], 'customer_coupon_status_id > ' => 0), 'id', 0);

            if ($customerCouponId > 0) {
                $customerCouponId = $this->Mcustomercoupons->updateBy(
                    array(
                        'customer_id' => $postData['customer_id'],
                        'coupon_id' => $postData['coupon_id']
                    ),
                    array(
                        'customer_coupon_status_id' => 0
                    )
                );

                $coupon_amount = $this->Mcoupons->getFieldValue(array('id' => $postData['coupon_id']), 'coupon_amount', 0);

                //check used - in present
                $presentUsed = $this->Mcustomercoupons->getUsedCoupon($postData['coupon_id']);
                if($presentUsed < $coupon_amount){
                    $this->Mcoupons->save(array('is_full' => 0), $postData['coupon_id']);
                }

                echo json_encode(array('code' => 1, 'message' => $this->lang->line('successfully-removed!1635566199')));
                die;
            } else {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('coupon-code-not-exist1635566199')));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }


    public function customerJoinEvent()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_id', 'event_id'));
            if (empty($postData['customer_id']) || empty($postData['event_id'])) {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('incorrect-information1635566199')));
                die;
            }
            $this->loadModel(array('Mevents', 'Mcustomerevents'));

            $customerCouponId = $this->Mcustomerevents->getFieldValue(array('customer_id' => $postData['customer_id'], 'event_id' => $postData['event_id'], 'customer_event_status_id >' => 0), 'id', 0);

            if ($customerCouponId > 0) {
                echo json_encode(array('code' => 0, 'message' => "$this->lang->line('you-have-joined-this-event1635566199')"));
                die;
            }

            $eventId = $this->Mevents->getFieldValue(array('id' => $postData['event_id']), 'id', 0);

            if ($eventId > 0) {
                //join event
                $customerEventId = $this->Mcustomerevents->save(array(
                    'customer_id' => $postData['customer_id'],
                    'event_id' => $postData['event_id'],
                    'customer_event_status_id' => STATUS_ACTIVED
                ));

                if($customerEventId > 0){
                    $this->loadModel(array('Mcustomers', 'Mbusinessprofiles'));
                    $customerInfo = $this->Mcustomers->get($postData['customer_id']);
                    $eventInfo = $this->Mevents->get($postData['event_id']);
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

                echo json_encode(array('code' => 1, 'message' => $this->lang->line('you-have-been-successfully-reg1635566199')));
                die;
            } else {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('event-has-expired1635566199')));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }

    public function customerLeftEvent()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_id', 'event_id'));
            if (empty($postData['customer_id']) || empty($postData['event_id'])) {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('incorrect-information1635566199')));
                die;
            }
            $this->loadModel(array('Mevents', 'Mcustomerevents'));

            $customerEventId = $this->Mcustomerevents->getFieldValue(array('customer_id' => $postData['customer_id'], 'event_id' => $postData['event_id'], 'customer_event_status_id > ' => 0), 'id', 0);

            if ($customerEventId > 0) {
                $customerCouponId = $this->Mcustomerevents->updateBy(
                    array(
                        'customer_id' => $postData['customer_id'],
                        'event_id' => $postData['event_id']
                    ),
                    array(
                        'customer_event_status_id' => 0
                    )
                );
                echo json_encode(array('code' => 1, 'message' => $this->lang->line('you-have-left-the-event1635566199')));
                die;
            } else {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('the-event-has-ended-or-does-no1635566199')));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }

    public function join_as_guest() {
        $this->loadModel(array('Mcustomers','Mconfigs'));
        
        /**
         * Commons data
         */


        $data = $this->commonDataCustomer('Join event as guest');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $data['basePagingUrl'] = base_url('join-as-guest');

        $data['event_id'] = $this->input->get('event');

        $join_success = $this->input->get('join_success');

        $data['join_success'] = false;
        if($join_success == 1){
            $data['join_success'] = true;
        }
        $this->load->view('frontend/business/bp-event-join', $data);
    }

    public function submitJoinAsGuest()
    {
        try {
            $postData = $this->arrayFromPost(array('email', 'event_id', 'first_name', 'last_name'));
            if (empty($postData['event_id']) || empty($postData['first_name']) || empty($postData['last_name']) || empty($postData['email'])) {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('incorrect-information1635566199')));
                die;
            }
            $this->loadModel(array('Mevents', 'Mcustomerevents'));


            //join event
            $customerEventId = $this->Mcustomerevents->save(array(
                'customer_id' => 0,
                'event_id' => $postData['event_id'],
                'first_name' => $postData['first_name'],
                'last_name' => $postData['last_name'],
                'is_guest' => 1,
                'customer_event_status_id' => STATUS_ACTIVED
            ));

           
            $this->session->set_flashdata('notice_message', $this->lang->line('you-have-been-successfully-reg1635566199'));
            $this->session->set_flashdata('notice_type', 'success');
            redirect(base_url('join-as-guest?event='.$postData['event_id'].'&join_success=1'));
           
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('join-as-guest'));
        }
    }

    public function customerChangePassword()
    {
        try {
            $postData = $this->arrayFromPost(array('current_password', 'new_password', 'repeat_password', 'customer_id'));
            if (empty($postData['customer_id']) || empty($postData['current_password']) || empty($postData['new_password'])  || empty($postData['repeat_password'])) {
                $this->session->set_flashdata('notice_message', $this->lang->line('please-enter-information1635566199'));
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('customer/change-password?0'));
            }
            $this->loadModel(array('Mcustomers'));
            $currentPass = md5($postData['current_password']);
            $customerId = $this->Mcustomers->getFieldValue(array('id' => $postData['customer_id'], 'customer_password' => $currentPass, 'customer_status_id' => STATUS_ACTIVED), 'id', 0);

            if ($customerId > 0) {
                $newPass = "";
                if ($postData['new_password'] == $postData['repeat_password']) {
                    $newPass = md5($postData['repeat_password']);
                }
                if (!empty($newPass)) {
                    $customerInfo = $this->Mcustomers->updateBy(
                        array(
                            'id' => $customerId
                        ),
                        array(
                            'customer_password' => $newPass
                        )
                    );
                    if ($customerInfo) {
                        $this->session->set_flashdata('notice_message', $this->lang->line('password-change-successful1635566199'));
                        $this->session->set_flashdata('notice_type', 'success');
                        redirect(base_url('customer/change-password'));
                    } else {
                        $this->session->set_flashdata('notice_message', $this->lang->line('password-change-failed1635566199'));
                        $this->session->set_flashdata('notice_type', 'error');
                        redirect(base_url('customer/change-password?1'));
                    }
                } else {
                    $this->session->set_flashdata('notice_message', $this->lang->line('password-change-failed1635566199'));
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('customer/change-password?2'));
                }
            } else {
                $this->session->set_flashdata('notice_message', $this->lang->line('the-current-password-is-not-co1635566199'));
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('customer/change-password?4'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('customer/change-password?3'));
        }
    }

    public function customerUpdateInformation()
    {
        //echo "<pre>";print_r($_POST);die;
        try {
            $postData = $this->arrayFromPost(array(
                'customer_first_name',
                'customer_last_name',
                'customer_birthday',
                'customer_gender_id',
                'customer_phone_code',
                'customer_phone',
                'customer_address',
                'customer_occupation',
                'language_id',
                'customer_id'
            ));
            if (empty($postData['customer_first_name']) || empty($postData['customer_last_name']) || empty($postData['customer_address'])) {
                $this->session->set_flashdata('notice_message', $this->lang->line('please-enter-information1635566199'));
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('customer/general-information?0'));
            }
            $this->loadModel(array('Mcustomers'));
            $customerId = $this->Mcustomers->getFieldValue(array('id' => $postData['customer_id'], 'customer_status_id' => STATUS_ACTIVED), 'id', 0);

            if ($customerId > 0) {
                $dataUpdate = array(
                    'customer_first_name' => $postData['customer_first_name'],
                    'customer_last_name' => $postData['customer_last_name'],
                    'customer_birthday' => $postData['customer_birthday'],
                    'customer_gender_id' => $postData['customer_gender_id'],
                    'customer_phone_code' => $postData['customer_phone_code'],
                    'customer_phone' => $postData['customer_phone'],
                    'customer_address' => $postData['customer_address'],
                    'customer_occupation' => $postData['customer_occupation'],
                    'language_id' => $postData['language_id']
                );
                /**
                 * Upload if customer choose image
                 */
                $customerAvatarUpload = $this->input->post('customer_avatar_upload');
                if(!empty($customerAvatarUpload)){
                    $avatarUpload = $this->uploadImageBase64($customerAvatarUpload, 3);
                    $dataUpdate['customer_avatar'] = replaceFileUrl($avatarUpload, CUSTOMER_PATH);
                }
                
                $customerInfo = $this->Mcustomers->updateBy(
                    array(
                        'id' => $customerId
                    ),
                    $dataUpdate
                );
                if ($customerInfo) {
                    $this->session->set_flashdata('notice_message', "Updated successfully");
                    $this->session->set_flashdata('notice_type', 'success');
                    redirect(base_url('customer/general-information'));
                } else {
                    $this->session->set_flashdata('notice_message', "Updated failed");
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('customer/general-information?1'));
                }
            } else {
                $this->session->set_flashdata('notice_message', $this->lang->line('you-do-not-have-permission-on-1635566199'));
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url(HOME_URL));
            }
        } catch (Exception $e) {
            //echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));die;
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('customer/general-information?3'));
        }
    }

    public function my_coupons()
    {
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('My Coupons');
        $data['activeMenu'] = "";
        $data['activeCustomerNav'] = "my-coupons";
        /**
         * Commons data
         */
        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', $this->lang->line('please-login-to-view-this-page1635566199'));
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl='.current_url()));
        }

        $per_page = $this->input->get('per_page');
        $data['per_page'] =  $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] =  $search_text;
        $order_by = $this->input->get('order_by');
        $data['order_by'] =  $order_by;
        $businessId = $this->input->get('business');
        $data['business'] =  $businessId;

        $savedCoupons = $this->Mcustomercoupons->getListFieldValue(array('customer_id' => $data['customer']['id'], 'customer_coupon_status_id >' => 0), 'coupon_id');
        if (count($savedCoupons) > 0) {
            $getData = array(
                'search_text_fe' => $search_text,
                'coupon_ids' => $savedCoupons,
                'business_profile_id' => $businessId,
                'order_by' => $order_by
            );

            $businessProfileIds = $this->Mcoupons->getListBusinessId();

            $data['businessProfiles'] = array();
            $data['serviceTypes'] = array();
            if (!empty($businessProfileIds) && count($businessProfileIds) > 0) {
                $service_type_name = "service_type_name_" . $this->Mconstants->languageShortCodes[$data['language_id']];
                $data['serviceTypes'] = $this->Mservicetypes->getListByListBusinessId(array('business_profile_ids' => $businessProfileIds), $service_type_name);

                $data['businessProfiles'] = $this->Mbusinessprofiles->search(array('business_profile_ids' => $businessProfileIds));
            }

            $rowCount = $this->Mcoupons->getCount($getData);
            $data['lists'] = array();

            /**
             * PAGINATION
             */
            $perPage = DEFAULT_LIMIT_COUPON;
            //$perPage = 2;
            if (is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
            $pageCount = ceil($rowCount / $perPage);
            $page = $this->input->get('page');
            if (!is_numeric($page) || $page < 1) $page = 1;
            $data['basePagingUrl'] = base_url('customer/my-coupons');
            $data['perPage'] = $perPage;
            $data['page'] = $page;
            $data['rowCount'] = $rowCount;
            $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
            /**
             * END - PAGINATION
             */

            $data['lists'] = $this->Mcoupons->search($getData, $perPage, $page);
            foreach ($data['lists'] as $kCoupon => $itemCoupon) {
                $data['lists'][$kCoupon]['customer_id'] = $data['customer']['id'];
                $data['lists'][$kCoupon]['customer_coupon_status_id'] = $this->Mcustomercoupons->getFieldValue(array('coupon_id' => $itemCoupon['id'], 'customer_id' => $data['customer']['id'], 'customer_coupon_status_id > ' => 0), 'customer_coupon_status_id', 0);
            }
        }else{
            $data['lists'] = array();
            $data['basePagingUrl'] = base_url('customer/my-coupons');
        }
        $this->load->view('frontend/customer/um-coupon', $data);
    }

    public function general_information()
    {
        $this->loadModel(array('Mconfigs', 'Mcustomers', 'Mservices', 'Mphonecodes'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($this->lang->line('general_information'));
        $data['activeMenu'] = "";
        $data['activeCustomerNav'] = "general-information";

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', $this->lang->line('please-login-to-view-this-page1635566199'));
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl='.current_url()));
        }

        $data['customerInfo'] = $this->Mcustomers->get($data['customer']['id']);

        $data['phoneCodes'] = $this->Mphonecodes->get();

        $data['currenPhoneCode'] = array();
        if ($data['customerInfo']['customer_phone_code'] > 0) {
            $data['currenPhoneCode'] = $this->Mphonecodes->get($data['customerInfo']['customer_phone_code']);
        }

        $this->load->view('frontend/customer/um-general', $data);
    }

    public function change_password()
    {
        $this->loadModel(array('Mcoupons', 'Mconfigs'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Change Password');
        $data['activeMenu'] = "";
        $data['activeCustomerNav'] = "change-password";

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', $this->lang->line('please-login-to-view-this-page1635566199'));
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl='.current_url()));
        }

        $this->load->view('frontend/customer/um-change-password', $data);
    }

    public function my_events()
    {
        $this->loadModel(array('Mconfigs', 'Mservices', 'Mevents', 'Mbusinessprofiles', 'Mcustomerevents'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Services');
        $data['activeMenu'] = "";
        $data['activeCustomerNav'] = "my-events";
        /**
         * Commons data
         */

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', $this->lang->line('please-login-to-view-this-page1635566199'));
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl='.current_url()));
        }

        $data['activeMenuService'] = 0;

        $per_page = $this->input->get('per_page');
        $data['per_page'] = $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] = $search_text;
        $joinedEvents = $this->Mcustomerevents->getListFieldValue(array('customer_id' => $data['customer']['id'], 'customer_event_status_id >' => 0), 'event_id');
        $data['joinedEvents'] = $joinedEvents;
        $getData = array(
            'event_status_id' => STATUS_ACTIVED,
            'search_text_fe' => $search_text,
            'event_ids' => $joinedEvents
        );
        $rowCount = $this->Mevents->getCount($getData);
        $data['lists'] = array();

        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_BUSINESS_PROFILE;
        //$perPage = 2;
        if (is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('customer/my-events');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mevents->search($getData, $perPage, $page);
        for ($i = 0; $i < count($data['lists']); $i++) {
            $data['lists'][$i]['business_name'] = $this->Mbusinessprofiles->getFieldValue(array('id' => $data['lists'][$i]['business_profile_id'], 'business_status_id' => STATUS_ACTIVED), 'business_name', '');
            $data['lists'][$i]['event_image'] = (!empty($data['lists'][$i]['event_image'])) ? EVENTS_PATH . $data['lists'][$i]['event_image'] : EVENTS_PATH . NO_IMAGE;
        }

        $this->load->view('frontend/customer/um-event', $data);
    }

    public function my_reservation()
    {
        $this->loadModel(array('Mconfigs', 'Mservices', 'Mevents', 'Mbusinessprofiles', 'Mcustomerevents'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Services');
        $data['activeMenu'] = "";
        $data['activeCustomerNav'] = "my-reservation";
        /**
         * Commons data
         */

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', $this->lang->line('please-login-to-view-this-page1635566199'));
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html?requiredLogin=1&redirectUrl='.current_url()));
        }

        $data['activeMenuService'] = 0;

        $per_page = $this->input->get('per_page');
        $data['per_page'] = $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] = $search_text;
        $type = $this->input->get('type');
        $data['type'] = $type;
        $selected_day = $this->input->get('selected_day');
        $data['selected_day'] = $selected_day;

        $getData = array(
            'date_arrived' => $selected_day,
            'search_text_fe' => $search_text,
            'customer_id' => $data['customer']['id'],
            'book_status_id' => $type
        );
        $rowCount = $this->Mcustomerreservations->getCount($getData);
        $data['lists'] = array();

        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_BUSINESS_PROFILE;
        //$perPage = 2;
        if (is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('customer/my-reservation');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mcustomerreservations->search($getData, $perPage, $page);

        foreach($data['lists'] as $k => $item){
            $data['lists'][$k]['business_name'] = $this->Mbusinessprofiles->getFieldValue(array('id' => $item['business_profile_id']), 'business_name', '');
            $data['lists'][$k]['business_url'] = $this->Mbusinessprofiles->getFieldValue(array('id' => $item['business_profile_id']), 'business_url', '');
        }

        $this->load->view('frontend/customer/um-reservation', $data);
    }

    public function verifyEmail() {
        try {
            $token = $this->input->get('token');
            if(empty($postData['token'])) {
                $this->session->set_flashdata('notice_message', $this->lang->line('22112021_account_activation_failed'));
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('login.html'));
            }
            $this->load->model('Mcustomers');
            $customer = $this->Mcustomers->getBy(array('token_reset' => $token, 'customer_status_id' => STATUS_WAITING_ACTIVE));
            if($customer) {
                $customer = $customer[0];
                $flag = $this->Mcustomers->save(['token_reset' => '', 'customer_status_id' => STATUS_ACTIVED, 'updated_at' => getCurentDateTime()], $customer['id']);
                if($flag) {
                    $this->session->set_flashdata('notice_message', $this->lang->line('22112021_account_activation_successfully'));
                    $this->session->set_flashdata('notice_type', 'success');
                    redirect(base_url('login.html'));
                } else {
                    $this->session->set_flashdata('notice_message', $this->lang->line('22112021_account_activation_failed'));
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('login.html'));
                }
            } else {
                $this->session->set_flashdata('notice_message', $this->lang->line('22112021_token_expired_or_account_has_been_activated'));
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('login.html'));
            }
        } catch (\Throwable $th) {
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('login.html'));
        }
    }
}
