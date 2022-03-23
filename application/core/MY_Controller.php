<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db_slave = $this->load->database('slave', TRUE);
        $this->db_master = $this->load->database('master', TRUE);
        if (function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Bangkok');
        // $user = $this->Musers->get(1); $this->session->set_userdata('user', $user);

    }

    protected function commonData($user, $title, $data = array())
    {
        $data['user'] = $user;
        $data['title'] = $title;
        $data['listActions'] = $this->Mactions->getByUserId($user['id']);
        return $data;
    }

    protected function commonDataCustomer($title, $data = array())
    {
        $data['customer'] = $this->checkLoginCustomer();
        $data['title'] = $title;
        $this->load->model('Mservices');
        $this->load->model('Mconfigs');
        if ($data['customer']['language_id'] == 0) $language_id = $this->Mconstants->languageDefault;
        else $language_id = $data['customer']['language_id'];
        $data['configs'] = $this->Mconfigs->getListMap();

        $data['menuServices'] = $this->Mservices->getServiceMenus($language_id);
        $data['language_id'] =  $language_id;
        $this->load->model('Mcustomernotifications');
        

        $readNoti = $this->input->get('readNoti');
        if(!empty($readNoti) && $readNoti > 0){
            $this->Mcustomernotifications->save(
                array(
                    'notification_status_id' => 1
                ),
                $readNoti
            );
        }

        $data['notiBadge'] = $this->Mcustomernotifications->getCount(array('customer_id' => $data['customer']['id'], 'notification_status_id' => STATUS_ACTIVED));
        $data['notiHeader'] = $this->getNotificationLists(array('customer_id' => $data['customer']['id']), 5, 1);
        
        return $data;
    }

    // check login phía quản trị
    protected function checkUserLogin($isApi = false)
    {
        $user = $this->rsession->get('user');
        if ($user) {
            $statusId = STATUS_ACTIVED; // $this->Musers->getFieldValue(array('UserId' => $user['UserId']), 'StatusId', 0);
            if ($statusId == STATUS_ACTIVED) {
                return $user;
            } else {
                $this->rsession->delete('user');
                //$fields = array('user', 'configs');
                //foreach($fields as $field) $this->session->unset_userdata($field);
                if ($isApi) echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
                else redirect('sys-admin?redirectUrl=' . current_url());
                die();
            }
        } else {
            if ($isApi) echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
            else redirect('sys-admin?redirectUrl=' . current_url());
            die();
        }
    }

    // check ngôn ngữ và login phía customer (end user)
    protected function checkLoginCustomer($language_id = 0)
    {
        $this->load->helper('cookie');
        $customers = json_decode($this->input->cookie('customer', true), true);
        if (isset($customers) && $customers['id'] > 0) {
            // check login customer
            $this->load->model('Mcustomers');
            $customers = $this->Mcustomers->get($customers['id'], true, "", "customer_email, customer_first_name, customer_last_name, customer_avatar, customer_phone, customer_phone_code, id, language_id, login_type_id");
            $customers['is_logged_in'] = 1;
            $customers['language_id'] = $customers['language_id'] == 0 ? $this->Mconstants->languageDefault : $customers['language_id'];
            $customers['language_name'] = $customers['language_id'] == 0 ? $this->Mconstants->languageCodes[$this->Mconstants->languageDefault] : $this->Mconstants->languageCodes[$customers['language_id']];
        } else {
            // customer not login
            if (empty($customers) || $customers == NULL) {
                // nếu customer ko chọn ngôn ngữ sẽ gán ngôn ngữ tiếng anh
                $customers = array('language_id' => $this->Mconstants->languageDefault, 'language_name' => $this->Mconstants->languageCodes[$this->Mconstants->languageDefault], 'id' => 0);
            } else {
                $customers = array('language_id' => $customers['language_id'], 'language_name' => $customers['language_name'], 'id' => 0);
            }
            $customers['is_logged_in'] = 0;
        }
        if ($language_id > 0) {
            $customers['language_id'] = $language_id;
            $customers['language_name'] = $this->Mconstants->languageCodes[$language_id];
        }
        $this->input->set_cookie($this->configValueCookie('customer', json_encode($customers)));
        return $customers;
    }

    protected function loadModel($models = array())
    {
        foreach ($models as $model) $this->load->model($model);
    }

    protected function arrayFromPost($fields)
    {
        $data = array();
        foreach ($fields as $field) $data[$field] = trim($this->input->post($field));
        return $data;
    }

    protected function arrayFromGet($fields)
    {
        $data = array();
        foreach ($fields as $field) $data[$field] = trim($this->input->get($field));
        return $data;
    }

    protected function checkPermission($roleId)
    {
        $flag = false;
        if ($roleId == 1) $flag = true;
        return $flag;
    }

    //api
    protected function openAllCors()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        //header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: application/json');
        $this->logError();
    }

    protected function logError()
    {
        log_message('error', $this->router->fetch_class() . '/' . $this->router->fetch_method() . ': Server: ' . json_encode($_SERVER));
        log_message('error', $this->router->fetch_class() . '/' . $this->router->fetch_method() . ': Input: ' . file_get_contents('php://input'));
        log_message('error', '=======================================');
    }

    protected function configValueCookie($name = 'customer', $value = '', $expire = '7200')
    {
        return array(
            'name'   => $name,
            'value'  => $value, //json_encode(array('language_id' => $languageId, 'language_name' => $language, 'id' => 0)),                            
            'expire' => $expire

        );
    }

    /**
     * Check business open or closed
     */
    protected function checkBusinessOpenHours($businessId = 0)
    {
        $this->load->model('Mopeninghours');
        $dayId = date('N', strtotime(date('Y-m-d'))) - 1;
        $query = "SELECT id FROM `opening_hours`
            WHERE business_profile_id = ".$businessId." AND day_id = ".$dayId." AND start_time <= CURTIME() AND CURTIME() <= end_time AND opening_hours_status_id = 2";
        $checkTime = count($this->Mopeninghours->getByQuery($query));
        if($checkTime) return true;
        else return false;
    }

    /**
     * Send email
     */

    protected function sendMail($emailFrom, $nameFrom, $emailTo, $nameTo, $subject, $message)
    {
        //$this->load->library('email');
        // $config = Array(
        //     'protocol'  => 'smtp',
        //     'smtp_host' => 'ssl://smtp.googlemail.com',
        //     'smtp_port' => '465',
        //     'smtp_user' => 'mailout.dkh@gmail.com',
        //     'smtp_pass' => 'fqvpygxkmeotvqfz',
        //     'mailtype'  => 'html',
        //     'starttls'  => true,
        //     'newline'   => "\r\n"
        // );

        //smtpout.asia.secureserver.net

        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => EMAIL_HOST,
            'smtp_port' => EMAIL_PORT,
            'smtp_user' => EMAIL_USER,
            'smtp_pass' => EMAIL_PASS,
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
        );

        $this->load->library('email', $config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($emailFrom, $nameFrom);
        $this->email->to($emailTo, $nameTo);
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send()) return true;
        return false;
    }

    /**
     * Send mail with attachment
     */
    protected function sendMailFile($emailFrom, $nameFrom, $emailTo, $nameTo,$subject, $message, $file_attach = "https://adb.xproz.com/assets/uploads/sample.pdf"){
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => EMAIL_HOST,
            'smtp_port' => EMAIL_PORT,
            'smtp_user' => EMAIL_USER,
            'smtp_pass' => EMAIL_PASS,
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
        );

        $this->load->library('email', $config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($emailFrom, $nameFrom);
        $this->email->to($emailTo, $nameTo);
        $this->email->subject($subject);
        $this->email->message($message);
        
        // Attach file into email
        if(!empty($file_attach)) {
            $this->email->attach($file_attach);   
        }
        
        if ($this->email->send()) return true;
        return false;
    }


    /**
     * example
     * example public function index() {
     *    $flag =  $this->sendMail('facebook12636@gmail.com', 'man', 'haminhman2011@gmail.com', 'Gửi mail', 'ahhihi');
     *    echo 'kkk'.$flag;die;
     * }
     */

    /**
     * Custom Upload without POST
     */

    public function uploadImageBase64($fileBase64 = "", $fileTypeId = 0)
    {
        if (!empty($fileBase64) & $fileTypeId > 0) {
            $fileBase64 = str_replace('[removed]', '', $fileBase64);
            $dir = '';
            $fileExt = 'png';
            if ($fileTypeId == 1) $dir = PRODUCT_PATH;
            elseif ($fileTypeId == 2) $dir = USER_PATH;
            elseif ($fileTypeId == 3) $dir = CUSTOMER_PATH;
            elseif ($fileTypeId == 4) $dir = SLIDER_PATH;
            elseif ($fileTypeId == 5) $dir = CONFIG_PATH;
            elseif ($fileTypeId == 6) $dir = SERVICE_PATH;
            elseif ($fileTypeId == 7) $dir = BUSINESS_PROFILE_PATH;
            elseif ($fileTypeId == 8) $dir = COUPONS_PATH;
            elseif ($fileTypeId == 9) $dir = EVENTS_PATH;

            if (!empty($dir)) {
                $dir = $dir . date('Y-m-d') . '/';
                @mkdir($dir, 0777, true);
                @system("/bin/chown -R nginx:nginx " . $dir);
                if ($fileExt == 'png') $fileBase64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $fileBase64));
                else $fileBase64 = base64_decode(preg_replace('#^data:application/\w+;base64,#i', '', $fileBase64));
                $filePath = $dir . uniqid() . '.' . $fileExt;
                $flag = file_put_contents($filePath, $fileBase64);
                if ($flag !== false) {
                    return $filePath;
                }
            }
        }
        return "";
    }

    public function getLanguageFE()
    {
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('login', $this->language);
        $this->lang->load('customer', $this->language);
        $this->lang->load('business_profile', $this->language);
        $this->lang->load('business_management', $this->language);
        $this->lang->load('user_account_management', $this->language);
        $this->lang->load('email', $this->language);
    }

    public function getNotificationLists($searchData = array(), $perPage = 50, $page = 0)
    {
        $this->loadModel(array('Mbusinessprofiles', 'Mevents', 'Mcustomernotifications', 'Mcustomers', 'Mcustomerreservations', 'Mcustomerreviews'));

        $lists = $this->Mcustomernotifications->search($searchData, $perPage, $page);

        if (!empty($lists)) {
            foreach ($lists as $i => $notificationInfo) {

                $notificationText = "";
                $notificationImg = CUSTOMER_PATH . NO_IMAGE;
                $notificationUrl = "javascript:void(0);";
                if ($notificationInfo['notification_type'] == 0) {
                    //busines has review
                    $customerImg = $this->Mcustomers->getFieldValue(array('id' =>  $notificationInfo['customer_id']), 'customer_avatar', '');
                    if (!empty($customerImg)) {
                        $notificationImg = CUSTOMER_PATH . $customerImg;
                    }
                    $businessName = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_name', '');
                    $businessUrl = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_url', '');
                    $find = array('<BUSINESS_NAME>');
                    $replace = array($businessName);
                    //$notificationText = $businessName . " had just a review";
                    $notificationText = str_replace($find, $replace, $this->lang->line('business_name_had_just_a_review'));

                    $notificationUrl = base_url('business-management/'.$businessUrl.'/reviews');
                } else if ($notificationInfo['notification_type'] == 1) {
                    // business reply customer review
                    $businessImg = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_avatar', '');
                    if (!empty($businessImg)) {
                        $notificationImg = BUSINESS_PROFILE_PATH . $businessImg;
                    }
                    $businessName = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_name', '');
                    $businessUrl = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_url', '');
                    //$notificationText = $businessName . " replied to your comment";

                    $find = array('<BUSINESS_NAME>');
                    $replace = array($businessName);
                    $notificationText = str_replace($find, $replace, $this->lang->line('business_name_replied_to_your_comment'));

                    $notificationUrl = base_url('business/'.$businessUrl.'/reviews');
                } else if ($notificationInfo['notification_type'] == 2) {
                    // Event start in next 24h

                    $eventInfo = $this->Mevents->get($notificationInfo['item_id']);
                    $businessInfo = $this->Mbusinessprofiles->get($notificationInfo['business_id']);

                    if (!empty($eventInfo['event_image'])) {
                        $notificationImg = EVENTS_PATH . $eventInfo['event_image'];
                    }
                    

                    $find = array('<BUSINESS_NAME>', '<EVENT_NAME>');
                    $replace = array($businessInfo['business_name'], $eventInfo['event_subject']);
                    $notificationText = str_replace($find, $replace, $this->lang->line('noti_event_happen_in_next_24h'));

                    $notificationUrl = base_url('customer/my-events');

                } else if ($notificationInfo['notification_type'] == 3) {
                    // Event updated

                    $eventInfo = $this->Mevents->get($notificationInfo['item_id']);
                    $businessInfo = $this->Mbusinessprofiles->get($notificationInfo['business_id']);

                    if (!empty($eventInfo['event_image'])) {
                        $notificationImg = EVENTS_PATH . $eventInfo['event_image'];
                    }
                    
                    $find = array('<BUSINESS_NAME>', '<EVENT_NAME>');
                    $replace = array($businessInfo['business_name'], $eventInfo['event_subject']);
                    $notificationText = str_replace($find, $replace, $this->lang->line('noti_event_updated'));

                    $notificationUrl = base_url('customer/my-events');
                } else if ($notificationInfo['notification_type'] == 4) {
                    // Event cancelled

                    $eventInfo = $this->Mevents->get($notificationInfo['item_id']);
                    $businessInfo = $this->Mbusinessprofiles->get($notificationInfo['business_id']);

                    if (!empty($eventInfo['event_image'])) {
                        $notificationImg = EVENTS_PATH . $eventInfo['event_image'];
                    }
                    

                    $find = array('<BUSINESS_NAME>', '<EVENT_NAME>');
                    $replace = array($businessInfo['business_name'], $eventInfo['event_subject']);
                    $notificationText = str_replace($find, $replace, $this->lang->line('noti_event_canceled'));

                    $notificationUrl = base_url('customer/my-events');
                } else if ($notificationInfo['notification_type'] == 5) {
                    // reservation start in 15 minutes
                    $businessInfo = $this->Mbusinessprofiles->get($notificationInfo['business_id']);
                    $reservationCode = $this->Mcustomerreservations->getFieldValue(array('id' => $notificationInfo['item_id']), 'book_code', '');
                    
                    if (!empty($businessInfo['business_avatar'])) {
                        $notificationImg = BUSINESS_PROFILE_PATH . $businessInfo['business_avatar'];
                    }

                    $find = array('<RESERVATION_ID>', '<BUSINESS_NAME>');
                    $replace = array($reservationCode, $businessInfo['business_name']);
                    $notificationText = str_replace($find, $replace, $this->lang->line('noti_reservation_happen_in_the_next_15_minutes'));
                    $notificationUrl = base_url('customer/my-reservation');
                } else if ($notificationInfo['notification_type'] == 6) {
                    // customer cancel reservation
                    $customerImg = $this->Mcustomers->getFieldValue(array('id' =>  $notificationInfo['customer_id']), 'customer_avatar', '');
                    if (!empty($customerImg)) {
                        $notificationImg = CUSTOMER_PATH . $customerImg;
                    }
                    $businessUrl = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_url', '');
                    $reservationCode = $this->Mcustomerreservations->getFieldValue(array('id' => $notificationInfo['item_id']), 'book_code', '');
                    //$notificationText = "Reservation " . $reservationCode . " has been cancelled";
                    $find = array('<RESERVATION_ID>');
                    $replace = array($reservationCode);
                    $notificationText = str_replace($find, $replace, $this->lang->line('reservation_id_has_been_canceled'));
                    $notificationUrl = base_url('business-management/'.$businessUrl.'/reservations');
                } else if ($notificationInfo['notification_type'] == 7) {
                    // business decline reservation
                    $businessImg = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_avatar', '');
                    if (!empty($businessImg)) {
                        $notificationImg = BUSINESS_PROFILE_PATH . $businessImg;
                    }
                    $businessName = $this->Mbusinessprofiles->getFieldValue(array('id' =>  $notificationInfo['business_id']), 'business_name', '');
                    $reservationCode = $this->Mcustomerreservations->getFieldValue(array('id' => $notificationInfo['item_id']), 'book_code', '');
                    //$notificationText = "Reservation " . $reservationCode . " at " . $businessName . " has been declined";
                    $find = array('<RESERVATION_ID>','<BUSINESS_NAME>');
                    $replace = array($reservationCode, $businessName);
                    $notificationText = str_replace($find, $replace, $this->lang->line('reservation__id__at__businessname_has_been_declined'));
                    $notificationUrl = base_url('customer/my-reservation');
                } else if ($notificationInfo['notification_type'] == 8) {
                    // business trial end
                    $businessInfo = $this->Mbusinessprofiles->get($notificationInfo['business_id']);

                    if (!empty($businessInfo['business_avatar'])) {
                        $notificationImg = BUSINESS_PROFILE_PATH . $businessInfo['business_avatar'];
                    }
                    
                    $find = array('<BUSINESS_NAME>');
                    $replace = array($businessInfo['business_name']);
                    $notificationText = str_replace($find, $replace, $this->lang->line('noti_subscription_trial_end'));
                    $notificationUrl = base_url('business-management/'.$businessInfo['business_url'].'/subscriptions');
                } else if ($notificationInfo['notification_type'] == 9) {
                    // business renew subsciption failed
                    $businessInfo = $this->Mbusinessprofiles->get($notificationInfo['business_id']);

                    if (!empty($businessInfo['business_avatar'])) {
                        $notificationImg = BUSINESS_PROFILE_PATH . $businessInfo['business_avatar'];
                    }
                    
                    $find = array('<BUSINESS_NAME>');
                    $replace = array($businessInfo['business_name']);
                    $notificationText = str_replace($find, $replace, $this->lang->line('noti_renew_subscription_failed'));
                    $notificationUrl = base_url('business-management/'.$businessInfo['business_url'].'/subscriptions');
                }

                $lists[$i]['text'] = $notificationText;
                $lists[$i]['image'] = $notificationImg;
                $readNoti = '';
                if($lists[$i]['notification_status_id'] == STATUS_ACTIVED){
                    $readNoti = '?readNoti='.$lists[$i]['id'];
                }
                $lists[$i]['url'] = $notificationUrl.$readNoti;
            }
        }
        return $lists;
    }

    public function getBusinessRating($businessProfileId = 0)
    {
        $data = array();

        if ($businessProfileId > 0) {
            $this->load->model('Mcustomerreviews');
            $data['count_one_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 1
            ));

            $data['count_two_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 2
            ));

            $data['count_three_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 3
            ));

            $data['count_four_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 4
            ));

            $data['count_five_star'] = $this->Mcustomerreviews->getCount(array(
                'customer_review_status_id' => STATUS_ACTIVED,
                'business_id' => $businessProfileId,
                'review_star' => 5
            ));

            $sumReview = ($data['count_one_star'] + $data['count_two_star'] + $data['count_three_star'] + $data['count_four_star'] + $data['count_five_star']);
            $data['sumReview'] = $sumReview;
            $data['overall_rating'] = 0;
            if ($sumReview > 0) {
                $data['overall_rating'] = ($data['count_one_star'] * 1 + $data['count_two_star'] * 2 + $data['count_three_star'] * 3 + $data['count_four_star'] * 4 + $data['count_five_star'] * 5) / ($data['count_one_star'] + $data['count_two_star'] + $data['count_three_star'] + $data['count_four_star'] + $data['count_five_star']);
            }
        }

        return $data;
    }

    public function formatDate($startDate = '', $endDate = '')
    {
        $startDate = date('Y-m-d H:i', strtotime($startDate));
        if (empty($endDate)) $endDate = date('Y-m-d H:i');

        $diff = abs(strtotime(date('Y-m-d',  strtotime($startDate))) - strtotime(date('Y-m-d',  strtotime($endDate))));

        //Tính ra tông số ngày của 2 khoản thời gian
        $interval = date_diff(date_create(date('Y-m-d', strtotime($startDate))), date_create(date('Y-m-d', strtotime($endDate))))->format('%a %d %R %y');

        $parts = explode(' ', $interval);

        // Lấy ra tổng số ngày
        $totalDays = intval($parts[0]);
        $beforeOrAfter = $parts[2];

        // Tính ra ngày tháng năm

        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        $hours = strtotime(date('H:i', strtotime($startDate))); // Giờ
        $showTime = '';
        //Nếu >= 365 lấy ra năm
        if ($totalDays >= 365) {
            //Nếu  Delta X >= 15 >> M = M + 1 Lên tháng
            if ($days >= 15) {
                $months += 1;
            }

            if ($beforeOrAfter == '-' && intval($parts[1]) == 1) {
                $showTime = "Ngày mai, ";
            } else if ($beforeOrAfter == '+' && intval($parts[1]) == 1) {
                $showTime = "Hôm qua, ";
            } else if ($beforeOrAfter == '-' && intval($parts[1]) == 2) {
                $showTime = "Ngày kia, ";
            } else if ($beforeOrAfter == '+' && intval($parts[1]) == 2) {
                $showTime = "Hôm kia, ";
            } else if (($beforeOrAfter == '+' || $beforeOrAfter == '-') && intval($parts[1]) == 0) {
                $showTime = "Hôm nay, ";
            }

            if (in_array($months, [1, 2])) {
                $showTime .= 'Hơn ' . $years . ' năm';
            } else if (in_array($months, [3, 4, 8, 9])) {
                $showTime .= $years . ' năm ' . $months . ' tháng';
            } else if ($months == 5) {
                $showTime .= 'Gần ' . $years . ' năm rưỡi';
            } else if ($months == 6) {
                $showTime .= $years . ' năm rưỡi';
            } else if ($months == 7) {
                $showTime .= 'Hơn ' . $years . ' năm rưỡi';
            } else if (in_array($months, [10, 11])) {
                $showTime .= 'Gần ' . ($years + 1) . ' năm';
            } else if ($months == 0) {
                $showTime .= $years . ' năm';
            } else if ($months == 12) {
                $showTime .= ($years + 1) . ' năm';
            }

            $showTime .= $this->dateBeforeOrAgain($beforeOrAfter);
        } else if ($totalDays >= 30) {
            if ($days >= 1 && $days <= 10) {
                $showTime = 'Hơn ' . $months . ' tháng';
            } else if (in_array($days, [11, 12])) {
                $showTime = 'Gần ' . $months . ' tháng rưỡi';
            } else if ($days >= 13 && $days <= 17) {
                $showTime = $months . ' tháng rưỡi';
            } else if (in_array($days, [18, 19])) {
                $showTime = 'Hơn ' . $months . ' tháng rưỡi';
            } else if ($days >= 20 && $days <= 29) {
                $showTime = 'Gần ' . ($months + 1) . ' tháng';
            }
            $showTime .= $this->dateBeforeOrAgain($beforeOrAfter);
        } else if ($totalDays >= 1) {
            //Nếu >= 1 lấy ra ngày
            if ($days == 1) {
                $showTime = $this->dateDiff($hours, $beforeOrAfter, $days);
            } else if ($days == 2) {
                $showTime = $this->dateDiff($hours, $beforeOrAfter, $days);
            } else if ($days >= 3 && $days <= 6) {
                $showTime = $days . ' ngày';
            } else if ($days == 7) {
                $showTime = '1 tuần';
            } else if ($days >= 8 && $days <= 11) {
                $showTime = $days . ' ngày';
            } else if (in_array($days, [12, 13])) {
                $showTime = 'Gần 2 tuần';
            } else if ($days == 14) {
                $showTime = '2 tuần';
            } else if (in_array($days, [15, 16, 17])) {
                $showTime = 'Hơn nữa tháng';
            } else if (in_array($days, [18, 19, 20])) {
                $showTime = 'Gần 3 tuần';
            } else if ($days == 21) {
                $showTime = '3 tuần';
            } else if (in_array($days, [22, 23, 24])) {
                $showTime = 'Hơn 3 tuần';
            } else if ($days >= 25 && $days <= 29) {
                $showTime = 'Gần 1 tháng';
            }

            if (!in_array($days, [0, 1, 2])) {
                $showTime .= $this->dateBeforeOrAgain($beforeOrAfter);
            }
        } else if ($totalDays == 0) {
            $showTime .= $this->dateDiff($hours, $beforeOrAfter, $days);
        }
        return $showTime;
        // echo json_encode(array('code' => 1, 'data' => $showTime));
    }

    public function dateBeforeOrAgain($beforeOrAfter = '')
    {
        $text = '';
        if ($beforeOrAfter == '-') {
            $text = ' nữa';
        } else if ($beforeOrAfter == '+') {
            $text = ' trước';
        }
        return $text;
    }

    public function dateDiff($time = 0, $beforeOrAfter = '', $days = 0){
        $dayTime = '';
        if ($time > strtotime("00:00") && $time < strtotime("11:00")) {
            $dayTime = 'Sáng ';
        } else if ($time >= strtotime("11:00") && $time < strtotime("13:30")) {
            $dayTime = 'Trưa ';
        } else if ($time >= strtotime("13:30") && $time < strtotime("17:30")) {
            $dayTime = 'Chiều ';
        } else if ($time >= strtotime("17:30") && $time < strtotime("24:00")) {
            $dayTime = 'Tối ';
        }

        /**
         * + là tương lai
         * - là quá khứ
         */

        if ($beforeOrAfter == '-' && $days == 1) {
            $dayTime .= "ngày mai";
        } else if ($beforeOrAfter == '+' && $days == 1) {
            $dayTime .= "hôm qua";
        } else if ($beforeOrAfter == '-' && $days == 2) {
            $dayTime .= "ngày kia";
        } else if ($beforeOrAfter == '+' && $days == 2) {
            $dayTime .= "hôm kia";
        } else if (($beforeOrAfter == '+' || $beforeOrAfter == '-') && $days == 0) {
            $dayTime .= "hôm nay";
        }


        return $dayTime;
    }

    /**
     * Check subscription transaction
     */
    public function checkPaymentSubscription($paypalUser)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => PAYPAL_HOST . '/v1/billing/subscriptions/'.$paypalUser['subscriptionId'].'/transactions?start_time='.$paypalUser['startTime'].'&end_time='.$paypalUser['endTime'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode(PAYPAL_CLIENT_KEY . ':' . PAYPAL_SEC_KEY),
                'Prefer: return=representation',
                'Content-Type: application/json'
            ),
        ));

        $response2 = curl_exec($curl);

        curl_close($curl);
        $result = json_decode($response2);
        return $result;
    }

    /**
     * Cancel subscriptions
     */
    public function cancelSubscription($paypalUser)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => PAYPAL_HOST . '/v1/billing/subscriptions/'.$paypalUser['subscriptionId'].'/cancel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
              "reason": "'.$paypalUser['reasonCancel'].'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode(PAYPAL_CLIENT_KEY . ':' . PAYPAL_SEC_KEY),
                'Prefer: return=representation',
                'Content-Type: application/json'
            ),
        ));

        $response2 = curl_exec($curl);

        curl_close($curl);
        $result = json_decode($response2);
        return $result;
    }

    //========================================api==========================//
    protected function arrayFromPostRawJson($fields) {
        $data = json_decode(file_get_contents('php://input'), true);
        $outPut = array();
        $outPutFalse = '';

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $outPut[$field] = ($data[$field]);
            } else {
                $outPutFalse .= $field.", ";
                // $outPut[$field] = null;
            }
        }
        // if(!empty($outPutFalse)) {
        //     $this->error410(rtrim($outPutFalse, ', ').': Missing input variable');
        //     die;
        // }
        // else 
        return $outPut;
    }

    protected function arrayFromPostApi($fields) {
        $data = array();
        $outPutFalse = '';
        foreach ($fields as $field) {
            if (isset($_POST[$field]) && $_POST[$field] >= 0) {
                $data[$field] = trim($this->input->post($field));
            } else {
                $outPutFalse .= $field.", ";
            }
            
        }
        // if(!empty($outPutFalse)) {
        //     $this->error410(rtrim($outPutFalse, ', ').': Missing input variable');
        //     die;
        // }
        // else 
        return $data;

        
    }

    public function getLanguageApi($loadAll = false) {
        $languageId = $this->input->get_request_header('language-id', TRUE);
        $languageId = !empty($languageId) ? $languageId : 3;
        $language = $this->Mconstants->languageCodes[$languageId];
        $this->language =  $language;
        $this->lang->load('mobile', $this->language);
        if($loadAll) {
            $this->lang->load('login', $this->language);
            $this->lang->load('customer', $this->language);
            $this->lang->load('business_profile', $this->language);
            $this->lang->load('business_management', $this->language);
            $this->lang->load('user_account_management', $this->language);
            $this->lang->load('email', $this->language);
        }
        $languageId = $this->input->get_request_header('language-id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 3;
        $this->langCode = '_de';
        if ($this->languageId == STATUS_NUMBER_ONE) $this->langCode = '_en';
        elseif ($this->languageId == STATUS_NUMBER_TWO) $this->langCode = '_cz';
        elseif ($this->languageId == STATUS_NUMBER_FOR) $this->langCode = '_vi';
    }

    public function getLanguageApiNotify($loadAll = false, $languageId = 3) {
        $language = $this->Mconstants->languageCodes[$languageId];
        $this->language =  $language;
        $this->lang->load('mobile', $this->language);
        if($loadAll) {
            $this->lang->load('login', $this->language);
            $this->lang->load('customer', $this->language);
            $this->lang->load('business_profile', $this->language);
            $this->lang->load('business_management', $this->language);
            $this->lang->load('user_account_management', $this->language);
            $this->lang->load('email', $this->language);
        }
        $languageId = $this->input->get_request_header('language-id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
        $this->langCode = '_vi';
        if ($this->languageId == STATUS_NUMBER_ONE) $this->langCode = '_en';
        elseif ($this->languageId == STATUS_NUMBER_THREE) $this->langCode = '_cz';
        elseif ($this->languageId == STATUS_NUMBER_FOR) $this->langCode = '_de';
    }

    protected function apiCheckLogin($flag = false) {
        $token = $this->getAuthorizationHeader();
        // $token = $this->input->get_request_header('X-Auth-Token', TRUE);
        if(!empty($token)) {
            $this->load->model('Mcustomers');
            $id = $this->Mcustomers->getFieldValue(array('token' => $token, 'customer_status_id' => STATUS_ACTIVED), 'id', 0);
            if($id == 0) {
                $this->error401($this->lang->line('account_does_not_exist'));
                die;
            }
            return ['customer_id' => $id];
        } else {
            if($flag == false) {
                $this->error401($this->lang->line('you_do_not_have_permission_to_view_this_content_please_login'));
                die;
            } else return ['customer_id' => 0];
            
        }
    }

    protected function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        $token = '';
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                $token = $matches[1];
            }
        }
        return $token;
    }

    protected function error500($text = 'An error occurred, please try again') {
        echo json_encode(array(
            'code' => 500,
            'mesage' => $text
        ));
    }

    protected function error202($text = '') {
        if(empty($text)) $text = $this->lang->line('data_not_found');
        echo json_encode(array(
            'code' => 202,
            'message' => $text
        ));
    }

    protected function error401($text = '') {
        if(empty($text)) $text = $this->lang->line('account_does_not_exist');
        echo json_encode(array(
            'code' => 401,
            'message' => $text
        ));
    }

    protected function error410($text = '') {
        if(empty($text)) $text = $this->lang->line('invalid_syntax');
        echo json_encode(array(
            'code' => 410,
            'message' => $text
        ));
    }

    protected function success200($datas, $message = '') {
        if(empty($message)) $message = $this->lang->line('return_data');
        $data = array(
            'code' => 200,
            'message' => $message,
            'data' => $datas
        );
        if(empty($datas)) $data = array(
            'code' => 200,
            'message' => $message
        );
        echo json_encode($data);
    }

    protected function error204($text = '') {
        if(empty($text)) $text = $this->lang->line('list_is_empty');
        echo json_encode(array(
           'code' => 204,
           'message' => $text
        ));
    }

    public function getPaymentLink($paypalUser)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => PAYPAL_HOST . '/v1/billing/subscriptions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
              "plan_id": "' . $paypalUser['paypalPlanId'] . '",
              "application_context": {
                "return_url": "' . $paypalUser['successUrl'] . '",
                "cancel_url": "' . $paypalUser['cancelUrl'] . '"
              }
            }',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode(PAYPAL_CLIENT_KEY . ':' . PAYPAL_SEC_KEY),
                'Prefer: return=representation',
                'Content-Type: application/json'
            ),
        ));

        $response2 = curl_exec($curl);

        curl_close($curl);
        $pay = json_decode($response2);
        //echo "<pre>";print_r($pay);exit;
        return $pay->links['0']->href;
    }

    public function create_invoice_pdf($businessId = 0){

        if($businessId == 0) {
            return false;
        }

        $html = '<!DOCTYPE html>
        <html>
        <head>
          <meta charset="utf-8">
          <meta http-equiv="x-ua-compatible" content="ie=edge">
          <title>Invoice</title>
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <style type="text/css">
               * { font-family: DejaVu Sans, sans-serif; }
               table.border_table, table.border_table th, table.border_table td{
                    border:1px solid black;
                }
                table.border_table td{
                    padding: 5px;
                }
                table.border_table {
                    border-collapse:collapse;
                }
          </style>
        </head>
        <body style="background-color: #FFF;">
            <table width="100%">
                <tr>
                    <td><img src="data:image/jpeg;base64,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" width="180px" height="auto" ></td>
                    <td><h2>Payment Receipt</h2></td>
                </tr>
                <tr>
                    <td></td><td><i>Receipt No.: #RECEIPE_NUMBER</i></td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td><h3>Invoice to</h3></td><td></td>
                </tr>
                <tr>
                    <td>Name:   BUSINESS_NAME</td><td></td>
                </tr>
                <tr>
                    <td>Address: BUSINESS_ADDRESS</td><td></td>
                </tr>
                <tr>
                    <td>Business ID: BUSINESS_ID</td><td>VAT ID: BUSINESS_VAT_ID</td>
                </tr>
                <tr>
                    <td>Date: PAYMENT_DATE</td><td></td>
                </tr>
                <tr>
                    <td>Payment method: PAYMENT_METHOD</td><td></td>
                </tr>
            </table>
            <table  width="100%">
                <tr>
                    <td><h3>Your order summary</h3></td>
                </tr>
            </table>
            <table width="100%" class="border_table">
                <tr>
                    <td style="border-width: 1px;">Description</td><td style="border-width: 1px;">Amount</td>
                </tr>
                <tr>
                    <td>Price of Business_name</td><td>AMOUNT_PRICE CURRENCY</td>
                </tr>
                <tr>
                    <td>VAT (NUM_VAT%)</td><td>AMOUNT_VAT CURRENCY</td>
                </tr>
                <tr>
                    <td>Total</td><td>AMOUNT_TOTAL CURRENCY</td>
                </tr>
            </table>
            <p><i>If you have any question, please contact us at asiadragonbazar@adbazar.eu</i></p>
        </body>
        </html>';

        $findArray = array(
            'RECEIPE_NUMBER',
            'BUSINESS_NAME',
            'BUSINESS_ADDRESS',
            'BUSINESS_ID',
            'BUSINESS_VAT_ID',
            'PAYMENT_DATE',
            'PAYMENT_METHOD',
            'AMOUNT_PRICE',
            'AMOUNT_VAT',
            'NUM_VAT',
            'AMOUNT_TOTAL',
            'CURRENCY'
        );

        $this->load->model(array('Mbusinessprofiles', 'Mbusinesspayments', 'Mpaymentplans'));
        
        $businessInfo = $this->Mbusinessprofiles->get($businessId);
        
        $businessPaymentInfos = $this->Mbusinesspayments->getBy(array('business_profile_id' => $businessId), false, 'id','', 1, 0, 'DESC');

        $paymentInfo = $businessPaymentInfos[0];
        
        $planInfo = $this->Mpaymentplans->get($businessInfo['plan_id']);
        
        $replaceArray = array(
            $paymentInfo['id'], // receipe number
            $paymentInfo['payment_name'], // business  name
            $paymentInfo['payment_address'], // business address
            $paymentInfo['payment_company_id'], // business id
            $paymentInfo['payment_company_vat_id'], // business vat id
            ddMMyyyy($paymentInfo['created_at'], 'Y-m-d'), // payment date
            'Paypal', // payment method
            $planInfo['plan_amount'], // amount price
            intval($planInfo['plan_total'] - $planInfo['plan_amount']), // amount vat
            $planInfo['plan_vat'], // num vat
            $planInfo['plan_total'], // amount total
            ($planInfo['plan_currency_id'] == 1) ? 'CZK' : 'EUR' // currency
        );

        $html = str_replace($findArray, $replaceArray, $html);
        
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();

        //fake tạm
        $receipe_number = 1;
        $invoice_date = date('Y-m-d');

        $invoice_name = $receipe_number."_invoice_adbazar_".str_replace('/', '_', $invoice_date).".pdf";
        $invoice_path = INVOICE_PATH.$invoice_name;
        $output = $this->pdf->output();

        file_put_contents($invoice_path, $output);

        return base_url($invoice_path);
        
    }
}
