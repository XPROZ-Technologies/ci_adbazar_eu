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
                            font-size: 20px;line-height: 24px;text-align: center;">Your account was successfully created.</p>
                            <p>Hello <strong>' . $emailData['name'] . '</strong> ,</p>
                            <p>Welcome to Adbazar</p>
                            <p>Please click the button below to complete your account registration</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $myProfileUrl . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">Verify Email</a>
                            </div>';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function successCreateAccount($emailData = array())
    {
        $myProfileUrl = base_url('customer/general-information');

        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">Your account was successfully created.</p>
                            <p>Hello <strong>' . $emailData['name'] . '</strong> ,</p>
                            <p>Thank you for creating your account at AdBazar</p>
                            <p>We would like to confirm that your account was created successfully. To review your account, please click the button below.</p>
                            <p>Best,<br>AdBazar.</p>
                            <p>You can view details of other events by clicking the button below.</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $myProfileUrl . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">See my profile</a>
                            </div>';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function forgotPassword($emailData = array())
    {
        $urlAction = base_url('password-assistance?token='.$emailData['token']);

        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">Password assistance</p>
                            <p>Hello ' . $emailData['name'] . ',</p>
                            <p>We have received your request to change your password.</p>
                            <p>Please click the button below to set up your new password.</p>
                            <p>If you did not make this request, please reach out to us immediately.</p>
                            <p>Best,<br>AdBazar.</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $urlAction . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">Reset Password</a>
                            </div>';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function sendContactForm($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">Contact from website</p>
                            <p>Dear Administrator,</p>
                            <p>&nbsp;</p>
                            <p>Customer Name: ' . $emailData['contact_name'] . '</p>
                            <p>Contact Name: ' . $emailData['contact_name'] . '</p>
                            <p>Contact Email: ' . $emailData['contact_email'] . '</p>
                            <p>Message: </p>
                            <p>' . nl2br($emailData['contact_message']) . '</p>
                            <p>&nbsp;</p>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function joinEvent($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">You have successfully registered to join
                            ' . $emailData['event_name'] . '.</p>
                            <p>Hello ' . $emailData['name'] . ',</p>
                            <p>&nbsp;</p>
                            <p>This email serves as a notification that your registration to join the event ' . $emailData['event_name'] . ' at ' . $emailData['business_name'] . ' has been confirmed.</p>
                            <p>&nbsp;</p>
                            <p>You can check the event detail by clicking the button below.</p>
                            <p>&nbsp;</p>
                            <p>Looking forward to seeing you.</p>
                            <p>&nbsp;</p>
                            <p>Best,<br>AdBazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['event_url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">See event details</a>
                            </div>
                           ';

        $data = $this->email_template($emailContent);
        return $data;
    }

    public function declineReservation($emailData = array())
    {
        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">'.$this->lang->line('email_your_reservation_has_been_declined').'</p>
                            <p>Dear ' . $emailData['name'] . ',</p>
                            <p>&nbsp;</p>
                            <p> This email serves as a notification that you have cancelled your appointment at '. $emailData['business_name'] .' on '. $emailData['reservation_date'] .' at '. $emailData['reservation_time'] .'. </p>
                            <p>&nbsp;</p>
                            <p>If you would like to reschedule, please contact '. $emailData['business_name'] .' by clicking the button below.</p>
                            <p>&nbsp;</p>
                            <p>Kind regards,<br>Adbazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="https://wa.me/' . $emailData['business_whatsapp'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">Contact Business</a>
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
                            font-size: 20px;line-height: 24px;text-align: center;">Your subscription for '.$emailData['business_name'].' will expire soon</p>
                            <p>Hello ' . $emailData['name'] . ',</p>
                            <p>&nbsp;</p>
                            <p>  This email serves as a notification that your subscription at AdBazar for '.$emailData['business_name'].' will expire in '.$emailData['time'].'. </p>
                            <p>&nbsp;</p>
                            <p> Please make a payment to extend your subscription before it is expired by clicking the button below to avoid any disruption while managing your business.</p>
                            <p>&nbsp;</p>
                            <p> Looking forward to seeing you at AdBazar.</p>
                            <p>&nbsp;</p>
                            <p>Kind regards,<br>Adbazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">Renew subscription</a>
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
                            font-size: 20px;line-height: 24px;text-align: center;">Your subscription for '.$emailData['business_name'].' has expired</p>
                            <p>Hello ' . $emailData['name'] . ',</p>
                            <p>&nbsp;</p>
                            <p>  This email serves as a notification that your subscription at AdBazar for '.$emailData['business_name'].' has expired.  </p>
                            <p>&nbsp;</p>
                            <p> We are sorry that we have to temporarily lock all of your accesses to manage '.$emailData['business_name'].'.</p>
                            <p>&nbsp;</p>
                            <p> Please make a payment to extend your subscription by clicking the button below. </p>
                            <p>&nbsp;</p>
                            <p> Looking forward to seeing you at AdBazar.</p>
                            <p>&nbsp;</p>
                            <p>Best,<br>Adbazar.</p>
                            <p>&nbsp;</p>
                            <div style="text-align: center;margin-top: 32px;">
                                <a target="_blank" href="' . $emailData['url'] . '" style="background: #C20000;font-style: normal;font-weight: 500;
                                font-size: 18px; line-height: 21px;    text-decoration: inherit;
                                border-radius: 2px;padding: 10px 20px;color: #fff;">Renew subscription</a>
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
                            <p>Hello ' . $emailData['name'] . ',</p>
                            <p>&nbsp;</p>
                            <p> This email serves as a notification that your payment for renewing your subscription for '.$emailData['business_name'].' at Adbazar was succesful.   </p>
                            <p>&nbsp;</p>
                            <p> Thank you for using our service.</p>
                            <p>&nbsp;</p>
                            <p> Please check your receipt by clicking the button below.  </p>
                            <p>&nbsp;</p>
                           
                            <p>Best,<br>Adbazar.</p>
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
                        'email_subject' => "Verify your email address",
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
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
