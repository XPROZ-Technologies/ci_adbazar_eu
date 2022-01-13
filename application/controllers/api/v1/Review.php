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
            $this->load->model(array('Mcustomerreviews', 'Mcustomernotifications'));
            $checkExit = $this->Mcustomerreviews->getFieldValue(array('customer_id' => $postData['customer_id'], 'business_id' => $postData['business_id']), 'id', 0);
            if($checkExit) {
                $this->error204($this->lang->line('customers_have_left_a_review'));
                die;
            }

            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                if(!isset($postData['review_star'])) $postData['review_star'] = 0;
                if(empty($postData['review_star'])) $postData['review_star'] = 0;
                if(!isset($postData['customer_comment'])) {
                    $this->error204('customer_comment: '.$this->lang->line('not_transmitted'));
                    die;
                }
                if(empty($postData['customer_comment'])) {
                    $this->error204($this->lang->line('customer_comment_is_not_null'));
                    die;
                }

                if(!empty($postData['customer_comment']) && strlen($postData['customer_comment']) <= 4) {
                    $this->error204($this->lang->line('review_content_must_be_above_4_characters'));
                    die;
                }
                
                if(isset($_FILES['photo']) && !empty($_FILES['photo'])){
                    $file = $_FILES['photo'];
                    if ($file['error'] > 0) {
                        $this->error204($this->lang->line('photo_upload_failed'));
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
                                $this->error204($this->lang->line('photo_upload_failed'));
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

                    /**
                     * Add notification
                     */
                    $dataNoti = array(
                        'notification_type' => 0, //business has review
                        'customer_id'   => $customer['customer_id'],
                        'business_id'   => $postData['business_id'],
                        'item_id'   => $flag,
                        'notification_status_id'    => STATUS_ACTIVED,
                        'created_at' => getCurentDateTime()
                    );
                    $notificationId = $this->Mcustomernotifications->save($dataNoti);
                    /**
                     * END. Add notification
                     */

                    $this->success200('', $this->lang->line('successful_business_evaluation'));
                } else {
                    $this->error204($this->lang->line('unsuccessful_business_review'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('business_does_not_exist'));
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

            $this->load->model(array('Mcustomerreviews', 'Mcustomernotifications'));

            if(empty($postData['business_comment'])){
                $this->error204($this->lang->line('reply_cannot_be_blank'));
                die;
            }
            
            if(!empty($postData['business_id']) && $postData['business_id'] > 0) {
                $flag = $this->Mcustomerreviews->save(array(
                    'business_comment' => $postData['business_comment'],
                    'updated_at' =>  getCurentDateTime(),
                    'updated_by' => $customer['customer_id']
                ), $postData['review_id']);
                if($flag) {
                    /**
                     * Add notification
                     */
                    $dataNoti = array(
                        'notification_type' => 1, //business reply customer comment
                        'customer_id'   => $customer['customer_id'],
                        'business_id'   => $postData['business_id'],
                        'item_id'   => $postData['review_id'],
                        'notification_status_id'    => STATUS_ACTIVED,
                        'created_at'    => getCurentDateTime()
                    );
                    $notificationId = $this->Mcustomernotifications->save($dataNoti);
                    /**
                     * END. Add notification
                     */

                    $this->success200('', $this->lang->line('successful_business_evaluation'));
                } else {
                    $this->error204($this->lang->line('unsuccessful_business_review'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('business_does_not_exist'));
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
                $this->error204($this->lang->line('business_does_not_exist'));
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
                $flag = $this->Mcustomerreviews->save(array('customer_review_status_id' => STATUS_NUMBER_ZERO, 'updated_at' =>  getCurentDateTime(), 'updated_by' => $customer['customer_id']), $postData['review_id']);
                if($flag) {
                    $this->success200('', $this->lang->line('additional_successful1'));
                } else {
                    $this->error204($this->lang->line('unsuccessful_business_review'));
                    die;
                }
            } else {
                $this->error204($this->lang->line('business_does_not_exist'));
                die;
            }

        } catch (\Throwable $th) {
            $this->error500();
        }
    }

}