<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coupon extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

       
        $this->getLanguageFE();

    }

    public function index()
    {
        $this->loadModel(array('Mcoupons', 'Mconfigs', 'Mservicetypes', 'Mbusinessprofiles', 'Mcustomercoupons', 'Mbusinessservicetype'));

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($this->lang->line('coupons'));
        $data['activeMenu'] = "coupons";
        /**
         * Commons data
         */
        $per_page = $this->input->get('per_page');
        $data['per_page'] =  $per_page;
        $search_text = $this->input->get('keyword');
        $data['keyword'] =  $search_text;
        $order_by = $this->input->get('order_by');
        $data['order_by'] =  $order_by;
        $serviceId = $this->input->get('service');
        $data['service'] =  $serviceId;
        $service_types = $this->input->get('service_types');
        $data['service_types'] = array();
        if(!empty($service_types)){
            $data['service_types'] =  explode(',', $service_types);
        }
        
        $savedCoupons = $this->Mcustomercoupons->getListFieldValue(array('customer_id' => $data['customer']['id'], 'customer_coupon_status_id >' => 0), 'coupon_id');

        $serviceIds = $this->Mbusinessprofiles->getListFieldValue(array('business_status_id >' => 0), 'service_id', 0);
        if (!empty($serviceIds)) $serviceIds = array_unique($serviceIds);

        if (!empty($serviceId)) {
            $businessProfileIds = $this->Mbusinessprofiles->getListFieldValue(array('service_id' => $serviceId), 'id', 0);
        } else {
            $businesses = $this->Mbusinessprofiles->search(array('service_ids' => $serviceIds));
            $businessProfileIds = array();
            foreach ($businesses as $itemBusiness) {
                $businessProfileIds[] = $itemBusiness['id'];
            }
        }
        
        //filter with service types
        if(!empty($data['service_types']) && count($data['service_types']) > 0){
            $listBusiness = $this->Mbusinessservicetype->search(array('service_type_ids' => $data['service_types']));
            $businessProfileIds = array();
            foreach ($listBusiness as $itemBusiness) {
                $businessProfileIds[] = $itemBusiness['id'];
            }
        }

        $getData = array(
            'coupon_status_id' => STATUS_ACTIVED,
            'search_text_fe' => $search_text,
            'saved_coupons' => $savedCoupons,
            'business_profile_ids' => $businessProfileIds,
            'order_by' => $order_by,
            'is_full' => 0
        );

        $data['businessProfiles'] = array();
        $data['serviceTypes'] = array();

        $data['listServices'] = $this->Mservices->getByIds(array('service_ids' => $serviceIds), $data['language_id']);
        if (!empty($serviceId) && $serviceId > 0) {
            $service_type_name = "service_type_name_" . $this->Mconstants->languageShortCodes[$data['language_id']];
            $data['serviceTypes'] = $this->Mservicetypes->getListByServices(array('service_id' => $serviceId), $service_type_name);
        }


        $rowCount = $this->Mcoupons->getCount($getData);
        $data['lists'] = array();

        /**
         * PAGINATION
         */
        $perPage = DEFAULT_LIMIT_COUPON;
        //$perPage = 2;
        if (is_numeric($per_page) && $per_page > 0) $perPage = $per_page;
        $pageCount = ceil($rowCount / $perPage);
        $page = $this->input->get('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $data['basePagingUrl'] = base_url('coupons.html');
        $data['perPage'] = $perPage;
        $data['page'] = $page;
        $data['rowCount'] = $rowCount;
        $data['paggingHtml'] = getPaggingHtmlFront($page, $pageCount, $data['basePagingUrl'] . '?page={$1}');
        /**
         * END - PAGINATION
         */

        $data['lists'] = $this->Mcoupons->search($getData, $perPage, $page);
        foreach ($data['lists'] as $kCoupon => $itemCoupon) {
            $data['lists'][$kCoupon]['coupon_amount_used'] = $this->Mcustomercoupons->getUsedCoupon($itemCoupon['id']);
        }

        $this->load->view('frontend/coupon/customer-coupon', $data);
    }

    public function detail($slug = '', $id = 0)
    {
        if (empty($id)) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                redirect(base_url('coupons.html'));
            }
        }

        $this->loadModel(array('Mconfigs', 'Mservices', 'Mbusinessprofiles', 'Mcoupons', 'Mcustomercoupons'));

        $couponId = $this->Mcoupons->getFieldValue(array('id' => $id, 'coupon_status_id' => STATUS_ACTIVED), 'id', 0);

        if ($couponId == 0) {
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                redirect(base_url('coupons.html'));
            }
        }

        $detailInfo = $this->Mcoupons->get($couponId);

        /**
         * Commons data
         */
        $data = $this->commonDataCustomer($detailInfo['coupon_subject']);
        $data['activeMenu'] = "coupons";
        /**
         * Commons data
         */

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != current_url()) {
            $data['backUrl'] = $_SERVER['HTTP_REFERER'];
        } else {
            $data['backUrl'] = base_url('coupons.html');
        }


        $data['detailInfo'] = $detailInfo;
        $data['detailInfo']['coupon_image'] = (!empty($data['detailInfo']['coupon_image'])) ? COUPONS_PATH . $data['detailInfo']['coupon_image'] : COUPONS_PATH . NO_IMAGE;
        $data['detailInfo']['coupon_amount_used'] = $this->Mcustomercoupons->getUsedCoupon($couponId);

        $data['businessInfo'] = $this->Mbusinessprofiles->get($data['detailInfo']['business_profile_id']);

        $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_id' => $data['customer']['id'], 'coupon_id' => $couponId, 'customer_coupon_status_id' => STATUS_ACTIVED), 'id', 0);

        $data['customerCoupon'] = array();
        if ($customerCouponId > 0) {
            $data['customerCoupon'] = $this->Mcustomercoupons->get($customerCouponId);
        }

        $this->load->view('frontend/coupon/um-coupon-detail', $data);
    }

    public function update()
    {
        try {
            $postData = $this->arrayFromPost(array('business_profile_id', 'coupon_subject', 'coupon_amount', 'coupon_description', 'start_date', 'end_date'));
            if (!empty($postData['business_profile_id'])  && !empty($postData['coupon_subject'])) {
                $couponId = $this->input->post('id');
                $this->load->model('Mcoupons');

                if(empty($postData['coupon_subject']) || $postData['coupon_subject'] == ""){
                    echo json_encode(array('code' => 0, 'message' => 'Coupon subject is required'));die;
                }

                $postData['start_date'] = date("Y-m-d", strtotime($postData['start_date']));
                $postData['end_date'] = date("Y-m-d", strtotime($postData['end_date']));

                $currentDay = strtotime(date('Y-m-d'));
                if(strtotime($postData['start_date']) < $currentDay || strtotime($postData['end_date']) < $currentDay){
                    echo json_encode(array('code' => 0, 'message' => 'Please select date in present or future'));die;
                }

                
                if(strtotime($postData['start_date']) > strtotime($postData['end_date'])){
                    echo json_encode(array('code' => 0, 'message' => 'Please select different date'));die;
                }

                /**
                 * Upload if customer choose image
                 */
                $couponImageUpload = $this->input->post('coupon_image_upload');
                if (!empty($couponImageUpload)) {
                    $imageUpload = $this->uploadImageBase64($couponImageUpload, 8);
                    $postData['coupon_image'] = replaceFileUrl($imageUpload, COUPONS_PATH);
                }

                $message = 'Create success';
                if ($couponId == 0) {
                    $postData['coupon_status_id'] = STATUS_ACTIVED;
                    $postData['created_by'] = 0;
                    $postData['created_at'] = getCurentDateTime();
                } else {
                    $message = 'Update successful';
                    $postData['updated_by'] = 0;
                    $postData['updated_at'] = getCurentDateTime();
                }

                $couponId = $this->Mcoupons->update($postData, $couponId);
                if ($couponId > 0) {
                    echo json_encode(array('code' => 1, 'message' => $message, 'data' => $couponId));die;
                } else {
                    echo json_encode(array('code' => 0, 'message' => "Create coupon failed"));die;
                }
            } else {
                echo json_encode(array('code' => -1, 'message' => "Please enter coupon information"));die;
            } 
        } catch (\Throwable $th) {
            echo json_encode(array('code' => -2, 'message' => ERROR_COMMON_MESSAGE));die;
        }
    }

    public function checkCouponCode()
    {
        try {
            $postData = $this->arrayFromPost(array('coupon_code', 'business_id'));
            if (!empty($postData['business_id'])  && !empty($postData['coupon_code'])) {
                $this->loadModel(array('Mconfigs', 'Mcoupons', 'Mcustomercoupons', 'Mbusinessprofiles'));

                $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_coupon_code' => $postData['coupon_code']), 'id', 0);
                if ($customerCouponId > 0) {
                    $customerCouponInfo = $this->Mcustomercoupons->get($customerCouponId);

                    $couponId = $this->Mcoupons->getFieldValue(array('id' => $customerCouponInfo['coupon_id'], 'business_profile_id' => $postData['business_id']), 'id', 0);
                    if ($couponId > 0) {
                        $couponInfo = $this->Mcoupons->get($couponId);
                        $currentDay = strtotime(date('Y-m-d'));
                        $couponStart = strtotime(ddMMyyyy($couponInfo['start_date'], 'Y-m-d'));
                        $couponEnd = strtotime(ddMMyyyy($couponInfo['end_date'], 'Y-m-d'));
                        if ($currentDay >= $couponStart && $currentDay <= $couponEnd) {
                            if ($customerCouponInfo['customer_coupon_status_id'] == STATUS_ACTIVED) {
                                echo json_encode(array('code' => 1, 'message' => "Can avtive"));
                                die;
                            }else if ($customerCouponInfo['customer_coupon_status_id'] == 1) {
                                echo json_encode(array('code' => 3, 'message' => "Used"));
                                die;
                            }
                        } else {
                            echo json_encode(array('code' => 3, 'message' => "Coupon expired"));
                            die;
                        }
                    } else {
                        echo json_encode(array('code' => 2, 'message' => "Coupon code not found"));
                        die;
                    }
                } else {
                    echo json_encode(array('code' => 2, 'message' => "Coupon code not found"));
                    die;
                }
            } else echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));
        } catch (\Throwable $th) {
            echo json_encode(array('code' => 2, 'message' => ERROR_COMMON_MESSAGE));
        }
    }

    public function activeCouponCode()
    {
        try {
            $postData = $this->arrayFromPost(array('coupon_code', 'business_id'));
            if (!empty($postData['business_id'])  && !empty($postData['coupon_code'])) {
                $this->loadModel(array('Mconfigs', 'Mcoupons', 'Mcustomercoupons', 'Mbusinessprofiles'));

                $customerCouponId = $this->Mcustomercoupons->getFieldValue(array('customer_coupon_code' => $postData['coupon_code']), 'id', 0);
                if ($customerCouponId > 0) {
                    $customerCouponInfo = $this->Mcustomercoupons->get($customerCouponId);

                    $couponId = $this->Mcoupons->getFieldValue(array('id' => $customerCouponInfo['coupon_id'], 'business_profile_id' => $postData['business_id']), 'id', 0);
                    if ($couponId > 0) {
                        $couponInfo = $this->Mcoupons->get($couponId);
                        $currentDay = strtotime(date('Y-m-d'));
                        $couponStart = strtotime(ddMMyyyy($couponInfo['start_date'], 'Y-m-d'));
                        $couponEnd = strtotime(ddMMyyyy($couponInfo['end_date'], 'Y-m-d'));
                        if ($currentDay >= $couponStart && $currentDay <= $couponEnd) {
                            if ($customerCouponInfo['customer_coupon_status_id'] == STATUS_ACTIVED) {
                                //save
                                $cusCouponCodeId = $this->Mcustomercoupons->save(array('customer_coupon_status_id' => 1), $customerCouponId);
                                if($cusCouponCodeId > 0){
                                    echo json_encode(array('code' => 1, 'message' => "Coupon ".$customerCouponInfo['customer_coupon_code']." activated"));
                                    die;
                                }else{
                                    echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));die;
                                }
                            }else if ($customerCouponInfo['customer_coupon_status_id'] == 1) {
                                echo json_encode(array('code' => 3, 'message' => "Used"));
                                die;
                            }
                        } else {
                            echo json_encode(array('code' => 3, 'message' => "Coupon expired"));
                            die;
                        }
                    } else {
                        echo json_encode(array('code' => 2, 'message' => "Coupon code not found"));
                        die;
                    }
                } else {
                    echo json_encode(array('code' => 2, 'message' => "Coupon code not found"));
                    die;
                }
            } else {
                echo json_encode(array('code' => 0, 'message' => ERROR_COMMON_MESSAGE));die;
            }
        } catch (\Throwable $th) {
            echo json_encode(array('code' => 2, 'message' => ERROR_COMMON_MESSAGE));
        }
    }
}
