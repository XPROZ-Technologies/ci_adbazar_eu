<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function apple_verify()
    {
        header('Content-type: text/javascript');
        $json = '{ "applinks": {  "apps": [], "details": [ { "appID": "MDA69925D3.eu.adbazar.app", "paths": [ "/customer/verify-email/*" ] } ] } }';
        echo json_encode(json_decode($json));die;
    }
}
