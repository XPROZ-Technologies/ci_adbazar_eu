<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->getLanguageFE();
    }

    public function index() {
        $this->loadModel(array('Mconfigs'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($this->lang->line('sign_up'));
        $data['activeMenu'] = "";
        /**
         * Commons data
         */

        
        
        $this->load->view('frontend/signup/signup', $data);
    }
    
}