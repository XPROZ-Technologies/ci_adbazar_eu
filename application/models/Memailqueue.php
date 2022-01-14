<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Memailqueue extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name = "email_queue";
        $this->_primary_key = "id";
    }

    public function email_template($email_content = "")
    {
        $this->load->model('Mconfigs');
        $data = array(
            'content' => $email_content,
            'configs' => $this->Mconfigs->getListMap()
        );
        $data = $this->load->view('frontend/email/email_template', $data, TRUE);
        return $data;
    }

    public function verifyEmail($emailData = array())
    {
        $myProfileUrl = base_url('customer/verify-email?token='.$emailData['token']);

        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('email_verify_your_email_address').'</p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>'.$this->lang->line('email_welcome_to').'</p>
                            <p>'.$this->lang->line('email_please_click_the_button_below').'</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $myProfileUrl . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_verify_email').'</a>
                            </div>';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function successCreateAccount($emailData = array())
    {
        $myProfileUrl = base_url('customer/general-information');

        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('email_your_account_was_successfully_created').'</p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>'.$this->lang->line('email_thank_you_for_creating_your_account_at').'</p>
                            <p>'.$this->lang->line('emnai_we_would_like_to_confirm_that_your_account_was_created_successfully').'</p>
                            <p>'.$this->lang->line('email_best').',<br>AdBazar.</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $myProfileUrl . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('see_my_profile').'</a>
                            </div>';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function forgotPassword($emailData = array())
    {
        $urlAction = base_url('password-assistance?token='.$emailData['token']);

        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('22112021_email_password_assistance').'</p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>'.$this->lang->line('email_we_have_recieved_your_request_to_change').'</p>
                            <p>'.$this->lang->line('email_best').',<br>AdBazar.</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $urlAction . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_reset_password').'</a>
                            </div>';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function sendContactForm($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('email_contact_from_website').'</p>
                            <p>Dear Administrator,</p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_contact_customer_name').': ' . $emailData['contact_name'] . '</p>
                            <p>'.$this->lang->line('email_contact_contact_name').': ' . $emailData['contact_name'] . '</p>
                            <p>'.$this->lang->line('email_contact_contact_email').': ' . $emailData['contact_email'] . '</p>
                            <p>'.$this->lang->line('email_contact_message').': </p>
                            <p>' . nl2br($emailData['contact_message']) . '</p>
                            <p>&nbsp;</p>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function joinEvent($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('email_you_have_successfully_registered_to_join_the_event').'</p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>&nbsp;</p>
                            <p>'.str_replace(array('<EVENT_NAME>','<BUSINESS_NAME>'), array($emailData['event_name'], $emailData['business_name']), $this->lang->line('email_this_email_serves_to_join_the_event')).'</p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_you_can_check_the_event_details').'</p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_looking_forward_to_seeing_you').'</p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_best').',<br>AdBazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['event_url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_see_event_details').'</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function declineReservation($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('email_your_reservation_has_been_declined').'</p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_dear_name')).',</p>
                            <p>&nbsp;</p>
                            <p> '.str_replace(array('<BUSINESS_NAME>', '<DATE>', '<TIME>'), array($emailData['business_name'], $emailData['reservation_date'], $emailData['reservation_time']), $this->lang->line('email_this_email_serves_as_a_notification_that_you_have_cancelled')).' </p>
                            <p>&nbsp;</p>
                            <p>'.str_replace('<BUSINESS_NAME>', $emailData['business_name'], $this->lang->line('email_if_you_would_like_to_reschedule')).'</p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_kind_regards').',<br>Adbazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="https://wa.me/' . $emailData['business_whatsapp'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_contact_businesss').'</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    /**
     * 6
     */
    public function subscriptionExpiredSoon($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.str_replace('<BUSINESS_NAME>', $emailData['business_name'], $this->lang->line('22112021_email_your_subscription_for_business_will_expire_soon')).'</p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>&nbsp;</p>
                            <p>  '.str_replace(array('<BUSINESS_NAME>', '<TIME>'), array($emailData['business_name'], $emailData['time']), $this->lang->line('email_this_email_serves_as_a_notification_subscription_expired_in')).' </p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_please_make_a_payment_to_extend_your_subscription_before_it_is_expired').'</p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_looking_forward_to_seeing_you').'</p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_kind_regards').',<br>Adbazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_renew_subscription').'</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    /**
     * 7
     */
    public function subscriptionExpired($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.str_replace('<BUSINESS_NAME>',  $emailData['business_name'], $this->lang->line('22112021_email_your_subscription_for_business_has_expire')).'</p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>&nbsp;</p>
                            <p> '.str_replace('<BUSINESS_NAME>',  $emailData['business_name'], $this->lang->line('email_this_email_serves_as_a_notification_subscription_expired')).'  </p>
                            <p>&nbsp;</p>
                            <p> '.str_replace('<BUSINESS_NAME>',  $emailData['business_name'], $this->lang->line('email_we_are_sorry_that_we_have_to_temporarily_lock')).'</p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_please_make_a_payment_to_extend_your_subscription_by_clicking').' </p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_looking_forward_to_seeing_you').'</p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_best').',<br>Adbazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_renew_subscription').'</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }
   
    /**
     * 8
     */
    public function subscriptionExtended($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">Your subscription for '.$emailData['business_name'].' was successful </p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>&nbsp;</p>
                            <p> This email serves as a notification that your payment for renewing your subscription for '.$emailData['business_name'].' at Adbazar was succesful.   </p>
                            <p>&nbsp;</p>
                            <p> Thank you for using our service.</p>
                            <p>&nbsp;</p>
                            <p> Please check your receipt by clicking the button below.  </p>
                            <p>&nbsp;</p>
                           
                            <p>'.$this->lang->line('email_best').',<br>Adbazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">View my receipt</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    /**
     * 9
     */
    public function eventStartNext24h($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('22112021_email_event_reminder').' </p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>&nbsp;</p>
                            <p> '.str_replace(array('<EVENT_NAME>', '<BUSINESS_NAME>'), array($emailData['event_subject'], $emailData['business_name']), $this->lang->line('noti_event_happen_in_next_24h')).'</p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_we_are_looking_forward_to_greeting_you_in_our_event').'</p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_you_can_view_details_of_your_events').' </p>
                            <p>&nbsp;</p>
                           
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_view_events').'</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    /**
     * 10
     */
    public function eventUpdated($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('22112021_email_your_event_has_been_updated').' </p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>&nbsp;</p>
                            <p> '.str_replace(array('<EVENT_NAME>', '<BUSINESS_NAME>'), array($emailData['event_subject'], $emailData['business_name']), $this->lang->line('noti_event_updated')).' </p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_we_sincerely_apologize_for_any_inconvenience').'</p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_thank_you_for_understanding').' </p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_you_can_view_details_event').'</p>
                            <p>&nbsp;</p>

                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_view_events').'</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    /**
     * 11
     */
    public function eventCancelled($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('22112021_email_your_event_has_been_cancelled').' </p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>&nbsp;</p>
                            <p> '.str_replace(array('<EVENT_NAME>', '<BUSINESS_NAME>'), array($emailData['event_subject'], $emailData['business_name']) , $this->lang->line('noti_event_canceled')).'</p>
                            <p>&nbsp;</p>
                            <p>'.$this->lang->line('email_greeting_you_in_our_next_event').'</p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_thank_you_for_understanding').' </p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_view_details_of_other_events').'</p>
                            <p>&nbsp;</p>

                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . site_url('events.html') . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_view_events').'</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    /**
     * 12
     */
    public function reservationDeclined($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('email_your_reservation_has_been_declined').' </p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_dear_name')).',</p>
                            <p>&nbsp;</p>
                            <p> '.str_replace(array('<BUSINESS_NAME>','<DATE>','<TIME>'), array($emailData['business_name'], $emailData['date_arrived'], $emailData['time_arrived']), $this->lang->line('email_this_email_serves_as_a_notification_that_you_have_cancelled')).' </p>
                            <p>&nbsp;</p>
                            <p>'.str_replace('<BUSINESS_NAME>', $emailData['business_name'], $this->lang->line('email_if_you_would_like_to_reschedule')).' If you would like to reschedule, please contact <Business name> by clicking the button below. </p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_thank_you_for_understanding').' </p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_kind_regards').', <br>
                            ' . $emailData['business_name'] . '
                            </p>
                            <p>&nbsp;</p>

                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="tel:' . $emailData['business_phone'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">'.$this->lang->line('email_contact_businesss').'</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    /**
     * 13
     */
    public function subscriptionSuccess($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">Your subscription for ' . $emailData['business_name'] . ' was successful</p>
                            <p>'.str_replace('<CUSTOMER_NAME>', $emailData['name'], $this->lang->line('email_hello_name')).',</p>
                            <p>&nbsp;</p>
                            <p> This email serves as a notification that your payment for renewing your subscription for ' . $emailData['business_name'] . '  at Adbazar was succesful.</p>
                            <p>&nbsp;</p>
                            <p>Thank you for using our service. </p>
                            <p>&nbsp;</p>
                            <p>Please check your receipt by clicking the button below. </p>
                            <p>&nbsp;</p>
                            <p> '.$this->lang->line('email_best').',<br> AdBazar.
                            </p>
                            <p>&nbsp;</p>

                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="tel:' . $emailData['attach_file'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">View my receipt</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function createEmail($emailData = array(), $emailType = 0)
    {
        try {
            if ($emailType > 0) {
                $this->load->model('Mconfigs');
                $email_recieve = $this->Mconfigs->getConfigValueByLang('NOTIFICATION_EMAIL_ADMIN', 1);
                if(!isset($emailData['lang_id']) || empty($emailData['lang_id'])){
                    $emailData['lang_id'] = 1;
                    $emailData['language'] = $this->Mconstants->languageCodes[$emailData['lang_id']];
                }else{
                    $emailData['language'] = $this->Mconstants->languageCodes[$emailData['lang_id']];
                }

                $this->lang->load('email', $emailData['language']);
                if ($emailType == 99) {
                    //create account
                    $emailContent = $this->verifyEmail($emailData);
                    $dataInsert = array(
                        'email_subject' => $this->lang->line('email_verify_your_email_address'),
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 1) {
                    //create account
                    $emailContent = $this->successCreateAccount($emailData);
                    $dataInsert = array(
                        'email_subject' => $this->lang->line('email_your_account_was_successfully_created'),
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 2) {
                    //create account
                    $emailContent = $this->forgotPassword($emailData);
                    $dataInsert = array(
                        'email_subject' => $this->lang->line('email_password_assistance'),
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 3) {
                    //contact form
                    $emailContent = $this->sendContactForm($emailData);
                    $dataInsert = array(
                        'email_subject' => "Contact from website adbazar.eu",
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => $emailData['contact_name'],
                        'email_to' => $email_recieve,
                        'email_to_name' => EMAIL_FROM_NAME,
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 4) {
                    //join event
                    $emailContent = $this->joinEvent($emailData);
                    $dataInsert = array(
                        'email_subject' =>  $this->lang->line('email_you_have_successfully_registered_to_join_the_event'),
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 5) {
                    //decline reservation
                    $emailContent = $this->declineReservation($emailData);
                    $dataInsert = array(
                        'email_subject' => $this->lang->line('email_your_reservation_has_been_declined'),
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 6) {
                    //alert expired
                    $emailContent = $this->subscriptionExpiredSoon($emailData);
                    $dataInsert = array(
                        'email_subject' => 'Your subscription for '.$emailData['business_name'].' will expire soon',
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 7) {
                    //alert expired
                    $emailContent = $this->subscriptionExpired($emailData);
                    $dataInsert = array(
                        'email_subject' => 'Your subscription for '.$emailData['business_name'].' has expired',
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 8) {
                    //alert expired
                    $emailContent = $this->subscriptionExtended($emailData);
                    $dataInsert = array(
                        'email_subject' => 'Your subscription for '.$emailData['business_name'].' was successful',
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 9) {
                    // Event start in next 24h
                    $emailContent = $this->eventStartNext24h($emailData);
                    $dataInsert = array(
                        'email_subject' => 'Event reminder',
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 10) {
                    // Event updated
                    $emailContent = $this->eventUpdated($emailData);
                    $dataInsert = array(
                        'email_subject' => 'Your event has been updated.',
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 11) {
                    // Event cancelled
                    $emailContent = $this->eventCancelled($emailData);
                    $dataInsert = array(
                        'email_subject' => 'Your event has been cancelled.',
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 12) {
                    // Event cancelled
                    $emailContent = $this->reservationDeclined($emailData);
                    $dataInsert = array(
                        'email_subject' => 'Your reservation has been declined.',
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if ($emailType == 13) {
                    $emailContent = $this->subscriptionSuccess($emailData);
                    $dataInsert = array(
                        'email_subject' => str_replace('<BUSINESS_NAME>', $emailData['business_name'], 'Your subscription for <BUSINESS_NAME> was successful'),
                        'email_content' => $emailContent,
                        'email_from' => EMAIL_FROM,
                        'email_from_name' => EMAIL_FROM_NAME,
                        'email_to' => $emailData['email_to'],
                        'email_to_name' => $emailData['email_to_name'],
                        'is_send' => 0,
                        'attach_file' => $emailData['attach_file'],
                        'created_at' => getCurentDateTime()
                    );

                    $emailId = $this->save($dataInsert);
                    
                    if ($emailId > 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
