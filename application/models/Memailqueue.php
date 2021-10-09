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

    public function successCreateAccount($emailData = array())
    {
        $myProfileUrl = base_url('customer/general-information');

        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">Your account was successfully created.</p>
                            <p>Hello <strong>' . $emailData['name'] . '</user></strong> ,</p>
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
        $urlAction = base_url('password_assistance?token='.$emailData['token']);

        $emailContent = '<p style="margin-bottom: 32px;font-weight: bold;
                            font-size: 20px;line-height: 24px;text-align: center;">Password assistance</p>
                            <p>Hello <strong>' . $emailData['name'] . '</user></strong> ,</p>
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

    public function createEmail($emailData = array(), $emailType = 0)
    {
        try {
            if ($emailType > 0) {
                if ($emailType == 1) {
                    //create account
                    $emailContent = $this->successCreateAccount($emailData);
                    $dataInsert = array(
                        'email_subject' => "Your account was successfully created",
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
                        'email_subject' => "Password assistance",
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
