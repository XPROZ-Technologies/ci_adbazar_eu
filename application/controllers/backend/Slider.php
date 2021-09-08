<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends MY_Controller { 

    public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'List Slider',
            array('scriptFooter' => array('js' => 'js/backend/setting/slider.js'))
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'slider')) {
            $this->load->model('Msliders');
            $data['listSliders'] = $this->Msliders->getBy(array('slider_status_id' => STATUS_ACTIVED), false, 'display_order','', 0, 0, 'asc');
            $this->load->view('backend/setting/slider', $data);
        }
        else $this->load->view('backend/user/permission', $data);
    }

    public function update(){
        try {
            $user = $this->checkUserLogin();
            $postData = $this->arrayFromPost(array('slider_image','slider_url', 'display_order'));
            if(!empty($postData['slider_image'])) {
                $sliderId  = $this->input->post('id');
                if(empty($postData['slider_image'])) $postData['slider_image'] = NO_IMAGE;
                else $postData['slider_image'] = replaceFileUrl($postData['slider_image'], SLIDER_PATH);
                
                $message = "Slider update successful";
                if($sliderId == 0) {
                    $message = "Successfully added slider";
                    $postData['slider_status_id'] = STATUS_ACTIVED;
                    $postData['created_by'] = ($user) ? $user['id'] : 0;
                    $postData['created_at'] = getCurentDateTime();
                } else {
                    $postData['updated_by'] = ($user) ? $user['id'] : 0;
                    $postData['updated_at'] = getCurentDateTime();
                }
                
                $this->load->model('Msliders');
                $flag = $this->Msliders->update($postData, $sliderId);
                if ($flag > 0) {
                    echo json_encode(array('code' => 1, 'message' => $message));
                }
                else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
            }
            else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
        }
    }

    public function delete(){
        $user = $this->checkUserLogin();
        $sliderId  = $this->input->post('id');
        if($sliderId > 0){
            $this->load->model('Msliders');
            $flag = $this->Msliders->changeStatus(0, $sliderId, 'slider_status_id', $user['id'], 1);
            if($flag) echo json_encode(array('code' => 1, 'message' => 'Delete employee successfully.'));
            else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        }
        else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
    }

}