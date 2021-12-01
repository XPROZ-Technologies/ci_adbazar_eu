<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservation extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->getLanguageFE();
        $this->notExit = $this->lang->line('business-profile-does-not-exis1635566199');
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
                    echo json_encode(array('code' => 0, 'message' => $this->lang->line('reservation-config-does-not-ex1635566199')));
                    die;
                }
            } else {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('reservation-config-does-not-ex1635566199')));
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

                echo json_encode(array('code' => 1, 'message' => $this->lang->line('succesfully-saved-config1635566199'))); die;
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
                echo json_encode(array('code' => 1, 'message' => $this->lang->line('succesfully-saved-config1635566199'))); die;
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
                $dateCode = date('m-d');
                $dateCode = str_replace('-', '', $dateCode);

                $codeName = $preNameCode.$dateCode;
                $numOfCode = $this->Mcustomerreservations->getCount(array('code_name' => $codeName));
                $genCode = $codeName.'-'.(1000 + $numOfCode + 1);
                
                $postData['book_code'] = $genCode;
                $postData['created_at'] = getCurentDateTime();
                $postData['created_by'] = 0;
                $postData['date_arrived'] = ddMMyyyy($postData['date_arrived'], 'Y/m/d');
                $postData['book_status_id'] = STATUS_ACTIVED;
 
                $bookId = $this->Mcustomerreservations->save($postData);
                if($bookId > 0){
                    $this->session->set_flashdata('book_success', '1');
                    $_SESSION['book'] = $bookId;
                    redirect('business/'.$businessInfo['business_url'].'/reservation');
                }else{
                    $this->session->set_flashdata('notice_message', $this->notExit);
                    $this->session->set_flashdata('notice_type', 'success');
                    redirect('business/'.$businessInfo['business_url'].'/reservation');
                }
              
            } else {
                $this->session->set_flashdata('notice_message', $this->notExit);
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

            $message = $this->lang->line('turning-off1635566199');
            if($postData['allow_book'] == STATUS_ACTIVED){
                $message = $this->lang->line('turning-on1635566199');
            }

            $businessProfileId = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id']), 'id', 0);
            if ($businessProfileId > 0) {

                $postData['updated_at'] = getCurentDateTime();
                unset($postData['business_id']);
 
                $businessId = $this->Mbusinessprofiles->save($postData, $businessProfileId);
                if($businessId > 0){
                    echo json_encode(array('code' => 1, 'message' => $message.' '.$this->lang->line('receive-reservatio1635566199'))); die;
                }else{
                    echo json_encode(array('code' => 0, 'message' => $message.' '.$this->lang->line('receive-reservation1635566199'))); die;
                }
            } else {
                echo json_encode(array('code' => 0, 'message' => $this->notExit)); die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE)); die;
        }
    }

    public function customerCancelReservation(){
        try {
            $this->loadModel(array('Mconfigs', 'Mbusinessprofiles', 'Mcustomerreservations', 'Mcustomernotifications'));

            $postData = $this->arrayFromPost(array('business_id', 'book_id'));

            $bookId = $this->Mcustomerreservations->getFieldValue(array('id' => $postData['book_id'], 'business_profile_id' => $postData['business_id']), 'id', 0);
            if ($bookId > 0) {

                $updateData['book_status_id'] = 3; // Cancelled by customer
                $updateData['updated_at'] = getCurentDateTime();
                
                $bookId = $this->Mcustomerreservations->save($updateData, $bookId);
                if($bookId > 0){
                    $customerId = $this->Mbusinessprofiles->getFieldValue(array('id' => $postData['business_id']), 'customer_id', 0);
                    /**
                     * Add notification
                     */
                    $dataNoti = array(
                        'notification_type' => 1, //business reply customer comment
                        'customer_id'   => $customerId,
                        'business_id'   => $postData['business_id'],
                        'item_id'   => $bookId,
                        'notification_status_id'    => STATUS_ACTIVED,
                        'created_at'    => $updateData['updated_at']
                    );
                    $notificationId = $this->Mcustomernotifications->save($dataNoti);
                    /**
                     * END. Add notification
                     */

                    echo json_encode(array('code' => 1, 'message' => $this->lang->line('your-reservation-has-been-canc1635566199'))); die;
                }else{
                    echo json_encode(array('code' => 0, 'message' =>$this->lang->line('cancellation-failed1635566199'))); die;
                }
            } else {
                echo json_encode(array('code' => 0, 'message' => "Reservation not exist")); die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE)); die;
        }
    }

    public function businessDeclineReservation(){
        try {
            $this->loadModel(array('Mconfigs', 'Mbusinessprofiles', 'Mcustomerreservations', 'Mcustomernotifications'));

            $postData = $this->arrayFromPost(array('business_id', 'book_id'));

            $bookId = $this->Mcustomerreservations->getFieldValue(array('id' => $postData['book_id'], 'business_profile_id' => $postData['business_id']), 'id', 0);
            if ($bookId > 0) {

                $updateData['book_status_id'] = 4; // Declined by business
                $updateData['updated_at'] = getCurentDateTime();
                
                $bookId = $this->Mcustomerreservations->save($updateData, $bookId);
                if($bookId > 0){

                    $this->loadModel(array('Mcustomers'));
                    $reservationInfo = $this->Mcustomerreservations->get($postData['book_id']);
                    $customerInfo = $this->Mcustomers->get($reservationInfo['customer_id']);
                    $businessInfo = $this->Mbusinessprofiles->get($postData['business_id']);

                    /**
                     * Add notification
                     */
                    $dataNoti = array(
                        'notification_type' => 7, //business reply customer comment
                        'customer_id'   => $reservationInfo['customer_id'],
                        'business_id'   => $postData['business_id'],
                        'item_id'   => $bookId,
                        'notification_status_id'    => STATUS_ACTIVED,
                        'created_at'    => $updateData['updated_at']
                    );
                    $notificationId = $this->Mcustomernotifications->save($dataNoti);
                    /**
                     * END. Add notification
                     */
                
                    /**
                     * Save Email
                     */
                    $this->load->model('Memailqueue');
                    $time = explode(':', $reservationInfo['time_arrived']);
                    $dataEmail = array(
                        'name' => $customerInfo['customer_first_name'],
                        'email_to' => $customerInfo['customer_email'],
                        'email_to_name' => $customerInfo['customer_first_name'],
                        'reservation_date' => $reservationInfo['date_arrived'],
                        'reservation_time' => $time[0].':'.$time[1],
                        'business_whatsapp' => $businessInfo['business_whatsapp'],
                        'business_name' => $businessInfo['business_name']
                    );
                    $emailResult = $this->Memailqueue->createEmail($dataEmail, 5);
                    /**
                     * END. Save Email
                     */

                    echo json_encode(array('code' => 1, 'message' => $this->lang->line('reservation-has-been-declined1635566199'))); die;
                }else{
                    echo json_encode(array('code' => 0, 'message' => $this->lang->line('denial-failed1635566199'))); die;
                }
            } else {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('reservation-does-not-exist1635566199'))); die;
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE)); die;
        }
    }
}
