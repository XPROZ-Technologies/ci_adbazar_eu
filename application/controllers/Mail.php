<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends MY_Controller { 

    public function index() {
        $flag = $this->sendMailFile('123@gmail.com', '321', '123@gmail.com', 's', 's','d');
        echo $flag;
    }
}