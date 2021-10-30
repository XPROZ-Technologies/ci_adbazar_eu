<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->getLanguageFE();
    }

    public function saveContactForm()
    {
        try {

            $postData = $this->arrayFromPost(array('contact_name', 'contact_email', 'contact_message', 'customer_id'));
            if (empty($postData['contact_name']) || empty($postData['contact_email']) || empty($postData['contact_message'])) {
                echo json_encode(array('code' => 0, 'message' => $this->lang->line('please-enter-your-contact-info1635566199')));
                die;
            }

            $this->loadModel(array('Mcontactus'));

            //save contact into db
            $customerContactId = $this->Mcontactus->save(array(
                'contact_name' => $postData['contact_name'],
                'contact_email' => $postData['contact_email'],
                'contact_message' => $postData['contact_message'],
                'customer_id' => $postData['customer_id'],
                'is_send' => 1,
                'created_at' => getCurentDateTime(),
                'created_by' => 0
            ));
            if ($customerContactId) {
                $customerName = array();
                if(!empty($postData['customer_id'])){
                    $this->load->model('Mcustomers');
                    $customerName = $this->Mcustomers->getFieldValue(array('id' => $postData['customer_id']), 'customer_first_name', "");
                }
                /**
                 * Save Email
                 */
                $this->load->model('Memailqueue');
                $dataEmail = array(
                    'contact_name' => $postData['contact_name'],
                    'contact_email' => $postData['contact_email'],
                    'contact_message' => $postData['contact_message'],
                    'customer_name' => $customerName
                );
                $emailResult = $this->Memailqueue->createEmail($dataEmail, 3);
                /**
                 * END. Save Email
                 */


                echo json_encode(array('code' => 1, 'message' => $this->lang->line('thank-you-for-contacting.-we-w1635566199')));
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
