<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends MY_Controller {

    public function index() {
        $user = $this->checkUserLogin(); 
        $data = $this->commonData($user,
			'List Business payment',
			array(
                'scriptHeader' => array('css' => ''),
                'scriptFooter' => array('js' => '')
            )
		);
        $this->load->view('image/list',$data);
    }
}