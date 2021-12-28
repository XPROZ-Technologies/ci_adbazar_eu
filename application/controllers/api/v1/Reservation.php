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
            // $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id']), 'id', 0);
            // if($checkExit <= 0) {
            //     $this->error204('This type of business does not belong to this customer');
            //     die;
            // }
            $dayId = date('N', strtotime($postData['book_date'])) - 1;
            $timeConfig = $this->Mreservationconfigs->getBy(array('day_id' => $dayId, 'business_profile_id' => $postData['business_id']));
            if(count($timeConfig) > 0) {
                $timeConfig = $timeConfig[0];
                
                $checkTimeNow = $this->Mreservationconfigs->checkTimeNow($dayId, $postData['business_id']);
                
                $times = getRangeHours($timeConfig['start_time'], $timeConfig['end_time'], 30, $checkTimeNow);
                $this->success200(array('list' => $times));
            } else {
                $this->error204('There is no suitable time period, please choose another date');
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
           
            // $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $customer['customer_id']), 'id', 0);
            // if(intval($checkExit) <= 0) {
            //     $this->error204('This type of business does not belong to this customer');
            //     die;
            // }
          
            $dayId = date('N', $dateData) - 1;
            $timeConfig = $this->Mreservationconfigs->getBy(array('day_id' => $dayId, 'business_profile_id' => $postData['business_id']));
            if(count($timeConfig) > 0) {
                $timeConfig = $timeConfig[0];
                if(intval($postData['number_of_people'] > intval($timeConfig['max_per_reservation']))) {
                    $this->error204('Can only book up to '.$timeConfig['max_per_reservation'].' people');
                    die;
                }
                $strDateTime = $postData['date_arrived'].' '.$postData['time_arrived'].":00";
                $customerReser = $this->Mcustomerreservations->checkTimeBookReservations($strDateTime, $postData['business_id']);
                if($customerReser && count($customerReser) > 0) {
                    $customerReser = $customerReser[0];
                    if($postData['number_of_people'] > (intval($timeConfig['max_people']) - intval($customerReser['number_of_people']))) {
                        $this->error204('The number of people you want to place must be less than the number of people in the system');
                        die;
                    }
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

    public function cancel_a_reservation() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('reservation_id'));
            if(!isset($postData['reservation_id'])) {
                $this->error204('reservation_id: not transmitted');
                die;
            }
            $this->load->model(array('Mcustomerreservations'));
            $reservation = $this->Mcustomerreservations->get($postData['reservation_id']);
            if(empty($reservation)) {
                $this->error204('Reservation does not exist');
                die;
            }
            if($reservation['customer_id'] != $customer['customer_id']) {
                $this->error204('Reservation does not belong to this customer');
                die;
            }
            if($reservation['book_status_id'] != 2) {
                $this->error204('Reservation is not in an active state so it cannot be canceled');
                die;
            }
            $flag = $this->Mcustomerreservations->save(array(
                'book_status_id' => 3,
                'updated_by' => getCurentDateTime()
            ), $postData['reservation_id']);
            if($flag) {
                $this->success200('', 'Cancellation is successful');
            } else {
                $this->error204('Cancellation failed');
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function decline_a_reservation() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('reservation_id', 'business_id'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['reservation_id'])) {
                $this->error204('reservation_id: not transmitted');
                die;
            }
            $this->load->model(array('Mcustomerreservations', 'Mbusinessprofiles'));
            $checkExitBusiness = $this->Mbusinessprofiles->getFieldValue(array('customer_id' => $customer['customer_id'], 'id' => $postData['business_id']), 'id', 0);
            if($checkExitBusiness == 0) {
                $this->error204('Business profile does not belong to this customer');
                die;
            }
            $reservation = $this->Mcustomerreservations->get($postData['reservation_id']);
            if(empty($reservation)) {
                $this->error204('Reservation does not exist');
                die;
            }
            if($reservation['customer_id'] != $customer['customer_id']) {
                $this->error204('Reservation does not belong to this customer');
                die;
            }

            if($reservation['business_profile_id'] != $postData['business_id']) {
                $this->error204('Reservation does not belong to this business');
                die;
            }
            if($reservation['book_status_id'] != 2) {
                $this->error204('Reservation is not in an active state so it cannot be canceled');
                die;
            }

            $flag = $this->Mcustomerreservations->save(array(
                'book_status_id' => 4,
                'updated_by' => getCurentDateTime()
            ), $postData['reservation_id']);
            if($flag) {
                $this->success200('', 'Refused to make an appointment successfully');
            } else {
                $this->error204('Refused to make an appointment failed');
                die;
            }
        
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function update_config() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'day_id', 'max_people', 'max_per_reservation', 'duration', 'start_time', 'end_time', 'is_all'));
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model(array('Mbusinessprofiles', 'Mreservationconfigs'));
            $this->checkValidateUpdateConfig($postData);

            // TH: is_all = 1
            $flag = false;
            if($postData['is_all'] == 1) {
                for($i = 0; $i <= 6; $i++) {
                    $configId = $this->Mreservationconfigs->getFieldValue(array('business_profile_id' => $postData['business_id'], 'day_id' => $i , 'reservation_config_status_id' => 2), 'id', 0);
                    $dataSave = array(
                        'business_profile_id' => $postData['business_id'],
                        'day_id' => $postData['day_id'],
                        'max_people' => $postData['max_people'],
                        'max_per_reservation' => $postData['max_per_reservation'],
                        'duration' => $postData['duration'],
                        'start_time' => $postData['start_time'].':00',
                        'end_time' => $postData['end_time'].':00',
                        'updated_by' => getCurentDateTime(),
                        'reservation_config_status_id' => 2
                    );
                    $flag = $this->Mreservationconfigs->save($dataSave, $configId);
                }
            } else {
                $configId = $this->Mreservationconfigs->getFieldValue(array('business_profile_id' => $postData['business_id'], 'day_id' => $postData['day_id'] , 'reservation_config_status_id' => 2), 'id', 0);
                $dataSave = array(
                    'business_profile_id' => $postData['business_id'],
                    'day_id' => $postData['day_id'],
                    'max_people' => $postData['max_people'],
                    'max_per_reservation' => $postData['max_per_reservation'],
                    'duration' => $postData['duration'],
                    'start_time' => $postData['start_time'].':00',
                    'end_time' => $postData['end_time'].':00',
                    'updated_by' => getCurentDateTime(),
                    'reservation_config_status_id' => 2
                );
                $flag = $this->Mreservationconfigs->save($dataSave, $configId);
            }
            if($flag) {
                $this->success200('', 'Successful configuration');
            } else {
                $this->error204('Configuration failed');
                die;
            }

        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    private function checkValidateUpdateConfig($postData) {
        if(!isset($postData['business_id'])) {
            $this->error204('business_id: not transmitted');
            die;
        }
        if(!isset($postData['day_id'])) {
            $this->error204('day_id: not transmitted');
            die;
        }
        if(!isset($postData['max_people'])) {
            $this->error204('max_people: not transmitted');
            die;
        }
        if(!isset($postData['max_per_reservation'])) {
            $this->error204('max_per_reservation: not transmitted');
            die;
        }
        if(!isset($postData['duration'])) {
            $this->error204('duration: not transmitted');
            die;
        }
        if(!isset($postData['start_time'])) {
            $this->error204('start_time: not transmitted');
            die;
        }
        if(!isset($postData['end_time'])) {
            $this->error204('end_time: not transmitted');
            die;
        }
        if(!isset($postData['is_all'])) {
            $this->error204('is_all: not transmitted');
            die;
        }
        $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $postData['customer_id'], 'business_status_id >' => 0), 'id', 0);
        if(!$checkExit) {
            $this->error204('Business does not belong to this customer');
            die;
        }
        if(!in_array($postData['day_id'], [0,1,2,3,4,5,6])) {
            $this->error204('Invalid number of days');
            die;
        }
        if(!is_numeric($postData['max_people'])) {
            $this->error204('max_people: not a numeric type');
            die;
        }
        if(!is_numeric($postData['max_per_reservation'])) {
            $this->error204('max_per_reservation: not a numeric type');
            die;
        }
        if(!is_numeric($postData['duration'])) {
            $this->error204('duration: not a numeric type');
            die;
        }
        if(!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $postData['start_time'])) {
            $this->error204('start_time: not time format');
            die;
        }
        if(!preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $postData['end_time'])) {
            $this->error204('start_time: not time format');
            die;
        }
        if(!in_array($postData['is_all'], [0,1])) {
            $this->error204('is_all: not in 0 or 1');
            die;
        }
        
    }

    public function get_config() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'day_id'));
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model(array('Mbusinessprofiles', 'Mreservationconfigs'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['day_id'])) {
                $this->error204('day_id: not transmitted');
                die;
            }
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $postData['customer_id'], 'business_status_id >' => 0), 'id', 0);
            if(!$checkExit) {
                $this->error204('Business does not belong to this customer');
                die;
            }
            if(!in_array($postData['day_id'], [0,1,2,3,4,5,6])) {
                $this->error204('Invalid number of days');
                die;
            }
            $config = $this->Mreservationconfigs->getBy(array('business_profile_id' => $postData['business_id'], 'reservation_config_status_id' => 2));
            $dataConfig = [];
            if($config && count($config) > 0) {
                $config = $config[0];
                $dataConfig = array(
                    "day_id" => intval($config['day_id']),
                    "max_people" => intval($config['max_people']),
                    "max_per_reservation" => intval($config['max_per_reservation']),
                    "duration" => floatval($config['duration']),
                    "start_time" => ddMMyyyy($config['start_time'], 'H:i'),
                    "end_time" => ddMMyyyy($config['end_time'], 'H:i'),
                    "reservation_config_status_id" => 2
                );
            } else {
                $dataConfig = array(
                    "day_id" => intval($postData['day_id']),
                    "max_people" => 0,
                    "max_per_reservation" => 0,
                    "duration" => 0,
                    "start_time" => '',
                    "end_time" => '',
                    "reservation_config_status_id" => 1
                );
            }
            $this->success200($dataConfig);
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function update_status() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $postData = $this->arrayFromPostRawJson(array('business_id', 'allow_book'));
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model(array('Mbusinessprofiles'));
            if(!isset($postData['business_id'])) {
                $this->error204('business_id: not transmitted');
                die;
            }
            if(!isset($postData['allow_book'])) {
                $this->error204('allow_book: not transmitted');
                die;
            }
            $checkExit = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id'], 'customer_id' => $postData['customer_id'], 'business_status_id >' => 0), 'id', 0);
            if(!$checkExit) {
                $this->error204('Business does not belong to this customer');
                die;
            }
            if(!in_array($postData['allow_book'], [1,2])) {
                $this->error204('allow_book: Downlink value must be 1 or 2');
                die;
            }

            $dataUpdate = array(
                'allow_book' => $postData['allow_book'],
                'updated_at' => getCurentDateTime()
            );
            $flag = $this->Mbusinessprofiles->save($dataUpdate, $postData['business_id']);
            if($flag) {
                $message = "Turn on receiving booking successfully";
                if(intval($postData['allow_book']) == 1) $message = "Turn off receiving booking successfully";
                $this->success200('', $message);
            } else {
                $message = "Turn on receive booking failed";
                if(intval($postData['allow_book']) == 1) $message = "Turn off receive booking failed";
                $this->error204($message);
                die;
            }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}