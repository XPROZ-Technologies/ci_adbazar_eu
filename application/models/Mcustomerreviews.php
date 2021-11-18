<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcustomerreviews extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "customer_reviews";
        $this->_primary_key = "id";
    }

    public function getCount($postData){
        $query = "customer_review_status_id > 0" . $this->buildQuery($postData);
        return $this->countRows($query);
    }

    public function search($postData, $perPage = 0, $page = 1){
        $query = "SELECT * FROM customer_reviews WHERE customer_review_status_id > 0" . $this->buildQuery($postData);

        if(isset($postData['order_by'])){
            $query .= " ORDER BY created_at ".$postData['order_by'];
        }else{
            $query .= " ORDER BY created_at DESC";
        }

        if($perPage > 0) {
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    private function buildQuery($postData){
        $query = '';

        if(isset($postData['customer_review_status_id']) && !empty($postData['customer_review_status_id']))  $query.=" AND customer_review_status_id = ".$postData['customer_review_status_id'];
        if(isset($postData['customer_id']) && !empty($postData['customer_id']))  $query.=" AND customer_id = ".$postData['customer_id'];
        if(isset($postData['business_id']) && !empty($postData['business_id']))  $query.=" AND business_id = ".$postData['business_id'];
        if(isset($postData['review_star']) && $postData['review_star'] == 6){
           $query.=" AND is_image = 1";
        }else if(isset($postData['review_star']) && !empty($postData['review_star'])){
            $query.=" AND review_star = ".$postData['review_star'];
        }

        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text_fe']) && !empty($postData['search_text_fe'])) $query .=" AND ( `business_name` LIKE '%{$postData['search_text_fe']}%' OR `business_description` LIKE '%{$postData['search_text_fe']}%')";
            if(isset($postData['business_id']) && $postData['business_id'] > 0) $query .=" AND `business_id` = ".$postData['business_id'];
        }
        

        return $query;
    }

    private function buildQueryApi($postData){
        $query = '';

        // xử lý điều kiện search cho api
        if(isset($postData['api']) && $postData['api'] == true) {
            if(isset($postData['search_text_fe']) && !empty($postData['search_text_fe'])) $query .=" AND ( `business_name` LIKE '%{$postData['search_text_fe']}%' OR `business_description` LIKE '%{$postData['search_text_fe']}%')";
            if(isset($postData['business_id']) && $postData['business_id'] > 0) $query .=" AND `business_id` = ".$postData['business_id'];
            if(isset($postData['review_star']) && $postData['review_star'] > 0) $query .=" AND `review_star` = ".$postData['review_star'];
            if(isset($postData['is_image']) && $postData['is_image'] > 0) $query .=" AND `is_image` = ".$postData['is_image'];
        }
        

        return $query;
    }

    public function getCountInApi($postData){
        $query = "customer_review_status_id = 2" . $this->buildQueryApi($postData);
        return $this->countRows($query);
    }

    public function getListInApi($postData, $perPage = 0, $page = 1) {
        $query = "SELECT * FROM customer_reviews WHERE customer_review_status_id = 2" . $this->buildQueryApi($postData). " ORDER BY created_at DESC";
        if($perPage > 0) { 
            $from = ($page-1) * $perPage;
            $query .= " LIMIT {$from}, {$perPage}";
        }
        return $this->getByQuery($query);
    }

    public function getRatingAndBusinesInfo($businessId = 0) {
        $query = "SELECT
                        ROUND(AVG(review_star),1) as overall_rating,
                        COUNT(CASE  WHEN customer_reviews.review_star = 1 THEN 1 END) as count_one_star,
                        COUNT(CASE  WHEN customer_reviews.review_star = 2 THEN 1 END) as count_two_star,
                        COUNT(CASE  WHEN customer_reviews.review_star = 3 THEN 1 END) as count_three_star,
                        COUNT(CASE  WHEN customer_reviews.review_star = 4 THEN 1 END) as count_four_star,
                        COUNT(CASE  WHEN customer_reviews.review_star = 5 THEN 1 END) as count_five_star,
                        business_profiles.id,
                        business_profiles.business_name,
                        business_profiles.business_avatar,
                        business_profiles.business_slogan,
                        business_profiles.business_image_cover
                
                FROM
                    `customer_reviews` 
                    LEFT JOIN business_profiles ON business_profiles.id = customer_reviews.business_id
                WHERE
                    customer_reviews.business_id = ? AND customer_reviews.customer_review_status_id = ?
                GROUP BY customer_reviews.business_id";
        $data = $this->getByQuery($query, array($businessId, STATUS_ACTIVED));
        if(count($data) > 0) return $data[0];
        return [];
    }
}