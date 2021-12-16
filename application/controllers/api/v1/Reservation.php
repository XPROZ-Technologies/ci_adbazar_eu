<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language-id', TRUE);
        $this->languageId = !empty($languageId) ? $languageId : 1;
        $this->langCode = '_vi';
        if ($this->languageId == 1) $this->langCode = '_en';
        elseif ($this->languageId == 2) $this->langCode = '_cz';
        elseif ($this->languageId == 3) $this->langCode = '_de';
    }

    public function available_time() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'book_date'));
            if($postData['business_id'] < 0) {
                $this->error204('Please add business');
                die;
            }
            if(empty($postData['book_date'])) {
                $this->error204('Please select a date');
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mreservationconfigs'));
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id']), 'id', 0);
            if($checkExit <= 0) {
                $this->error204('This type of business does not belong to this customer');
                die;
            }
            $dayId = date('N', strtotime($postData['book_date'])) - 1;
            $timeConfig = $this->Mreservationconfigs->getBy(array('day_id' => $dayId, 'business_profile_id' => $postData['business_id']));
            if(count($timeConfig) > 0) {
                $timeConfig = $timeConfig[0];
                
                $checkTimeNow = $this->Mreservationconfigs->checkTimeNow($dayId, $postData['business_id']);
                
                $times = getRangeHours($timeConfig['start_time'], $timeConfig['end_time'], 30, $checkTimeNow);
                $this->success200(array('list' => $times));
            } else {
                $this->error204('This type of business does not belong to this customer');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function book_a_reservation() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'book_name', 'number_of_people', 'country_code_id', 'book_phone', 'date_arrived', 'time_arrived'));
            if($postData['business_id'] < 0) {
                $this->error204('Please add business');
                die;
            }
            if(empty($postData['book_name'])) {
                $this->error204('Please enter your name');
                die;
            }
            if(empty($postData['number_of_people']) && $postData['number_of_people'] < 0) {
                $this->error204('Please add the number of people');
                die;
            }
            if(empty($postData['country_code_id']) && $postData['country_code_id'] < 0) {
                $this->error204('Please add country code');
                die;
            }
            if(empty($postData['book_phone'])) {
                $this->error204('Please add phone number');
                die;
            }
            if(empty($postData['date_arrived'])) {
                $this->error204('Please add date');
                die;
            }
            if(empty($postData['time_arrived'])) {
                $this->error204('Please add hours');
                die;
            }
            $dateNow = strtotime(getCurentDateTime());
            $dateData = strtotime($postData['date_arrived'].' '.$postData['time_arrived'].":00");
            if($dateData < $dateNow) {
                $this->error204("Can't choose past date");
                die;
            }
            $this->load->model(array('Mbusinessprofiles', 'Mreservationconfigs', 'Mcustomerreservations'));
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id']), 'id', 0);
            if($checkExit <= 0) {
                $this->error204('This type of business does not belong to this customer');
                die;
            }
            $dayId = date('N', strtotime($postData['date_arrived'])) - 1;
            $timeConfig = $this->Mreservationconfigs->getBy(array('day_id' => $dayId, 'business_profile_id' => $postData['business_id']));
            if(count($timeConfig) > 0) {
                $timeConfig = $timeConfig[0];
                if(intval($timeConfig['max_per_reservation']) < intval($postData['number_of_people'])) {
                    $this->error204('Can only book up to '.$timeConfig['max_per_reservation'].' people');
                    die;
                }
                if( (strtotime($timeConfig['start_time']) < strtotime($postData['time_arrived'])) &&  (strtotime($postData['time_arrived']) < strtotime($timeConfig['end_time'])) ) { 
                    $businessInfo = $this->Mbusinessprofiles->get($postData['business_id']);
                    $preNameCode = str_replace('-', '', $businessInfo['business_url']);
                    $preNameCode = strtoupper(substr($preNameCode, 0,4));
                    $dateCode = date('m-d');
                    $dateCode = str_replace('-', '', $dateCode);
    
                    $codeName = $preNameCode.$dateCode;
                    $numOfCode = $this->Mcustomerreservations->getCount(array('code_name' => $codeName));
                    $genCode = $codeName.'-'.(1000 + $numOfCode + 1);
                    
                    $data['business_profile_id'] = $postData['business_id'];
                    $data['book_name'] = $postData['book_name'];
                    $data['number_of_people'] = $postData['number_of_people'];
                    $data['country_code_id'] = $postData['country_code_id'];
                    $data['book_phone'] = $postData['book_phone'];
                    $data['customer_id'] = $customer['customer_id'];
                    $data['book_code'] = $genCode;
                    $data['created_at'] = getCurentDateTime();
                    $data['created_by'] = 0;
                    $data['date_arrived'] = ddMMyyyy($postData['date_arrived'], 'Y/m/d');
                    $data['time_arrived'] = ddMMyyyy($postData['time_arrived'], 'H:i');
                    $data['book_status_id'] = STATUS_ACTIVED;

     
                    $flag = $this->Mcustomerreservations->save($data);
                    if($flag) {
                        $this->success200(array(
                            "book_id"=> $flag,
                            "business_name"=> $businessInfo['business_name'],
                            "time_arrived"=> ddMMyyyy($postData['time_arrived'], 'H:i'),
                            "date_arrived"=> ddMMyyyy($postData['date_arrived'], 'Y/m/d'),
                            "number_of_people"=> $postData['number_of_people'],
                        ));
                    } else {
                        $this->error500();
                        die;
                    }

                } else {
                    $this->error204('The time you choose must be within the opening hours');
                    die;
                }
            } else {
                $this->error204('This type of business does not belong to this customer');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}