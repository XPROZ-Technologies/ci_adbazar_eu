<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller { 

    public function getListSelect2Ajax() {
        $user = $this->checkUserLogin();
		$searchText = $this->input->post('search_text');
		$this->load->model('Mcustomers');
		$list = $this->Mcustomers->getListSelect2Ajax($searchText);
		echo json_encode($list);
    }
}