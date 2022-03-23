<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Dashboard',
            array('scriptFooter' => array('js' => ''))
        );
        $this->load->view('backend/dashboard/dashboard', $data);
    }
}