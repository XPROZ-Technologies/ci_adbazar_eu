<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller { 

    public function __construct()
    {
        parent::__construct();

        $this->client = new Google_Client();
        $this->client->setApplicationName($this->config->item('GOOGLE_APP_NAME'));
        $this->client->setClientId($this->config->item('GOOGLE_ID'));
        $this->client->setClientSecret($this->config->item('GOOGLE_SECRET'));
        $this->client->setRedirectUri(site_url($this->config->item('GOOGLE_CALLBACK_URL')));
        $this->client->addScope('email');

        $this->client->addScope('profile');
        // $this->client->addScope(array(Google_Service_Plus::USERINFO_PROFILE,Google_Service_Plus::USERINFO_EMAIL,Google_Service_Drive::DRIVE));

        /** @var  set access type as offline */
        /** @var  force approval */
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt('force');

        // $this->plus = new Google_Service_Plus($this->client);
        // $this->drive = new Google_Service_Drive($this->client);

        $this->client->setAccessToken($this->session->userdata('access_token'));
    }

    public function index(){
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            redirect(site_url('googleController/user'));
        } else {
            $this->getLogin();
        }
    }

    public function getLogin(){
        header('Location: ' . $this->client->createAuthUrl());
    }


    // public function index() {
    //     // // include_once APPPATH . "libraries/vendor/autoload.php";
    //     // //Make object of Google API Client for call Google API
    //     // $google_client = new Google_Client();

    //     // //Set the OAuth 2.0 Client ID
    //     // $google_client->setClientId('1001160309619-f30jgqido5nq8v2nt3gbdd0d7pr5hp7c.apps.googleusercontent.com');

    //     // //Set the OAuth 2.0 Client Secret key
    //     // $google_client->setClientSecret('b82BAjvFggoRlQ2LBRrofhxl');

    //     // $google_client->addScope('email');

    //     // $google_client->addScope('profile');
    //     // // $token = $google_client->fetchAccessTokenWithAuthCode('eyJhbGciOiJSUzI1NiIsImtpZCI6IjAzMmIyZWYzZDJjMjgwNjE1N2Y4YTliOWY0ZWY3Nzk4MzRmODVhZGEiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXpwIjoiMTAwMTE2MDMwOTYxOS1mMzBqZ3FpZG81bnE4djJudDNnYmRkMGQ3cHI1aHA3Yy5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImF1ZCI6IjEwMDExNjAzMDk2MTktZjMwamdxaWRvNW5xOHYybnQzZ2JkZDBkN3ByNWhwN2MuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMDIyNDYxMDMzNzI4OTUwODgxOTgiLCJlbWFpbCI6ImhhbWluaG1hbjIwMTFAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF0X2hhc2giOiJHblBha0hmTDJ3dUQyUmowdnl5Q1RBIiwibmFtZSI6Im3huqtuIGjDoCIsInBpY3R1cmUiOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vYS0vQU9oMTRHZ2RuLU5Lb2V1MlA2cnRHWWF2OW50TDFNOTBKNjdZbEhudDA2cE1PUT1zOTYtYyIsImdpdmVuX25hbWUiOiJt4bqrbiIsImZhbWlseV9uYW1lIjoiaMOgIiwibG9jYWxlIjoidmkiLCJpYXQiOjE2MzY5ODUyMjAsImV4cCI6MTYzNjk4ODgyMCwianRpIjoiYzMxYTVjNDY2NWE1MzczNmFhMTcxZTExYTU0ZWFkMjA0MWJlOWYwMSJ9.iNPRhh0UWwTfHxbCdzhPsbtr2nUmfwVcm_3fW4mrfn1whL0yfL16uERlfk21GJZ9ZsjRaEOzOBx1NlF_BCEEtTLNJKCN8-Z8Zz1tw2QZ4qQWRttyQ08EEZv7PtuWORnCPz0-GQCBszv-jRnGwZC3w8r90N8kuupsqTckTfYy-wILswL_-zJXGj5SDMqkKNeJJ-mcH1Zlac-m7uwXDJFM7mg-rRz2V-t124DztMjMrR5ol8Jgly_8MFs3h_Y5pz7-9otolnNVfqrNcMxJKSIraQgFp3Z82zZ3yAbbqje453D54FmP-Dr9UnnceWdt-bNQsHrgiGiQoMJBmm5iW3lVzQ');
    //     // // 
    //     // // // $google_client->setAccessToken('');
    //     // $google_service = new Google_Service_Oauth2($google_client);
    //     // var_dump($google_service);
    //     // // //Get user profile data from google
    //     // // $data = $google_service->userinfo->get();

    //     // // var_dump($data);
    // }

    public function callBack(){
        if (!isset($_GET['code'])) {
            $this->getLogin();
        } else {
            $this->client->authenticate($_GET['code']);
            $this->session->set_userdata('access_token', $this->client->getAccessToken());
            header('Location: ' . filter_var(site_url('test/user'), 'http://localhost/'));
        }
    }

}