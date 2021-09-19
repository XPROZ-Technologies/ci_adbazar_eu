<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('home', $this->language);


    }

    public function index() {
        $customer = $this->checkLoginCustomer();

        $this->loadModel(array('Mconfigs', 'Mlocations'));

        $data = [];
        $data['customer'] = $customer;
        $data['locations'] = $this->Mlocations->getBy(array('location_status_id' => STATUS_ACTIVED));

        $this->load->view('frontend/home/index', $data);
    }
    
}