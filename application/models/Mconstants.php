<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconstants extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public $keyMap =  'AIzaSyBy8Nn3utEHcAyEkA5gkrlIEKQt3EHsJRU';

    public $roles = array(
        1 => 'Admin'
    );

    public $status = array(
        2 => 'Đã duyệt',
        1 => 'Chưa duyệt',
        3 => 'Không được duyệt',
    );

    public $userStatus = array(
        2 => 'Hoạt động',
        1 => 'Khóa',
    );

    public $genders = array(
        1 => 'Nam',
        2 => 'Nữ'
    );

    public $languageIds = array(
        1 => 'Tiếng Việt',
        2 => 'Tiếng Anh'
    );

    // loại hình ảnh trong slider
    public $sliderKindIds = array(
        1 => 'Ảnh chính',
        2 => 'Ảnh phụ'
    );

    // Loại hình phục vụ
    public $typeIds = array(
        1 => 'Hotel',
        2 => 'Flight'
    );

    // Loại danh mục bài viết
    public $categoryTypeIds = array(
        1 => 'Danh mục bài viết cho Hotel',
        2 => 'Danh mục bài viết cho Flight',
    );

    public $labelCss = array(
        1 => 'label label-default',
        2 => 'label label-success',
        3 => 'label label-warning',
        4 => 'label label-danger',
        5 => 'label label-default',
        6 => 'label label-success',
        7 => 'label label-warning',
        8 => 'label label-danger',
        9 => 'label label-default',
        10 => 'label label-success',
        11 => 'label label-warning',
        12 => 'label label-danger'
    );

    public $isHome = array(
        0 => 'Không hiển thị',
        1 => 'Hiển thị'
    );

    public $airlineStatus = array(
        1 => 'Ngừng hợp tác',
        2 => 'Hoạt động'
    );

    public $orderStatus = array(
        0 => 'Nháp',
        1 => 'Đang Xử Lý',
        2 => 'Đã Book',
        3 => 'Đã Xuất Vé',
        4 => 'Đã Huỷ',
        5 => 'Hoàn Thành',
        6 => 'Thất Bại'
    );
    public $orderPaymentStatus = array(
        0 => 'Chưa Thanh Toán',
        1 => 'Đã Thanh Toán',
        2 => 'Thanh Toán Thất Bại',
        3 => 'Hết Hạn Thanh Toán',
        4 => 'Đang Hoàn Huỷ',
        5 => 'Đã Hoàn Tiền',
    );

    public $hfStatus = array(
        1 => 'Ngừng kích hoạt',
        2 => 'Kích hoạt'
    );

    public $hotelVendorID = array(
        1 => 'Travel Port',
        2 => 'EzCloud'
    );

    public $customerType = array(
        1 => 'Website',
        2 => 'Facebook',
        3 => 'Google'
    );

    public $discountType = array(
        1 => 'Giảm theo %',
        2 => 'Giảm theo tiền'
    );

    public function selectConstants($key, $selectName, $itemId = 0, $isAll = false, $txtAll = 'Tất cả', $selectClass = '', $attrSelect = ''){
        $obj = $this->$key;
        if($obj) {
            echo '<select class="form-control'.$selectClass.'" name="'.$selectName.'" id="'.lcfirst($selectName).'"'.$attrSelect.'>';
            if($isAll) echo '<option value="0">'.$txtAll.'</option>';
            foreach($obj as $i => $v){
                if($itemId == $i) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="'.$i.'"'.$selected.'>'.$v.'</option>';
            }
            echo "</select>";
        }
    }

    public function selectObject($listObj, $objKey, $objValue, $selectName, $objId = 0, $isAll = false, $txtAll = "Tất cả", $selectClass = '', $attrSelect = ''){
        $id = str_replace('[]', '', lcfirst($selectName));
        echo '<select class="form-control'.$selectClass.'" name="'.$selectName.'" id="'.$id.'"'.$attrSelect.'>';
        if($isAll) echo '<option value="0">'.$txtAll.'</option>';
       
        $isSelectMutiple = is_array($objId);
        foreach($listObj as $obj){
            $selected = '';
            if(!$isSelectMutiple) {
                if ($obj[$objKey] == $objId) $selected = ' selected="selected"';
            }
            elseif(in_array($obj[$objKey], $objId)) $selected = ' selected="selected"';
            echo '<option value="'.$obj[$objKey].'"'.$selected.'>'.$obj[$objValue].'</option>';
        }
        echo '</select>';
    }

    public function selectNumber($start, $end, $selectName, $itemId = 0, $asc = false, $attrSelect = ''){
        echo '<select class="form-control" name="'.$selectName.'" id="'.lcfirst($selectName).'"'.$attrSelect.'>';
        if($asc){
            for($i = $start; $i <= $end; $i++){
                if($i == $itemId) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
            }
        }
        else{
            for($i = $end; $i >= $start; $i--){
                if($i == $itemId) $selected = ' selected="selected"';
                else $selected = '';
                echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
            }
        }
        echo '</select>';
    }

    public function getObjectValue($listObj, $objKey, $objValue, $objKeyReturn, $returnObj = false){
        foreach($listObj as $obj){
            if($obj[$objKey] == $objValue){
                if($returnObj) return $obj;
                return $obj[$objKeyReturn];
            }
        }
        return $returnObj ? false : '';
    }
}