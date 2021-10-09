<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservationconfig extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
        //$this->lang->load('login', $this->language);
    }

    public function getListTime()
    {
        try {

            $postData = $this->arrayFromPost(array('selected_day', 'business_id'));

            if (empty($postData['selected_day']) || empty($postData['business_id'])) {
                echo json_encode(array('code' => 0, 'message' => "Please enter your contact information"));
                die;
            }

            $this->loadModel(array('Mreservationconfigs'));

            $configTimes = $this->Mreservationconfigs->getBy(array('day_id' => $postData['day_id'], 'business_profile_id' => $postData['business_id']));
        
            $listHours = getRangeHours($configTimes[0]['start_time'], $configTimes[0]['end_time'], $configTimes[0]['duration']);

            if ($customerContactId) {
                echo json_encode(array('code' => 1, 'message' => "Thank you for contacting. We will contact you as soon as possible"));
                die;
            }else{
                echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
                die;
            }

        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }
}
