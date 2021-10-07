<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        //$this->lang->load('signup', $this->language);


    }

    public function index() {
        $this->loadModel(array('Mconfigs'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Signup');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        
        
        $this->load->view('frontend/signup/signup', $data);
    }
    
}