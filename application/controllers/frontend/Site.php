<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        $this->lang->load('home', $this->language);


    }

    public function index() {
        $customer = $this->checkLoginCustomer();
        $data['customer'] = $customer;
        $this->load->view('frontend/site/home', $data);
    }

    public function changeLanguage() {
        $languageId = $this->input->post('language_id');
        $language = 'english';
        switch ($languageId) {
            case 1:
                $language = 'english';
                break;
            case 2:
                $language = 'czech';
                break;
            default:
                $language = 'english';
                break;
        }
        $cookieValue = json_encode(array('language_id' => $languageId, 'language_name' => $language, 'id' => 0));
        $this->input->set_cookie($this->configValueCookie('customer', $cookieValue));
        redirect($this->input->post('UrlOld'));
    }

}