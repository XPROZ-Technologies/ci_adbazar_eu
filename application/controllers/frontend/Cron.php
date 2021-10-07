<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller { 
    
    function __construct(){
        parent::__construct();
       
        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        //$this->lang->load('login', $this->language);


    }

    public function cronjob() {
        $this->loadModel(array('Mconfigs', 'Memailqueue'));

        $emails = $this->Memailqueue->getBy(array('is_send' => 0), false, 'created_at','', 10, 0, 'asc');

        foreach($emails as $itemEmail){
            $resultSend  = $this->sendMail($itemEmail['email_from'], $itemEmail['email_from_name'], $itemEmail['email_to'], $itemEmail['email_to_name'], $itemEmail['email_subject'], $itemEmail['email_content']);
            if($resultSend){
                $this->Memailqueue->save(array('is_send' => STATUS_ACTIVED), $itemEmail['id']);
            }else{
                $this->Memailqueue->save(array('is_send' => 1), $itemEmail['id']);
            }
        }
        
    }
    
}