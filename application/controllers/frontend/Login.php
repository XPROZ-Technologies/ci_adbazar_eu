<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->getLanguageFE();
    }

    public function index() {
        $this->loadModel(array('Mconfigs'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($this->lang->line('login'),
			array('scriptFooter' => array('js' => 'js/frontend/login/login.js'))
        );
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $redirectUrl = $this->input->get('redirectUrl');
        $data['redirectOldUrl'] = $redirectUrl;

        
        
        $this->load->view('frontend/login/signin', $data);
    }


    public function password_assistance(){
        $this->loadModel(array('Mconfigs', 'Mcustomers'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer("Password Assistance");
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        $token = $this->input->get('token');

        if(empty($token)){
            $this->session->set_flashdata('notice_message', $this->lang->line('token-not-exist-or-expired1635566199'));
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }

        $customerId = $this->Mcustomers->getFieldValue(array('token_reset' => $token), 'id', 0);
        if($customerId > 0){
            $data['token'] = $token;
            $this->load->view('frontend/login/signin-setup-password', $data);
        }else{
            $this->session->set_flashdata('notice_message', $this->lang->line('token-not-exist-or-expired1635566199'));
            $this->session->set_flashdata('notice_type', 'error');
            redirect(base_url(HOME_URL));
        }
    }
    
}