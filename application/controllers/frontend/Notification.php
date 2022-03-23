<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->getLanguageFE();
    }

    public function index()
    {
        $this->loadModel(array('Mconfigs', 'Mbusinessprofiles', 'Mcustomernotifications', 'Mcustomers', 'Mcustomerreservations', 'Mcustomerreviews'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer('Notifications');
        $data['activeMenu'] = "";
        /**
         * Commons data
         */
        $order_by = $this->input->get('order_by');
        $data['order_by'] = $order_by;
        $noti_type = $this->input->get('noti_type');
        $data['noti_type'] = $noti_type;
        $searchData = array(
            'customer_id' => $data['customer']['id'],
            'order_by' => $order_by
        );
        if(is_numeric($noti_type)){
            $searchData['business_id'] = $noti_type;
        }
        
        $data['lists'] = $this->getNotificationLists($searchData, DEFAULT_LIMIT_NOTIFICATION, 1);

        $businessIds = $this->Mbusinessprofiles->getListFieldValue(array('customer_id' => $data['customer']['id']), 'id');
        if(!empty($businessIds) && count($businessIds) > 0){
            $data['filterBusiness'] = $this->Mbusinessprofiles->getByNotification($businessIds);
        }
        
        //echo "<pre>";print_r($data['filterBusiness']);die;

        $this->load->view('frontend/notification/customer-notification', $data);
    }

    public function loadMore(){
        $postData = $this->arrayFromPost(array('customer_id', 'page'));

        $postData['page'] = $postData['page'] + 1;
        $searchData = array(
            'customer_id' => $postData['customer_id']
        );
        
        $lists = $this->getNotificationLists($searchData, DEFAULT_LIMIT_NOTIFICATION, $postData['page']);

        $notiHtml = "";
        foreach($lists as $itemNoti){
            $new = '';
            if ($itemNoti['notification_status_id'] == STATUS_ACTIVED) {
                $new = '<img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge" />';
            }
            $date = ddMMyyyy($itemNoti['created_at'], 'Y-m-d H:i');
            $notiHtml .= '<div class="notification-item">'.$new.'<div class="notification-img"><img src="'.$itemNoti['image'].'" alt="notification image" class="img-fluid"> </div> <div class="notification-body"> <p>'.$itemNoti['text'].'</p><span class="notification-date">'.$date.'</span></div></div>';
        }
        if(!empty($notiHtml)){
            $nextPage = $postData['page'];
        }else{
            $nextPage = 0;
        }
        
        echo json_encode(array('data' => $notiHtml, 'nextPage' => $nextPage));
    }
}
