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
        $searchData = array(
            'customer_id' => $data['customer']['id'],
            'order_by' => $order_by
        );
        
        $data['lists'] = $this->getNotificationLists($searchData, 50, 1);

        $this->load->view('frontend/notification/customer-notification', $data);
    }
}
