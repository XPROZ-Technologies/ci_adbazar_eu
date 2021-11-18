<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language_id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
    }

    public function init() {
        try {
            $init = [];
            $this->load->model('Mconfigs');
            $configLang = $this->Mconfigs->getListMap(1, $this->languageId);
            $config = $this->Mconfigs->getListMap(1, 4);
          
            $slogan = '';
            if($this->languageId == 1) $slogan = $config['HOME_BANNER_TEXT'];
            else if($this->languageId == 2) $slogan = $config['HOME_BANNER_TEXT_CZ'];
            else if($this->languageId == 3) $slogan = $config['HOME_BANNER_TEXT_DE'];
            else if($this->languageId == 4) $slogan = $config['HOME_BANNER_TEXT_VI'];

            $init = array(
                'header' => array(
                    'logo' => base_url(CONFIG_PATH.$config['LOGO_IMAGE_HEADER']),
                    'slogan' => $slogan
                ),
                'footer' => array(
                    'logo' => base_url(CONFIG_PATH.$config['LOGO_FOOTER_IMAGE']),
                    'hotline' => $config['PHONE_NUMBER_FOOTER'],
                    'email' => $config['EMAIL_FOOTER'],
                    'address' => $config['ADDRESS_FOOTER']

                ),
                'home' => array(
                    'video_url' => $configLang['VIDEO_URL'],
                    'icon_map' => base_url(CONFIG_PATH.$config['MARKER_MAP_IMAGE'])
                ),
                'social' => array(
                    'facebook' => $config['FACEBOOK_URL'],
                    'instagram' => $config['INSTAGRAM_URL'],
                    'tiktok' => $config['TIKTOK_URL'],
                    'twitter' => $config['TWITTER_URL'],
                    'pinterest' => $config['PINTEREST_URL']
                ),
                'term_of_use' => base_url("term-of-use.html"),
                'privacy_policy' => base_url("privacy-policy.html")
            );
            $this->success200($init);
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}