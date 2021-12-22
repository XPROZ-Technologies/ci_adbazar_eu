<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller { 

    public function __construct()
    {
        parent::__construct();

        // $this->client = new Google_Client();
        // $this->client->setApplicationName($this->config->item('GOOGLE_APP_NAME'));
        // $this->client->setClientId($this->config->item('GOOGLE_ID'));
        // $this->client->setClientSecret($this->config->item('GOOGLE_SECRET'));
        // $this->client->setRedirectUri(site_url($this->config->item('GOOGLE_CALLBACK_URL')));
        // $this->client->addScope('email');

        // $this->client->addScope('profile');
        // // $this->client->addScope(array(Google_Service_Plus::USERINFO_PROFILE,Google_Service_Plus::USERINFO_EMAIL,Google_Service_Drive::DRIVE));

        // /** @var  set access type as offline */
        // /** @var  force approval */
        // $this->client->setAccessType('offline');
        // $this->client->setApprovalPrompt('force');

        // // $this->plus = new Google_Service_Plus($this->client);
        // // $this->drive = new Google_Service_Drive($this->client);

        // $this->client->setAccessToken('ya29.a0ARrdaM8Q_zDy2jtWX2lvUJCp0so_eHjYADbaa1BxaDorcxN2R2s4te-hyW6SEYo5vPYjsgOVPp-T7C2DzlND9xxWrVGGw20LigLRTkkF2MxPwvGSCR-HQo-kgWVBSpktw4ztIZEmMDBhTqMkJuP683XM2Bbi');
        // $google_service = new Google_Service_Oauth2($this->client);
    }

    // public function index(){
    //     if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    //         redirect(site_url('googleController/user'));
    //     } else {
    //         $this->getLogin();
    //     }
    // }

    // public function getLogin(){
    //     header('Location: ' . $this->client->createAuthUrl());
    // }


    public function index() {

        $client_id = '827196731985-9skqfoo8qahrvrt590q2ape5flk4bsbg.apps.googleusercontent.com'; 
        $client_secret = 'Y96aBayjCOG6jZalkgwRup6Y';
        $redirect_uri = 'http://freetuts.app/google_api/login/login.php';

        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        // $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");

        $service = new Google_Service_Oauth2($client);
        // $client->authenticate('eyJhbGciOiJSUzI1NiIsImtpZCI6IjAzMmIyZWYzZDJjMjgwNjE1N2Y4YTliOWY0ZWY3Nzk4MzRmODVhZGEiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXpwIjoiODI3MTk2NzMxOTg1LTlza3Fmb284cWFocnZydDU5MHEyYXBlNWZsazRic2JnLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiYXVkIjoiODI3MTk2NzMxOTg1LTlza3Fmb284cWFocnZydDU5MHEyYXBlNWZsazRic2JnLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTAyMjQ2MTAzMzcyODk1MDg4MTk4IiwiZW1haWwiOiJoYW1pbmhtYW4yMDExQGdtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhdF9oYXNoIjoidnR2azRZOHdPZ2hQLS1mYlBOa2hKQSIsIm5hbWUiOiJt4bqrbiBow6AiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL2EtL0FPaDE0R2dkbi1OS29ldTJQNnJ0R1lhdjludEwxTTkwSjY3WWxIbnQwNnBNT1E9czk2LWMiLCJnaXZlbl9uYW1lIjoibeG6q24iLCJmYW1pbHlfbmFtZSI6ImjDoCIsImxvY2FsZSI6InZpIiwiaWF0IjoxNjM3MDMxMjY1LCJleHAiOjE2MzcwMzQ4NjUsImp0aSI6IjhlODYxZTAzY2JkNjFhZGRjMmRkYmU4MDI5ZjMyYmFhMzJjMDk5NGYifQ.gYVrtzTU91FJTK_fOnu14HOZDyjREN7zcXAkJJuSzMhcOaqZVY2S8Ls8QBJ52Nc117bx7tn8BA08JuO4DfYua2aBN-qmYPo4MUMJ38DbrN7I6t4V0mVf873fW5Hu-qVf9LtXEjFNt4Rob2pr0vhKAvS2ZUKSBYI8BiwZ0aQiWdiCJyz_0t2NiPbzgtiaUsggsYbK16f1AB0MY7KoXTx-3_1qeHqlncJ6bx6-HCKsrxTVy_REjrOBjwEFBxcY4z13oHWln-LrbcyAiN45jhchlIelPmzOFylZiqGdgf8LQXMRPmVKgPzOmBWY79YiV4m2B9dh_3UKRRoy8jQxVfzViA');
        $client->setAccessToken('ya29.a0ARrdaM8c8_-dBZ8N-0JmLFaTPVj5MeGNYeADGkalCtelBjH0b13Ua0aytSTOIBUfGthjDutHbnEedWVgBXOE18S48_2LyvwPkD6vJJS-fBtHUeUELY4i9bjzFNRlLiRmpCjn6zkvs6Rl83NcMs6QxYeSZu9y');
        $user = $service->userinfo->get();
        $t = json_decode(json_encode($user, true),true);
        echo "<pre>";
        var_dump($t);



        // // include_once APPPATH . "libraries/vendor/autoload.php";
        // //Make object of Google API Client for call Google API
        // $google_client = new Google_Client();

        // //Set the OAuth 2.0 Client ID
        // $google_client->setClientId('827196731985-9skqfoo8qahrvrt590q2ape5flk4bsbg.apps.googleusercontent.com');

        // //Set the OAuth 2.0 Client Secret key
        // $google_client->setClientSecret('Y96aBayjCOG6jZalkgwRup6Y');

        // $google_client->addScope('email');

        // $google_client->addScope('profile');
        // $token = $google_client->fetchAccessTokenWithAuthCode('"eyJhbGciOiJSUzI1NiIsImtpZCI6IjAzMmIyZWYzZDJjMjgwNjE1N2Y4YTliOWY0ZWY3Nzk4MzRmODVhZGEiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiYXpwIjoiODI3MTk2NzMxOTg1LTlza3Fmb284cWFocnZydDU5MHEyYXBlNWZsazRic2JnLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiYXVkIjoiODI3MTk2NzMxOTg1LTlza3Fmb284cWFocnZydDU5MHEyYXBlNWZsazRic2JnLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwic3ViIjoiMTAyMjQ2MTAzMzcyODk1MDg4MTk4IiwiZW1haWwiOiJoYW1pbmhtYW4yMDExQGdtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhdF9oYXNoIjoiTkQ1ZV9fVmhQNDJWUWZibzJsQlM5ZyIsIm5hbWUiOiJt4bqrbiBow6AiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDMuZ29vZ2xldXNlcmNvbnRlbnQuY29tL2EtL0FPaDE0R2dkbi1OS29ldTJQNnJ0R1lhdjludEwxTTkwSjY3WWxIbnQwNnBNT1E9czk2LWMiLCJnaXZlbl9uYW1lIjoibeG6q24iLCJmYW1pbHlfbmFtZSI6ImjDoCIsImxvY2FsZSI6InZpIiwiaWF0IjoxNjM3MDMwNDg0LCJleHAiOjE2MzcwMzQwODQsImp0aSI6ImJmMjlmMWYwZjRlODk3ZGI0YzJiOTk5NzYwNzcxNDcxMDdkNDA2NmIifQ.l19Pt3TSuKzbnjibd-KVhZErrnshmPe3TDY0iLrdcHweMMZugPoL3gp3EYlsZshUnq3TD-S5V3qpnOVH038EQgBFTfW9FqAYoaLquduMAn94ZS7E-yZvDWoIA9HWpdt2Bz_fFLK90sAHoknA_bSbrttcI5_XYgAIGEm4Evth2DcKD42naawjIJzqbecEAAl5ourY79RhUxmhP0HNZC0ni5JubC6ogKkNj5jtwtgEABStQ_xyeKunfUlxO4qGwMdl6HAjqO0OaIe9je27jeImhjb_XnCH7TdeDZ017G6N_36YED82RyZ276ONnmuoTQhZfTt5B5xCvu72HT9JOVTIzA"');
        // // 
        // // // $google_client->setAccessToken('');
        // $google_service = new Google_Service_Oauth2($google_client);
        // $data = $google_service->userinfo->get();
        // echo "<pre>";
        // var_dump($data);
        // //Get user profile data from google
        // 

        // var_dump($data);
    }

    // public function callBack(){
    //     if (!isset($_GET['code'])) {
    //         $this->getLogin();
    //     } else {
    //         $this->client->authenticate($_GET['code']);
    //         $this->session->set_userdata('access_token', $this->client->getAccessToken());
    //         header('Location: ' . filter_var(site_url('test/user'), 'http://localhost/'));
    //     }
    // }

    
}