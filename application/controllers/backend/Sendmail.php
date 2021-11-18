<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmail extends MY_Controller { 

    public function index() {
        $flag =  $this->sendMail('facebook12636@gmail.com', 'man', 'haminhman2011@gmail.com', 'Gửi mail', 'ahhihi');
        echo 'kkk'.$flag;die;
    }
}