<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends MY_Controller {

	public function upload(){
	    $this->checkUserLogin(true);
	    $fileBase64 = trim($this->input->post('FileBase64'));
	    $fileTypeId = $this->input->post('FileTypeId');
	    if(!empty($fileBase64) & $fileTypeId > 0){
            $fileBase64 = str_replace('[removed]', '', $fileBase64);
            $dir = '';
            $fileExt = 'png';
	        if($fileTypeId == 1) $dir = PRODUCT_PATH;
            elseif($fileTypeId == 2) $dir = USER_PATH;
	        elseif($fileTypeId == 3) $dir = IMAGE_PATH;
            elseif($fileTypeId == 4) $dir = SLIDER_PATH;
            elseif($fileTypeId == 5) $dir = CONFIG_PATH;
            elseif($fileTypeId == 6) $dir = SERVICE_PATH;
	        /*elseif($fileTypeId == 4){
	            $dir = FILE_PATH;
	            $fileExt = trim($this->input->post('FileExt'));
            }*/
            if(!empty($dir)){
                $dir = $dir . date('Y-m-d') . '/';
                // $dir = $dir . '2020-05-19/';
                @mkdir($dir, 0777, true);
                @system("/bin/chown -R nginx:nginx ".$dir);
                if($fileExt == 'png') $fileBase64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $fileBase64));
                else $fileBase64 = base64_decode(preg_replace('#^data:application/\w+;base64,#i', '', $fileBase64));
                $filePath = $dir . uniqid() . '.' . $fileExt;
                $flag = file_put_contents($filePath, $fileBase64);
                if($flag !== false) echo json_encode(array('code' => 1, 'data' => $filePath));
                else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
            }
            else echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
        }
        else echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
    }

    public function uploadNormal(){
	    $this->checkUserLogin(true);
        if(isset($_FILES['File']) && !empty($_FILES['File'])){
            $file = $_FILES['File'];
            if ($file['error'] > 0) echo json_encode(array('code' => -1, 'message' => ERROR_COMMON_MESSAGE));
            else {
                $names = explode('.', $file['name']);
                $fileExt = strtolower($names[count($names) - 1]);
                if(in_array($fileExt, array('jpeg', 'jpg', 'png', 'bmp', 'svg', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'ttf', 'otf', 'woff', 'bin'))) {
                    $dir = FILE_PATH . date('Y-m-d') . '/';
                    @mkdir($dir, 0777, true);
                    @system("/bin/chown -R nginx:nginx " . $dir);
                    $filePath = $dir . uniqid() . '.' . $fileExt;
                    $flag = move_uploaded_file($file['tmp_name'], $filePath);
                    if ($flag) echo json_encode(array('code' => 1, 'data' => $filePath));
                    else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
                }
                else echo json_encode(array('code' => -1, 'message' => "Invalid file"));
            }
        }
        else echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));
    }
}