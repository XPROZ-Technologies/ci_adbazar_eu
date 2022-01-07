<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends MY_Controller { 

    function __construct() {
        parent::__construct();
        $this->getLanguageApi();
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
                if(!isset($postData['review_star'])) $postData['review_star'] = 0;
                if(empty($postData['review_star'])) $postData['review_star'] = 0;
                if(!isset($postData['customer_comment'])) {
                    $this->error204('customer_comment: not transmitted');
                    die;
                }
                if(empty($postData['customer_comment'])) {
                    $this->error204('Customer comment is not null');
                    die;
                }

                if(!empty($postData['customer_comment']) && strlen($postData['customer_comment']) <= 4) {
                    $this->error204('Review content must be above 4 characters');
                    die;
                }
                
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
                $postData['created_at'] = getCurentDateTime();
                $postData['created_by'] = $customer['customer_id'];
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

    public function leave_a_reply() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin();
            $postData = $this->arrayFromPostRawJson(array('business_id', 'review_id', 'business_comment'));

            $this->load->model('Mcustomerreviews');

            if(empty($postData['business_comment'])){
                $this->error204('Reply cannot blank');
                die;
            }
            
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                $flag = $this->Mcustomerreviews->save(array(
                    'business_comment' => $postData['business_comment'],
                    'updated_at' =>  getCurentDateTime(),
                    'updated_at' => $customer['customer_id']
                ), $postData['review_id']);
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

    public function delete_reply() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin();
            $postData = $this->arrayFromPostRawJson(array('business_id', 'review_id'));

            $this->load->model('Mcustomerreviews');
            
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                $flag = $this->Mcustomerreviews->save(array('business_comment' => "",  'updated_at' =>  getCurentDateTime()), $postData['review_id']);
                if($flag) {
                    $this->success200('', $this->lang->line('additional_successful1'));
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

    public function delete_review() {
        try {
            $this->openAllCors();
            $customer = $this->apiCheckLogin();
            $postData = $this->arrayFromPostRawJson(array('business_id', 'review_id'));

            $this->load->model('Mcustomerreviews');
            
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                $flag = $this->Mcustomerreviews->save(array('customer_review_status_id' => 0, 'updated_at' =>  getCurentDateTime(), 'updated_by' => $customer['customer_id']), $postData['review_id']);
                if($flag) {
                    $this->success200('', $this->lang->line('additional_successful1'));
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