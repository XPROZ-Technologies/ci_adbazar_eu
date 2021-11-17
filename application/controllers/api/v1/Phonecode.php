<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phonecode extends MY_Controller { 

    function __construct() {
        parent::__construct();
    }

    public function list() {
        try {
            $this->openAllCors();
            $this->load->model('Mphonecodes');
            $listPhoneCode = $this->Mphonecodes->get();
            $datas = [];
            for($i = 0; $i < count($listPhoneCode); $i++ ) {
                $data = $listPhoneCode[$i];
                $datas[] = array(
                    'id' => $data['id'],
                    'country_name' => $data['country_name'],
                    'phonecode' => $data['phonecode'],
                    'image' => !empty($data['image']) ? base_url("assets/img/iso_flags/".$data['image']) : '',
                );
            }
            $this->success200(array('list' => $datas));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}