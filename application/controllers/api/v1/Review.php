<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends MY_Controller { 

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

    public function leave_a_review() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin();
            $postData = $this->arrayFromPostApi(array('business_id', 'review_star', 'customer_comment'));
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model('Mcustomerreviews');
            $checkExit = $this->Mcustomerreviews->getFieldValue(array('customer_id' => $postData['customer_id'], 'business_id' => $postData['business_id']), 'id', 0);
            if($checkExit) {
                $this->error204('Customers already have left a review');
                die;
            }
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                if(empty($postData['review_star'])) $postData['review_star'] = 0;
                
                if(isset($_FILES['photo']) && !empty($_FILES['photo'])){
                    $file = $_FILES['photo'];
                    if ($file['error'] > 0) {
                        $this->error204('Photo upload failed');
                        die;
                    } else {
                        $names = explode('.', $file['name']);
                        $fileExt = strtolower($names[count($names) - 1]);
                        if(in_array($fileExt, array('jpeg', 'jpg', 'png', 'bmp', 'svg'))) {
                            $dir = REVIEW_PATH . date('Y-m-d') . '/';
                            @mkdir($dir, 0777, true);
                            @system("/bin/chown -R nginx:nginx " . $dir);
                            $filePath = $dir . uniqid() . '.' . $fileExt;
                            $flag = move_uploaded_file($file['tmp_name'], $filePath);
                            if ($flag) {
                                $photo = replaceFileUrl($filePath, REVIEW_PATH);
                                $postData['photo'] = $photo;
                                $postData['is_image'] = 1;
                            } else {
                                $this->error204('Upload photo failed');
                                die;
                            }
                        } else {
                            $this->error204($this->lang->line('the_image_is_not_in_the_correct_format_jpeg_jpg_png'));
                            die;
                        }
                    }
                }
                $postData['customer_review_status_id'] = STATUS_ACTIVED;
                $flag = $this->Mcustomerreviews->save($postData);
                if($flag) {
                    $this->success200('', $this->lang->line('successful_business_evaluation'));
                } else {
                    $this->error204($this->lang->line('unsuccessful_business_review'));
                    die;
                }
            } else {
                $this->error204('Business does not exist');
                die;
            }

        } catch (\Throwable $th) {
            $this->error500();
        }
    }



}