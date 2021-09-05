<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Predis {

    private $client;
    private $useRedis = false;

    public function __construct() {
        $redisConnect = getenv('REDIS_CONNECT');
        if (!empty($redisConnect)) {
            $this->client = new Predis\Client(explode(',', $redisConnect), [
                'replication' => 'sentinel',
                'service' => 'mymaster'
            ]);
            $this->useRedis = true;
        }
        else $this->useRedis = false;
    }

    public function del($keyArr = []) {
        if($this->useRedis) $this->client->del($keyArr);
    }

    public function set($key, $value) {
        if($this->useRedis) $this->client->set($key, $value);
    }

    public function get($key){
        return $this->useRedis ? $this->client->get($key) : '';
    }

    public function setHS($key, $field, $value) {
        if($this->useRedis) $this->client->hset($key, $field, $value);
    }

    public function getHS($key, $field) {
        return $this->useRedis ? $this->client->hget($key, $field) : '';
    }

    public function delHS($key, $field) {
        if($this->useRedis) $this->client->hdel($key, $field);
    }

    public function sendChannel($channel, $messageArr) {
        if($this->useRedis) {
            foreach ($messageArr as $key => $value) {
                $this->client->publish($channel, $value);
            }
        }
    }

    public function getAllKey() {
        return $this->useRedis ? $this->client->keys('*') : '';
    }
}
