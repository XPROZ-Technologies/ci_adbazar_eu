<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phonecode extends MY_Controller { 

    public function getListSelect2Ajax() {
        $user = $this->checkUserLogin();
		$searchText = $this->input->post('search_text');
		$this->load->model('Mphonecodes');
		$list = $this->Mphonecodes->getListSelect2Ajax($searchText);
		echo json_encode($list);
    }
}