<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phonecode extends MY_Controller { 

    function __construct() {
        parent::__construct();
    }

    public function list() {
        try {
            $this->openAllCors();
            $postData = $this->arrayFromPostRawJson(array('search_text', 'page_id', 'per_page'));
            $this->load->model('Mphonecodes');
            $postData['api'] = true;
            $rowCount = $this->Mphonecodes->getCountInApi($postData);
            $datas = [];
            $perPage = intval($postData['per_page']) < 1 ? DEFAULT_LIMIT :$postData['per_page'];
            $pageCount = 0;
            $page = $postData['page_id'];
            if($rowCount > 0){
                $pageCount = ceil($rowCount / $perPage);
                if(!is_numeric($page) || $page < 1) $page = 1;
                $phoneCodes = $this->Mphonecodes->getListInApi($postData, $perPage, $page);
                for($i = 0; $i < count($phoneCodes); $i++ ) {
                    $data = $phoneCodes[$i];
                    $datas[] = array(
                        'id' => $data['id'],
                        'country_name' => $data['country_name'],
                        'phonecode' => $data['phonecode'],
                        'image' => !empty($data['image']) ? base_url("assets/img/iso_flags/".$data['image']) : '',
                    );
                }
            }
            $this->success200(array(
                        'page_id' => $page,
                        'per_page' => $perPage,
                        'page_count' => $pageCount,
                        'totals' => $rowCount,
                        'list' => $datas));
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}