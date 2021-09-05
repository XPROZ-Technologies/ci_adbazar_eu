<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rsession {

    private $CI;
    private $useRedis = false;

    public function __construct() {
        $this->useRedis = false;
        $redisConnect = getenv('REDIS_CONNECT');
        if(!empty($redisConnect)) {
            $client = new Predis\Client(explode(',', $redisConnect), array(
                'prefix' => 'PHPREDIS_SESSION:',
                'replication' => 'sentinel',
                'service' => 'mymaster'
            ));
            $handler = new Predis\Session\Handler($client, array('gc_maxlifetime' => 12 * 60 * 60));//s
            $handler->register();
            session_start();
            $this->useRedis = true;
        }
        else {
            session_start();
            $this->CI =& get_instance();
            $this->CI->load->library('session');
        }
    }

    public function set($name, $value){
        if($this->useRedis) $_SESSION[$name] = $value;
        else $this->CI->session->set_userdata($name, $value);
    }

    public function delete($name){
        if($this->useRedis) unset($_SESSION[$name]);
        else $this->CI->session->unset_userdata($name);

    }

    public function get($name){
        if($this->useRedis) return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
        else return $this->CI->session->userdata($name);
    }
}