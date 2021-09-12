<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mconstants extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public $roles = array(
        1 => 'Admin'
    );

    public $status = array(
        1 => 'Deactive',
        2 => 'Active',
    );

    public $genders = array(
        1 => 'Male',
        2 => 'Female'
    );

    public $languageIds = array(
        1 => 'English',
        2 => 'Czech republic',
        3 => 'Germany',
        4 => 'Viet Nam'
    );

    public $languageTexts = array(
        'en' => 'English',
        'cz' => 'Czech republic',
        'de' => 'Germany',
        'vi' => 'Viet Nam'
    );

    public $sliderTypeIds = array(
        1 => 'Slider',
        2 => 'Banner'
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


    public function selectConstants($key, $selectName, $itemId = 0, $isAll = false, $txtAll = 'All', $selectClass = '', $attrSelect = ''){
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

    public function selectObject($listObj, $objKey, $objValue, $selectName, $objId = 0, $isAll = false, $txtAll = "All", $selectClass = '', $attrSelect = ''){
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