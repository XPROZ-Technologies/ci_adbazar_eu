<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('customer', $this->language);
        $this->lang->load('login', $this->language);
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
    
}