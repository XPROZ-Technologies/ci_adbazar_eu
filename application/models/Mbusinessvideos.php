<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbusinessvideos extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table_name = "business_videos";
        $this->_primary_key = "id";
    }

    public function saveVideos($videoUrl = array(), $businessProfileId = 0)
    {
        if (!empty($videoUrl) && $businessProfileId > 0) {
            $arrVideos = array();
            $arrVideos = array();
            foreach ($videoUrl as $itemVideo) {
                $arrVideos[] = array(
                    'business_profile_id' => $businessProfileId,
                    'video_url' => $itemVideo,
                    'video_code' => getYoutubeIdFromUrl($itemVideo),
                    'created_at' => getCurentDateTime(),
                    'created_by' => 0, //customer upload
                    'updated_at' => getCurentDateTime(),
                    'updated_by' => 0  //customer upload

                );
            }

            if (!empty($arrVideos)) $this->db->insert_batch('business_videos', $arrVideos);
            return true;
        } else {
            return false;
        }
    }
}
