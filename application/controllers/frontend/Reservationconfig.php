<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservationconfig extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->getLanguageFE();
    }

    public function getListTime()
    {
        try {

            $postData = $this->arrayFromPost(array('selected_day', 'business_id'));

            if (empty($postData['selected_day']) || empty($postData['business_id'])) {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('please-enter-your-contact-info1635566199')));
                die;
            }

            $this->loadModel(array('Mreservationconfigs', 'Mbusinessprofiles', 'Mcustomerreservations'));

            $allow_book = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id']), 'allow_book', 0);
            if($allow_book != STATUS_ACTIVED){
                echo json_encode(array('code' => 2, 'message' => $this->lang->line('business-suspended-reservation1635566199'), 'data' => ""));
                die;
            }

            $selected_day = date('Y-m-d', strtotime($postData['selected_day']));

            $configTimes = array();
            if($allow_book == STATUS_ACTIVED){
                $day_id = ddMMyyyy($selected_day, 'N');
                $configTimes = $this->Mreservationconfigs->getBy(array('day_id' => ($day_id - 1), 'business_profile_id' => $postData['business_id']));
            }
            
            if(!empty($configTimes)){
                $isCurrent = false;
                if(strtotime(date('Y-m-d')) == strtotime($selected_day)){
                    $isCurrent = true;
                }
                $listHours = getRangeHours($configTimes[0]['start_time'], $configTimes[0]['end_time'], $configTimes[0]['duration'], $isCurrent);
                $dataHours = "";
                foreach($listHours as $itemHours){
                    $numberBooked = $this->Mcustomerreservations->getCount(array('time_arrived' => $itemHours.':00', 'date_arrived' => $selected_day));
                    if($numberBooked < $configTimes[0]['max_people']){
                        $dataHours .= '<option value="'.$itemHours.'">'.$itemHours.'</option>';
                    }
                }
                if (!empty($dataHours)) {
                    $dataHours = '<option value="0">Select a time</option>'.$dataHours;
                    echo json_encode(array('code' => 1, 'message' => "Successfull", 'day_id' => $day_id, 'data' => $dataHours, 'max_people' => $configTimes[0]['max_per_reservation']));
                    die;
                }else{
                    echo json_encode(array('code' => 2, 'message' => $this->lang->line('here-is-no-time-period1635566199'), 'data' => ""));
                    die;
                }
            }else{
                echo json_encode(array('code' => 2, 'message' => $this->lang->line('business-suspended-reservation1635566199'), 'data' => ""));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }
}
