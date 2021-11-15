<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fb extends MY_Controller { 

    public $fb;

    public function __construct()
    {
        parent::__construct();
        $this->fb = new Facebook\Facebook([
            'app_id' => $this->config->item('FACEBOOK_ID'),
            'app_secret' => $this->config->item('FACEBOOK_SECRET'),
            'default_graph_version' => $this->config->item('GRAPH_version'),
        ]);
    }

    public function index() {
        $this->fb->setDefaultAccessToken('EAAChwUZAbAdkBAIBKjpEZAPyMwnCNv4GJnO1ie5ZC4yZCEVJeeYq7eYU6AL8v52rH0cLS2EhIAPDy3bI5xEHihgllGkwf1d4ZAjxs3KzoUQsknAxPY6y5DwYkSQoG2BNvNvDxWAar0GsJESF2tMYnA4AuDZBh5ZAAA3dSDOXTWZBXBpLdBsHSHOq0ZBZCvMUsxqURaVCgILu3NBsjRZA6cvDTjHHMZCEM5rdn1kieUyvOvu8HYF0YYW1Lb2k');
        try {
            $response = $this->fb->get('/me?fields=id,name,email');
            $userNode = $response->getGraphUser();
            var_dump($userNode);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }
}