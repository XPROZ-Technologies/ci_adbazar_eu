<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('customer', $this->language);
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
            $postData = $this->arrayFromPost(array('customer_email', 'customer_password', 'is_remember'));
            $customerEmail = $postData['customer_email'];
            $customerPass = $postData['customer_password'];
            if (!empty($customerEmail) && !empty($customerPass)) {
                $configs = array();
                $this->load->model('Mcustomers');
                $customer = $this->Mcustomers->login($customerEmail, $customerPass);

                if ($customer) {

                    $this->session->set_userdata('customer', $customer);

                    if (empty($customer['language_id'])) {
                        $customer['language_id'] = $this->Mconstants->languageDefault;
                    }
                    //$customer_cookie = array('login_type_id' => $customer['login_type_id'], 'customer_name' => $customer['customer_first_name'], 'language_id' => $customer['language_id'], 'language_name' => $this->Mconstants->languageCodes[$customer['language_id']], 'customer_avatar' => $customer['customer_avatar'], 'id' => $customer['id']);

                    $customer['language_name'] = $this->Mconstants->languageCodes[$customer['language_id']];

                    if ($postData['is_remember'] == 'on') {
                        $this->load->helper('cookie');
                        $this->input->set_cookie($this->configValueCookie('customer', json_encode($customer), '3600'));
                    } else {
                        $this->input->set_cookie($this->configValueCookie('customer', json_encode($customer), '-3600'));
                    }

                    $user['SessionId'] = uniqid();

                    $this->session->set_flashdata('notice_message', $this->lang->line('customer_login_success'));
                    $this->session->set_flashdata('notice_type', 'success');
                    redirect(base_url(HOME_URL));
                } else {
                    $this->session->set_flashdata('notice_message', $this->lang->line('customer_login_failed'));
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('login.html?1'));
                }
            } else {
                $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('login.html?2'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', $e->getMessage());
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
                    $this->session->set_flashdata('notice_message', 'Password does not match');
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('signup.html?1'));
                }

                $postData['customer_email'] = strtolower($postData['customer_email']);
                $this->load->model('Mcustomers');
                if ($this->Mcustomers->checkExist(0, $postData['customer_email'])) {
                    $this->session->set_flashdata('notice_message', $this->lang->line('customer_phone_or_email_exists'));
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

                    $customerId = $this->Mcustomers->update($postData);
                    if ($customerId > 0) {
                        //send email active account

                        $this->session->set_flashdata('notice_message', 'Successfully register account');
                        $this->session->set_flashdata('notice_type', 'success');
                        redirect(base_url('login.html'));
                    } else {
                        $this->session->set_flashdata('notice_message', 'Register failed, please try again!');
                        $this->session->set_flashdata('notice_type', 'error');
                        redirect(base_url('signup.html?3'));
                    }
                }
            } else {
                $this->session->set_flashdata('notice_message', "Please enter email");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('signup.html?4'));
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('notice_message', $e->getMessage());
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url('signup.html?5'));
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
                $customer['language_name'] = $customer['language_id'] == 0 ? 'en' : $this->Mconstants->languageCodes[$customer['language_id']];
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
                echo json_encode(array('code' => 0, 'message' => "Incorrect information"));
                die;
            }
            $this->loadModel(array('Mcoupons', 'Mcustomercoupons'));

            $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_id' => $postData['customer_id'], 'coupon_id' => $postData['coupon_id'], 'customer_coupon_status_id >' => 0), 'id', 0);

            if ($customerCouponId > 0) {
                echo json_encode(array('code' => 0, 'message' => "You have saved this coupon code"));
                die;
            }

            $couponId = $this->Mcoupons->getFieldValue(array('id' => $postData['coupon_id']), 'id', 0);

            if ($couponId > 0) {
                $couponInfo = $this->Mcoupons->get($couponId);

                //save coupon code
                $customer_coupon_code = $this->Mcoupons->genCouponCode($couponInfo['coupon_code'], $couponInfo['coupon_amount'], $this->Mcustomercoupons->getUsedCoupon($postData['coupon_id']));
                if (!empty($customer_coupon_code)) {
                    $customerCouponId = $this->Mcustomercoupons->save(array(
                        'customer_id' => $postData['customer_id'],
                        'coupon_id' => $postData['coupon_id'],
                        'customer_coupon_status_id' => STATUS_ACTIVED,
                        'customer_coupon_code' => $customer_coupon_code
                    ));
                    echo json_encode(array('code' => 1, 'message' => "Successfully Saved!"));
                    die;
                } else {
                    echo json_encode(array('code' => 0, 'message' => "Expired coupon code"));
                    die;
                }
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => $e->getMessage()));
            die;
        }
    }

    public function customerRemoveCoupon()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_id', 'coupon_id'));
            if (empty($postData['customer_id']) || empty($postData['coupon_id'])) {
                echo json_encode(array('code' => 0, 'message' => "Incorrect information"));
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
                echo json_encode(array('code' => 1, 'message' => "Successfully removed!"));
                die;
            } else {
                echo json_encode(array('code' => 0, 'message' => "Coupon code not exist"));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => $e->getMessage()));
            die;
        }
    }


    public function customerJoinEvent()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_id', 'event_id'));
            if (empty($postData['customer_id']) || empty($postData['event_id'])) {
                echo json_encode(array('code' => 0, 'message' => "Incorrect information"));
                die;
            }
            $this->loadModel(array('Mevents', 'Mcustomerevents'));

            $customerCouponId = $this->Mcustomerevents->getFieldValue(array('customer_id' => $postData['customer_id'], 'event_id' => $postData['event_id'], 'customer_event_status_id >' => 0), 'id', 0);

            if ($customerCouponId > 0) {
                echo json_encode(array('code' => 0, 'message' => "You have joined this event"));
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
                echo json_encode(array('code' => 1, 'message' => "You have been successfully registered for the event!"));
                die;
            } else {
                echo json_encode(array('code' => 0, 'message' => "Event has expired"));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => $e->getMessage()));
            die;
        }
    }

    public function customerLeftEvent()
    {
        try {
            $postData = $this->arrayFromPost(array('customer_id', 'event_id'));
            if (empty($postData['customer_id']) || empty($postData['event_id'])) {
                echo json_encode(array('code' => 0, 'message' => "Incorrect information"));
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
                echo json_encode(array('code' => 1, 'message' => "You have been left event"));
                die;
            } else {
                echo json_encode(array('code' => 0, 'message' => "The event has ended or does not exist"));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => $e->getMessage()));
            die;
        }
    }

    public function customerChangePassword()
    {
        try {
            $postData = $this->arrayFromPost(array('current_password', 'new_password', 'repeat_password', 'customer_id'));
            if (empty($postData['customer_id']) || empty($postData['current_password']) || empty($postData['new_password'])  || empty($postData['repeat_password'])) {
                $this->session->set_flashdata('notice_message', "Please enter information");
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
                        $this->session->set_flashdata('notice_message', "Change password successfully");
                        $this->session->set_flashdata('notice_type', 'success');
                        redirect(base_url('customer/change-password'));
                    } else {
                        $this->session->set_flashdata('notice_message', "Change password failed");
                        $this->session->set_flashdata('notice_type', 'error');
                        redirect(base_url('customer/change-password?1'));
                    }
                } else {
                    $this->session->set_flashdata('notice_message', "Change password failed");
                    $this->session->set_flashdata('notice_type', 'error');
                    redirect(base_url('customer/change-password?2'));
                }
            } else {
                $this->session->set_flashdata('notice_message', "You do not have permission on this page");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url(HOME_URL));
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
                'customer_email',
                'customer_birthday',
                'customer_gender_id',
                'customer_phone_code',
                'customer_phone',
                'customer_address',
                'customer_occupation',
                'language_id',
                'customer_id'
            ));
            if (empty($postData['customer_first_name']) || empty($postData['customer_last_name']) || empty($postData['customer_email'])  || empty($postData['customer_address'])) {
                $this->session->set_flashdata('notice_message', "Please enter information");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url('customer/general-information?0'));
            }
            $this->loadModel(array('Mcustomers'));
            $customerId = $this->Mcustomers->getFieldValue(array('id' => $postData['customer_id'], 'customer_status_id' => STATUS_ACTIVED), 'id', 0);

            if ($customerId > 0) {
                $customerInfo = $this->Mcustomers->updateBy(
                    array(
                        'id' => $customerId
                    ),
                    array(
                        'customer_first_name' => $postData['customer_first_name'],
                        'customer_last_name' => $postData['customer_last_name'],
                        'customer_email' => $postData['customer_email'],
                        'customer_birthday' => $postData['customer_birthday'],
                        'customer_gender_id' => $postData['customer_gender_id'],
                        'customer_phone_code' => $postData['customer_phone_code'],
                        'customer_phone' => $postData['customer_phone'],
                        'customer_address' => $postData['customer_address'],
                        'customer_occupation' => $postData['customer_occupation'],
                        'language_id' => $postData['language_id']
                    )
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
                $this->session->set_flashdata('notice_message', "You do not have permission on this page");
                $this->session->set_flashdata('notice_type', 'error');
                redirect(base_url(HOME_URL));
            }
        } catch (Exception $e) {
            //echo json_encode(array('code' => -2, 'message' => $e->getMessage()));die;
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
            $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
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
                $service_type_name = "service_type_name_" . $this->Mconstants->languageCodes[$data['language_id']];
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
        }
        $this->load->view('frontend/customer/um-coupon', $data);
    }

    public function general_information()
    {
        $this->loadModel(array('Mconfigs', 'Mcustomers', 'Mservices', 'Mphonecodes'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('General Information');
        $data['activeMenu'] = "";
        $data['activeCustomerNav'] = "general-information";

        if ($data['customer']['id'] == 0) {
            $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
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
            $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
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
            $this->session->set_flashdata('notice_message', "You do not have permission to view this page");
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
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
}
