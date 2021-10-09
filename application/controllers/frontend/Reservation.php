<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservation extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('cookie');
        $language = $this->input->cookie('customer') ? json_decode($this->input->cookie('customer', true), true)["language_name"] : config_item('language');
        $this->language =  $language;
    }

    public function getReservation()
    {
        try {
            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mreservationconfigs'));

            $postData = $this->arrayFromPost(array('day_id', 'business_id'));

            $reservationConfigId = $this->Mreservationconfigs->getFieldValue(array('day_id' => $postData['day_id'], 'business_profile_id' => $postData['business_id']), 'id', 0);
            if ($reservationConfigId > 0) {

                $reservationConfigs = $this->Mreservationconfigs->get($reservationConfigId);
                $reservationConfigs['start_time'] = ddMMyyyy($reservationConfigs['start_time'], 'H:i');
                $reservationConfigs['end_time'] = ddMMyyyy($reservationConfigs['end_time'], 'H:i');

                if (!empty($reservationConfigs)) {
                    echo json_encode(array('code' => 1, 'message' => "Sucessfully", 'data' => $reservationConfigs));
                    die;
                } else {
                    echo json_encode(array('code' => 0, 'message' => "Reservation config not exist"));
                    die;
                }
            } else {
                echo json_encode(array('code' => 0, 'message' => "Reservation config not exist"));
                die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }

    public function saveReservation()
    {
        try {
            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mreservationconfigs'));

            $postData = $this->arrayFromPost(array('max_people', 'max_per_reservation', 'duration', 'start_time', 'end_time'));

            $mainData = $this->arrayFromPost(array('day_id', 'business_id', 'isAll'));

            $reservationConfigId = $this->Mreservationconfigs->getFieldValue(array('day_id' => $mainData['day_id'], 'business_profile_id' => $mainData['business_id']), 'id', 0);
            if ($reservationConfigId > 0) {

                $configId = $this->Mreservationconfigs->save($postData, $reservationConfigId);

                if ($mainData['isAll'] == 1) {
                    $listDays = $this->Mconstants->dayIds;
                    foreach ($listDays as $day_id => $itemDay) {
                        if ($day_id != $mainData['day_id']) {
                            $reservationConfigId = $this->Mreservationconfigs->getFieldValue(array('day_id' => $day_id, 'business_profile_id' => $mainData['business_id']), 'id', 0);
                            if ($reservationConfigId > 0) {
                                $configId = $this->Mreservationconfigs->save($postData, $reservationConfigId);
                            } else {
                                $saveAllData = $postData;
                                $saveAllData['day_id'] = $day_id;
                                $saveAllData['business_profile_id'] = $mainData['business_id'];
                                $configId = $this->Mreservationconfigs->save($saveAllData);
                            }
                        }
                    }
                }

                echo json_encode(array('code' => 1, 'message' => "Save config sucessfully")); die;
            } else {
                $saveAllData = $postData;
                $saveAllData['day_id'] = $mainData['day_id'];
                $saveAllData['business_profile_id'] = $mainData['business_id'];
                $configId = $this->Mreservationconfigs->save($saveAllData);

                if ($mainData['isAll'] == 1) {
                    $listDays = $this->Mconstants->dayIds;
                    foreach ($listDays as $day_id => $itemDay) {
                        if ($day_id != $mainData['day_id']) {
                            $reservationConfigId = $this->Mreservationconfigs->getFieldValue(array('day_id' => $day_id, 'business_profile_id' => $mainData['business_id']), 'id', 0);
                            if ($reservationConfigId > 0) {
                                $configId = $this->Mreservationconfigs->save($postData, $reservationConfigId);
                            } else {
                                $saveAllData = $postData;
                                $saveAllData['day_id'] = $day_id;
                                $saveAllData['business_profile_id'] = $mainData['business_id'];
                                $configId = $this->Mreservationconfigs->save($saveAllData);
                            }
                        }
                    }
                }
                echo json_encode(array('code' => 1, 'message' => "Save config sucessfully")); die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
            die;
        }
    }

    public function bookReservation()
    {
        try {
            $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mreservationconfigs', 'Mcustomerreservations', 'Mbusinessprofiles'));

            $postData = $this->arrayFromPost(array('business_profile_id', 'customer_id', 'book_name', 'number_of_people', 'country_code_id', 'book_phone', 'date_arrived', 'time_arrived'));

            $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_profile_id']), 'id', 0);
            if ($businessProfileId > 0) {
                $businessInfo = $this->Mbusinessprofiles->get($postData['business_profile_id']);
                
                $preNameCode = str_replace('-', '', $businessInfo['business_url']);
                $preNameCode = strtoupper(substr($preNameCode, 0,4));
                $dateCode = date('Y-m-d');
                $dateCode = str_replace('-', '', $dateCode);

                $codeName = $preNameCode.$dateCode;
                $numOfCode = $this->Mcustomerreservations->getCount(array('code_name' => $codeName));
                $genCode = $codeName.(1000 + $numOfCode + 1);
                
                $postData['book_code'] = $genCode;
                $postData['created_at'] = getCurentDateTime();
                $postData['created_by'] = 0;
                $postData['date_arrived'] = ddMMyyyy($postData['date_arrived'], 'Y/m/d');
                $postData['book_status_id'] = STATUS_ACTIVED;
 
                $bookId = $this->Mcustomerreservations->save($postData);
                if($bookId > 0){
                    $this->session->set_flashdata('book_success', '1');
                    redirect('business/'.$businessInfo['business_url'].'/reservation?1');
                }else{
                    $this->session->set_flashdata('notice_message', "Business profile not exist");
                    $this->session->set_flashdata('notice_type', 'success');
                    redirect('business/'.$businessInfo['business_url'].'/reservation?2');
                }
              
            } else {
                $this->session->set_flashdata('notice_message', "Business profile not exist");
                $this->session->set_flashdata('notice_type', 'success');
                redirect(base_url(HOME_URL));
            }
        } catch (Exception $e) {
          
            $this->session->set_flashdata('notice_message', ERROR_COMMON_MESSAGE);
            $this->session->set_flashdata('notice_type', 'success');
            redirect(base_url(HOME_URL));
        }
    }

    public function changeAllowBook()
    {
        try {
            $this->loadModel(array('Mconfigs', 'Mbusinessprofiles'));

            $postData = $this->arrayFromPost(array('business_id', 'allow_book'));

            $message = "Turn off";
            if($postData['allow_book'] == STATUS_ACTIVED){
                $message = "Turn on";
            }

            $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id']), 'id', 0);
            if ($businessProfileId > 0) {

                $postData['updated_at'] = getCurentDateTime();
                unset($postData['business_id']);
 
                $businessId = $this->Mbusinessprofiles->save($postData, $businessProfileId);
                if($businessId > 0){
                    echo json_encode(array('code' => 1, 'message' => $message." receive reservations successfully")); die;
                }else{
                    echo json_encode(array('code' => 0, 'message' => $message." receive reservations failed")); die;
                }
            } else {
                echo json_encode(array('code' => 0, 'message' => "Business profile not exist")); die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE)); die;
        }
    }
}
