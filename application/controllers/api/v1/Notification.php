<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi(true);
    }


    public function list()
    {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);
            $this->loadModel(array('Mbusinessprofiles', 'Mcustomernotifications', 'Mcustomers', 'Mcustomerreservations'));


            $postData = $this->arrayFromPostRawJson(array('order_by', 'filter_by', 'search_text', 'page_id', 'per_page'));
            
            if(empty($postData['order_by'])) {
                $order_by = 'DESC';
            } else {
                $order_by = $postData['order_by'];
            }

            $searchData = array(
                'customer_id' => $customer['customer_id'],
                'order_by' => $order_by
            );
            if(isset($postData['filter_by']) && is_numeric($postData['filter_by']) && $postData['filter_by'] > 0){
                $searchData['business_id'] = $postData['filter_by'];
            }

            $rowCount = $this->Mcustomernotifications->getCount($searchData);

            $per_page = isset($postData['per_page']) && intval($postData['per_page']) > 0 ? $postData['per_page'] : LIMIT_PER_PAGE;

            $page_id = isset($postData['page_id']) && intval($postData['page_id']) > 0 ?  $postData['page_id'] : 1;
           
            $notifications = [];

            $notiData = [];

            if($rowCount > 0){
                $pageCount = ceil($rowCount / $per_page);

                $notiData = $this->getNotificationLists($searchData, $per_page, $page_id);
            }

            if(!empty($notiData)) {
                for($i = 0; $i < count($notiData); $i++) {
                    $notifications[] = array(
                        "id" => $notiData[$i]['id'],
                        "title" => $notiData[$i]['text'],
                        "created_date" => ddMMyyyy($notiData[$i]['created_at'], 'Y-m-d H:i'),
                        "image" => base_url($notiData[$i]['image']),
                        "message" => $notiData[$i]['text'],
                        "item_id" => $notiData[$i]['item_id'],
                        "business_id" => $notiData[$i]['business_id'],
                        "notification_type_id" => $notiData[$i]['notification_type'],
                        "is_read" => $notiData[$i]['notification_status_id']
                    );
                }
            }

            $this->success200(array(
                'page_id' => $page_id,
                'per_page' => $per_page,
                'page_count' => $pageCount,
                'totals' => $rowCount,
                'list' => $notifications
            ));

            // $businessIds = $this->Mbusinessprofiles->getListFieldValue(array('customer_id' => $data['customer']['id']), 'id');
            // if(!empty($businessIds) && count($businessIds) > 0){
            //     $data['filterBusiness'] = $this->Mbusinessprofiles->getByNotification($businessIds);
            // }
        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function list_filter()
    {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);

            $this->loadModel(array('Mbusinessprofiles'));

            $filterBusiness = [];

            $businessIds = $this->Mbusinessprofiles->getListFieldValue(array('customer_id' => $customer['customer_id']), 'id');
            if(!empty($businessIds) && count($businessIds) > 0){
                $filterBusiness = $this->Mbusinessprofiles->getByNotification($businessIds);
            }

            $this->success200(array(
                'list' => $filterBusiness
            ));

        } catch (\Throwable $th) {
            $this->error500();
        }
    }

    public function read()
    {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin(false);

            $this->loadModel(array('Mcustomernotifications'));

            $postData = $this->arrayFromPostRawJson(array('notification_id'));


            $checkExit = $this->Mcustomernotifications->getFieldValue(array('id' => $postData['notification_id'], 'customer_id' => $customer['customer_id']), 'id', 0);
            if($checkExit <= 0) {
                $this->error204('Notification not exist');
                die;
            }
            
            $notificationId = $this->Mcustomernotifications->save(array('notification_status_id' => STATUS_NUMBER_ONE), $postData['notification_id']);

            $this->success200('', $this->lang->line('22112021_successful1'));
            die;

        } catch (\Throwable $th) {
            $this->error500();
        }
    }
}