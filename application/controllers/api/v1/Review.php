<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
        $languageId = $this->input->get_request_header('language_id', TRUE);
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
            $postData = $this->arrayFromPostRawJson(array('business_id', 'photo', 'review_star', 'customer_comment'));
            $postData['customer_id'] = $customer['customer_id'];
            $this->load->model('Mcustomerreviews');
            $checkExit = $this->Mcustomerreviews->getFieldValue(array('customer_id' => $postData['customer_id'], 'business_id' => $postData['business_id']), 'id', 0);
            if($checkExit) {
                $this->error204('Customers have left a review');
                die;
            }
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                if(empty($postData['review_star'])) $postData['review_star'] = 0;
                
                if(isset($_FILES['File']) && !empty($_FILES['File'])){
                    $file = $_FILES['File'];
                    if ($file['error'] > 0) {
                        $this->error204('Avatar update failed');
                        die;
                    } else {
                        $names = explode('.', $file['name']);
                        $fileExt = strtolower($names[count($names) - 1]);
                        if(in_array($fileExt, array('jpeg', 'jpg', 'png', 'bmp', 'svg'))) {
                            $dir = BUSINESS_PROFILE_PATH . date('Y-m-d') . '/';
                            @mkdir($dir, 0777, true);
                            @system("/bin/chown -R nginx:nginx " . $dir);
                            $filePath = $dir . uniqid() . '.' . $fileExt;
                            $flag = move_uploaded_file($file['tmp_name'], $filePath);
                            if ($flag) {
                                $photo = replaceFileUrl($filePath, BUSINESS_PROFILE_PATH);
                                $postData['photo'] = $photo;
                                $postData['is_image'] = 1;
                            } else {
                                $this->error204('Avatar update failed');
                                die;
                            }
                        } else {
                            $this->error204('The image is not in the correct format: jpeg, jpg, png, bmp, svg');
                            die;
                        }
                    }
                }
                $flag = $this->Mcustomerreviews->save($postData);
                if($flag) {
                    $this->success200('', 'Successful business evaluation');
                } else {
                    $this->error204('Unsuccessful business review');
                    die;
                }
            } else {
                $this->error204('business_id does not exist');
                die;
            }

        } catch (\Throwable $th) {
            $this->error500();
        }
    }



}