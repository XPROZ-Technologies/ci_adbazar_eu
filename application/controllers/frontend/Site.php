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
        $this->loadModel(array('Mconfigs', 'Mlocations'));
        $data['customer'] = $customer;
        $data['locations'] = $this->Mlocations->getBy(array('location_status_id' => STATUS_ACTIVED));
        $this->load->view('frontend/site/home', $data);
    }

    public function changeLanguage() {
        $languageId = $this->input->post('language_id');
        /*
        $language = 'de';
        switch ($languageId) {
            case 1:
                $language = 'en';
                break;
            case 2:
                $language = 'cz';
                break;
            case 3:
                $language = 'de';
                break;
            case 4:
                $language = 'vi';
                break;
            default:
                $language = 'de';
                break;
        }
        */
        /*
        $cookieValue = json_encode(array('language_id' => $languageId, 'language_name' => $language, 'id' => 0));
        $this->input->set_cookie($this->configValueCookie('customer', $cookieValue));
        */
        $customer = $this->checkLoginCustomer($languageId);
        redirect($this->input->post('UrlOld'));
    }

}