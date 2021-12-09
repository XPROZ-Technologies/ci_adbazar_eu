<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language-id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
        $this->fb = new Facebook\Facebook([
            'app_id' => FACEBOOK_ID,
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => GRAPH_version,
        ]);

        $this->client = new Google_Client();
        $this->client->setClientId(KEY_GG.'.apps.googleusercontent.com');
        $this->client->setClientSecret(GOOGLE_SECRET);
        // $this->client->setRedirectUri(REDIRECT_URI);
        $this->client->addScope("email");
        $this->client->addScope("profile");

        $this->service = new Google_Service_Oauth2($this->client);

    }

    public function login() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('login_type_id', 'customer_email', 'customer_password', 'facebook_token', 'google_token'));
            $this->load->model('Mcustomers');
            $customer = [];
            if(intval($postData['login_type_id']) == 0) {
                if(empty($postData['customer_email'])) {
                    $this->error204($this->lang->line('please-enter-your-email1635566199'));
                    die;
                }
                if(!checkemail($postData['customer_email'])) {
                    $this->error204($this->lang->line('email-not-exist1635566199'));
                    die;
                }
                if(empty($postData['customer_password'])) {
                    $this->error204($this->lang->line('your_password_does_not_match_p'));
                    die;
                }
                
                
                $customer = $this->Mcustomers->login($postData['customer_email'], $postData['customer_password']);
                
            } else if (intval($postData['login_type_id']) == 1) {
                // $postData['facebook_token'] = 'EAAChwUZAbAdkBAM1qYHnHLPIuuXZAhehZAbrXO4Enbt3WEDIxRyEoO33RZCJEh40QfZCtQOlwCQgqbZAA3cYE4kGLaNlZCJDc843NZAZBZBIoyKCPA4nCY4YhtB68590THpBkJdeQJcBh8ZCELlBsYP8ojur4Oy7UN8Iw5Jt9XceCtJTR7ejTZC7ZCrww2eervxZCtTSUoJgUomFyH2zCPVCRf47QxXaZBbK3eYDlJwqX8NqtQpL47Of7yiZBX51';
                $this->fb->setDefaultAccessToken($postData['facebook_token']);
                try {
                    $response = $this->fb->get('/me?fields=id,name,email');
                    $userNode = json_decode($response->getGraphUser(), true);
                    $postData['facebook_id'] = $userNode['id'];
                    $postData['customer_last_name'] = $userNode['name'];
                    $postData['customer_email'] = $userNode['email'];
                    $postData['customer_status_id'] = STATUS_ACTIVED;
                    $customer = $this->Mcustomers->login($postData['customer_email'], '', $postData['login_type_id']);
                    if(!$customer) $customer['id'] = 0;
                } catch (Facebook\Exceptions\FacebookResponseException $e) {
                    $this->error204('Graph returned an error: ' . $e->getMessage());
                    die;
                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    $this->error204('Facebook SDK returned an error: ' . $e->getMessage());
                    die;
                }
            } else if (intval($postData['login_type_id']) == 2) {
                $this->client->setAccessToken($postData['google_token']);
                try {
                    $googleInfo = $this->service->userinfo->get();
                    if($googleInfo) {
                        $info = json_decode(json_encode($googleInfo, true),true);
                        $postData['google_id'] = $info['id'];
                        $postData['customer_last_name'] = $info['name'];
                        $postData['customer_email'] = $info['email'];
                        $postData['customer_status_id'] = STATUS_ACTIVED;
                        $customer = $this->Mcustomers->login($postData['customer_email'], '', $postData['login_type_id']);
                        if(!$customer) $customer['id'] = 0;
                    } else {
                        $this->error204('Graph returned an error');
                        die;
                    }
                } catch (\Throwable $th) {
                    $this->error204('Google SDK returned an error');
                    die;
                }
            }

            if($customer) {
                $flag = false;
                if ($customer) {
                    $this->load->library('Authorization_Token');
                    // generte a token
                    $token = $this->authorization_token->generateToken(array('id' => $customer['id'], 'created_at' => getCurentDateTime()));
                    $postData['token'] = $token;
                    $postData['language_id'] = $this->languageId;
                    unset($postData['facebook_token'], $postData['google_token'], $postData['customer_password']);
                   $flag = $this->Mcustomers->save($postData, $customer['id']);
                }
                if($flag) {
                    $customer = $this->Mcustomers->get($flag);
                    if(empty($customer['customer_avatar'])) $customer['customer_avatar'] = base_url(CUSTOMER_PATH.NO_IMAGE);
                    else $customer['customer_avatar'] = base_url(CUSTOMER_PATH.$customer['customer_avatar']);
                    unset($customer['token_reset'], $customer['customer_password'], $customer['created_at'], $customer['created_by'], $customer['updated_at'],  $customer['updated_by'],  $customer['deleted_at']);
                    $this->success200(array('customer' => $customer));
                }
                
            } else {
                $this->error204('You entered an invalid email or password. Please re-enter.');
                die;
            }
            
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function logout() {
        try {
            $this->openAllCors();
            $token = $this->getAuthorizationHeader();
            // $token = $this->input->get_request_header('X-Auth-Token', TRUE);
            if(empty($token)) {
                $this->error410('Token has not been uploaded yet');
                die;
            }else {
                $this->load->model('Mcustomers');
                $customerId = $this->Mcustomers->getFieldValue(array('token' => $token), 'id', 0);
                if(!$customerId) {
                    $this->error204('Token does not exist');
                    die;
                } else {
                    $flag = $this->Mcustomers->save(array('token' => '', 'updated_at' => getCurentDateTime()), $customerId);
                    if($flag) $this->success200($customerId, 'Logout successful');
                    else $this->error500();
                }
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function sign_up(){
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('login_type_id', 'customer_email', 'customer_password', 'confirm_password' , 'google_token', 'facebook_token'));
            $this->load->model('Mcustomers');
            $data = [];
            if (intval($postData['login_type_id']) == 0) {
                if (empty($postData['customer_email'])) {
                    $this->error204($this->lang->line('please_enter_a_valid_email'));
                    die;
                }
                if(!checkemail($postData['customer_email'])) {
                    $this->error204($this->lang->line('email-not-exist1635566199'));
                    die;
                }
                $this->validatePassWord($postData);
               
                $customer = $this->Mcustomers->checkExist(0, $postData['customer_email']);
                if($customer) {
                    $this->error204('Email already exists in the system');
                    die;
                }
                $data['customer_password'] =  md5($postData['customer_password']);
                $data['customer_status_id'] = STATUS_WAITING_ACTIVE; 
            } else if (intval($postData['login_type_id']) == 1) { //facebook
                
                $this->fb->setDefaultAccessToken($postData['facebook_token']);
                try {
                    $response = $this->fb->get('/me?fields=id,name,email');
                    $userNode = json_decode($response->getGraphUser(), true);
                    $data['facebook_id'] = $userNode['id'];
                    $data['customer_first_name'] = $userNode['name'];
                    $data['customer_last_name'] = $userNode['email'];
                    $data['customer_password'] = md5('12345678@aM');
                    $data['customer_status_id'] = STATUS_ACTIVE; 

                } catch (Facebook\Exceptions\FacebookResponseException $e) {
                    $this->error204('Graph returned an error: ' . $e->getMessage());
                    die;
                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    $this->error204('Facebook SDK returned an error: ' . $e->getMessage());
                    die;
                }
            } else if (intval($postData['login_type_id']) == 2) { //google
                
                $this->client->setAccessToken($postData['google_token']);
                try {
                    $googleInfo = $this->service->userinfo->get();
                    if($googleInfo) {
                        $info = json_decode(json_encode($googleInfo, true),true);
                        $data['google_id'] = $info['id'];
                        $data['customer_last_name'] = $info['name'];
                        $data['customer_email'] = $info['email'];
                        $data['customer_password'] = md5('12345678@aM');
                        $data['customer_status_id'] = STATUS_ACTIVED;
                    } else {
                        $this->error204('Graph returned an error');
                        die;
                    }
                } catch (\Throwable $th) {
                    $this->error204('Google SDK returned an error');
                    die;
                }
            }

            $data['login_type_id'] =  $postData['login_type_id'];
            $data['customer_email'] =  strtolower($postData['customer_email']);
          
            if($data) {
                $data['created_at'] = getCurentDateTime();
                $data['created_by'] = 0;
                $data['free_trial'] = STATUS_FREE_TRIAL;
                $token_active = guidV4('reset-passs');
                $data['token_reset'] = $token_active;
                if (intval($postData['login_type_id']) == 0) {
                    $flag = $this->Mcustomers->save($data);
                } else {
                    $customer = $this->Mcustomers->checkExist(0, $postData['customer_email']);
                    $customerId = 0;
                    if (count($customer) > 0) $customerId = $customer['id'];
                    $flag = $this->Mcustomers->save($data, $customerId);
                }
                if($flag) {
                    // generte a token
                   
                    $this->load->model('Memailqueue');
                    $dataEmail = array(
                        'name' => $postData['customer_email'],
                        'email_to' => $postData['customer_email'],
                        'email_to_name' => $postData['customer_email'],
                        'token' => $token_active
                    );
                    $this->Memailqueue->createEmail($dataEmail, 99);
                    $this->success200($flag, $this->lang->line('successfully_register_account'));
                } else {
                    $this->error400('Registration failed');
                    die;
                }

            } else {
                $this->error400('Registration failed');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function forgot_password() {
        try {
            $postData = $this->arrayFromPostRawJson(array('customer_email'));
            $customer_email = strtolower($postData['customer_email']);
            if (empty($customer_email)) {
                $this->error204($this->lang->line('please-enter-your-email1635566199'));
                die;
            }
            $this->load->model('Mcustomers');
            $customer = $this->Mcustomers->getBy(array('customer_email' => $customer_email));
            if ($customer && count($customer) > 0) {
                $this->load->library('Authorization_Token');
                // generte a token
                $tokenReset = $this->authorization_token->generateToken(array('id' => $customer['id'], 'created_at' => getCurentDateTime()));
                $customer = $customer[0];
                $customerId = $this->Mcustomers->save(array('token_reset' => $tokenReset), $customer['id']);
                if($customerId > 0){
                    /**
                     * Save Email
                     */
                    $this->load->model('Memailqueue');
                    $dataEmail = array(
                        'name' => $customer['customer_first_name'],
                        'email_to' => $customer['customer_email'],
                        'email_to_name' => $customer['customer_first_name'],
                        'token' => $tokenReset
                    );
                    $emailResult = $this->Memailqueue->createEmail($dataEmail, 2);
                    /**
                     * END. Save Email
                     */
                    if ($emailResult){
                        $this->success200('', $this->lang->line('successfully-sent-password-rec1635566199'));
                        die;
                    } else {
                        $this->error400($this->lang->line('sending-password-recover-faile1635566199'));
                        die;
                    }
                } else {
                    $this->error400($this->lang->line('sending-password-recover-faile1635566199'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('email-not-exist1635566199'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function change_password() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('customer_password', 'confirm_password', 'token_reset'));
            $this->validatePassWord($postData);
            if(empty($postData['token_reset'])) {
                $this->error204('Tokens cannot be empty');
                die;
            }
            $this->load->model('Mcustomers');
            $customerId = $this->Mcustomers->getFieldValue(array('token_reset' => $postData['token_reset']), 'id', 0);
            if ($customerId > 0) {
                $dataUpdate = array(
                    'customer_password' => md5($postData['customer_password']),
                    'token' => '',
                    'token_reset' => '',
                    'updated_at' => getCurentDateTime()
                );
                $flag = $this->Mcustomers->save($dataUpdate, $customerId);
                if($flag > 0){
                    $this->success200($flag, $this->lang->line('successfully-reset-password1635566199'));
                    die;
                }else{
                    $this->error400($this->lang->line('resetting-password-failed1635566199'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('token-not-exist-or-expired1635566199'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }


    private function validatePassWord($postData) {
        if (empty($postData['customer_password']) || empty($postData['confirm_password'])) {
            $this->error204($this->lang->line('please-enter-your-new-password1635566199'));
            die;
        }
        if ($postData['customer_password'] != $postData['confirm_password']) {
            $this->error204('Password does not match');
            die;
        }
        $uppercase = preg_match('@[A-Z]@', $postData['customer_password']);
        $lowercase = preg_match('@[a-z]@', $postData['customer_password']);
        $number    = preg_match('@[0-9]@', $postData['customer_password']);
        $specialChars = preg_match('@[^\w]@', $postData['customer_password']);
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($postData['customer_password']) < 8) {
            $this->error204('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
            die;
        }
    }

    public function confirm_email() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('token'));
            if(empty($postData['token'])) {
                $this->error204('Tokens cannot be empty');
                die;
            }
            $this->load->model('Mcustomers');
            $customer = $this->Mcustomers->getBy(array('token_reset' => $postData['token'], 'customer_status_id' => STATUS_WAITING_ACTIVE));
            if($customer) {
                $customer = $customer[0];

                $this->load->library('Authorization_Token');
                // generte a token
                $token = $this->authorization_token->generateToken(array('id' => $customer['id'], 'created_at' => getCurentDateTime()));

                $flag = $this->Mcustomers->save(['token_reset' => '', 'token' => $token, 'customer_status_id' => STATUS_ACTIVED, 'updated_at' => getCurentDateTime()], $customer['id']);
                if($flag) {
                    if(empty($customer['customer_avatar'])) $customer['customer_avatar'] = base_url(CUSTOMER_PATH.NO_IMAGE);
                    else $customer['customer_avatar'] = base_url(CUSTOMER_PATH.$customer['customer_avatar']);
                    $customer['token'] = $token;
                    unset($customer['token_reset'], $customer['customer_password'], $customer['created_at'], $customer['created_by'], $customer['updated_at'],  $customer['updated_by'],  $customer['deleted_at']);
                    $this->success200(array('customer' => $customer));
                } else {
                    $this->error400('Account activation failed');
                    die;
                }
            } else {
                $this->error204('Token does not exist or account has been activated');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function remove_coupon() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('coupon_id'));
            $postData['customer_id'] = $customer['customer_id'];
            if (empty($postData['coupon_id']) && $postData['coupon_id'] < 0) {
                $this->error204($this->lang->line('incorrect-information1635566199'));
                die;
            }
            $this->load->model('Mcustomercoupons');
            $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_id' => $postData['customer_id'], 'coupon_id' => $postData['coupon_id']), 'id', 0);
            if($customerCouponId) {
                $flag = $this->Mcustomercoupons->save(['customer_coupon_status_id' => 0, 'deleted_at' => getCurentDateTime()]);
                if($flag) {
                    $this->success200('', $this->lang->line('successfully-removed!1635566199'));
                    die;
                } else {
                    $this->error204($this->lang->line('coupon-code-not-exist1635566199'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('coupon-code-not-exist1635566199'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function remove_event() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(true);
            $postData = $this->arrayFromPostRawJson(array('event_id'));
            $postData['customer_id'] = $customer['customer_id'];
            if (empty($postData['event_id']) && $postData['event_id'] < 0) {
                $this->error204($this->lang->line('incorrect-information1635566199'));
                die;
            }
            $this->loadModel(array('Mevents', 'Mcustomerevents'));

            $customerEventId = $this->Mcustomerevents->getFieldValue(array('customer_id' => $postData['customer_id'], 'event_id' => $postData['event_id'], 'customer_event_status_id > ' => 0), 'id', 0);

            if ($customerEventId > 0) {
                $flag = $this->Mcustomerevents->updateBy(
                    array(
                        'customer_id' => $postData['customer_id'],
                        'event_id' => $postData['event_id']
                    ),
                    array(
                        'customer_event_status_id' => 0
                    )
                );
                if($flag) {
                    $this->success200('', $this->lang->line('you-have-left-the-event1635566199'));
                    die;
                } else {
                    $this->error204($this->lang->line('the-event-has-ended-or-does-no1635566199'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('the-event-has-ended-or-does-no1635566199'));
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function update_profile() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostApi(array('customer_first_name', 'customer_last_name', 'customer_birthday', 'customer_gender_id', 'customer_phone', 'customer_phone_code', 'customer_occupation', 'customer_address'));
            
            $this->checkValidateCustomerProfile($postData);
            
            if(isset($_FILES['customer_avatar']) && !empty($_FILES['customer_avatar'])){
                $file = $_FILES['customer_avatar'];
                if ($file['error'] > 0) {
                    $this->error204('Avatar update failed');
                    die;
                } else {
                    $names = explode('.', $file['name']);
                    $fileExt = strtolower($names[count($names) - 1]);
                    if(in_array($fileExt, array('jpeg', 'jpg', 'png'))) {
                        $dir = CUSTOMER_PATH . date('Y-m-d') . '/';
                        @mkdir($dir, 0777, true);
                        @system("/bin/chown -R nginx:nginx " . $dir);
                        $filePath = $dir . uniqid() . '.' . $fileExt;
                        $flag = move_uploaded_file($file['tmp_name'], $filePath);
                        if ($flag) {
                            $photo = replaceFileUrl($filePath, CUSTOMER_PATH);
                            $postData['customer_avatar'] = $photo;
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
            $this->loadModel(array('Mcustomers'));
            $checkExit = $this->Mcustomers->get($customer['customer_id']);
            if($checkExit && $checkExit['customer_status_id'] == STATUS_ACTIVED) {
                $postData['customer_birthday'] = ddMMyyyy($postData['customer_birthday'], 'Y-m-d');
                $postData['updated_at'] = getCurentDateTime();
                $postData['updated_by'] = 0;
                $postData['language_id'] = $this->languageId;

                $flag = $this->Mcustomers->save($postData, $customer['customer_id']);
                $postData['customer_email'] = $checkExit['customer_email'];
                $postData['customer_birthday'] = ddMMyyyy($postData['customer_birthday'], 'Y/m/d');
                $postData['id'] = $flag;
                $postData['customer_avatar'] = !empty($postData['customer_avatar']) ? base_url(CUSTOMER_PATH.$postData['customer_avatar']) : '';
                if($flag) {
                    $this->success200($postData, 'Successfully updated account information');
                    die;
                } else {
                    $this->error204('Invalid account information update');
                    die;
                }
            } else {
                $this->error204('Invalid account information update');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    private function checkValidateCustomerProfile($postData) {
        if(empty($postData['customer_first_name'])) {
            $this->error204('Please enter the first name');
            die;
        }
        if(empty($postData['customer_last_name'])) {
            $this->error204('Please enter the last name');
            die;
        }
        if(empty($postData['customer_birthday'])) {
            $this->error204('Please enter your date of birth');
            die;
        }
        if(empty($postData['customer_gender_id']) && $postData['customer_gender_id'] < 0 && $postData['customer_gender_id'] > 4) {
            $this->error204('Please enter gender');
            die;
        }
        if(empty($postData['customer_phone'])) {
            $this->error204('Invalid phone number');
            die;
        }
        if(empty($postData['customer_phone_code'])) {
            $this->error204('Please enter phone code');
            die;
        }
        if(empty($postData['customer_occupation'])) {
            $this->error204('Please enter occupation');
            die;
        }
        if(empty($postData['customer_address'])) {
            $this->error204('Please enter address');
            die;
        }
    }

    public function update_password() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('current_password', 'customer_password', 'confirm_password'));
            
            $this->loadModel(array('Mcustomers'));
            $checkExit = $this->Mcustomers->get($customer['customer_id']);
            if(!$checkExit) {
                $this->error204('Accounts doesn’t doing');
                die;
            }
            if(md5($postData['current_password']) != $checkExit['customer_password']) {
                $this->error204('Current password is incorrect');
                die;
            }
            $this->validatePassWord($postData);
            $data['customer_password'] = md5($postData['customer_password']);
            $data['updated_at'] = getCurentDateTime();
            $data['updated_by'] = 0;
            $data['language_id'] = $this->languageId;

            $flag = $this->Mcustomers->save($data, $customer['customer_id']);
            if($flag) {
                $this->success200('', 'Password update successful');
                die;
            } else {
                $this->error204('Invalid account information update');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}