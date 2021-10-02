<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('outputScript')){
    function outputScript($scripts){
        if(is_array($scripts)){
            //$day = '201910232';
            foreach($scripts as $label=>$arr){
                if(is_array($arr)){
                    foreach($arr as $src){
                        if($label=='css') echo '<link href="assets/'.$src.'" rel="stylesheet"/>'."\n";
                        elseif($label=='js'){
                            if(strpos($src, 'http') !== false) echo '<script type="text/javascript" src="'.$src.'"></script>'."\n";
                            else echo '<script type="text/javascript" src="assets/'.$src.'"></script>'."\n";
                            //else echo '<script type="text/javascript" src="assets/'.$src.'?'.$day.'"></script>'."\n";
                        }
                    }
                }
                else{
                    $src = $arr;
                    if($label=='css') echo '<link href="assets/'.$src.'" rel="stylesheet"/>'."\n";
                    elseif($label=='js'){
                        if(strpos($src, 'http') !== false) echo '<script type="text/javascript" src="'.$src.'"></script>'."\n";
                        else echo '<script type="text/javascript" src="assets/'.$src.'"></script>'."\n";
                        //else echo '<script type="text/javascript" src="assets/'.$src.'?'.$day.'"></script>'."\n";
                    }
                }
            }
        }
    }
}                                      

if (!function_exists('dateToTime')){
    function dateToTime($dateStr, $dateFormat = "H:i"){
        if(!empty($dateStr) && $dateStr != '0000-00-00 00:00:00') return date_format(date_create(trim($dateStr)), $dateFormat);
        return '';
    }
}
if (!function_exists('ddMMyyyy')){
    function ddMMyyyy($dateStr, $dateFormat = "d/m/Y"){
        if(!empty($dateStr) && $dateStr != '0000-00-00 00:00:00') return date_format(date_create(trim($dateStr)), $dateFormat);
        return '';
    }
}
if (!function_exists('ddMMyyyyToDate')){
    function ddMMyyyyToDate($dateStr, $from = 'd/m/Y', $to = 'Y-m-d'){
        if(!empty($dateStr)) return date_format(date_create_from_format($from, trim($dateStr)), $to);
        return '';
    }
}

if (!function_exists('getCurentDateTime')){
    function getCurentDateTime(){
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('priceFormat')){
    function priceFormat($price, $formatDecimal = false){
        if($formatDecimal) $decimals = 2;
        else {
            $decimals = 0;
            if (strpos($price, ',00') !== false) $decimals = 0;
            if (strpos($price, ',0') !== false) $decimals = 0;
            elseif (strpos($price, ',') !== false) $decimals = 2;
        }
        $retVal = number_format($price, $decimals, '.', ',');
        if($formatDecimal && strpos($retVal, '.00') !== false) $retVal = substr($retVal, 0, strlen($retVal) - 3);
        return $retVal;
    }
}

if (!function_exists('replacePrice')){
    function replacePrice($price){
        return str_replace(',', '', $price);
    }
}

if (!function_exists('replaceFileUrl')){
    function replaceFileUrl($url, $filePath = IMAGE_PATH){
        $search = array($filePath);
        if(ROOT_PATH != '/' && ROOT_PATH != '//') $search[] = ROOT_PATH;
        return str_replace($search, '', $url);
    }
}

if (!function_exists('getFileUrl')){
    function getFileUrl($path, $url, $defaultUrl){
        if(empty($url)) return $defaultUrl;
        elseif(strpos($url, 'http') !== false) return $url;
        else return $path.$url;
    }
}

if (!function_exists('numberToHour')){
    function numberToHour($number){
        $minute = $number * 60;
        $hour = floor($minute / 60);
        $min = $minute - $hour * 60;
        return ($hour < 10 ? '0'.$hour : $hour) . ':' . ($min < 10 ? '0'.$min : $min);
    }
}

if (!function_exists('getListShiftDate')){
    function getListShiftDate($beginDate, $month, $days){
        $retVal = array();
        $today = date($beginDate);
        $endDate = date('Y-m-d', strtotime($today. ' + '.$month.' month'));
        for ($date = $today; $date <= $endDate; $date = date('Y-m-d', strtotime($date. ' + 1 days'))){
            if(in_array(date('w', strtotime($date)), $days)) $retVal[] = $date;
        }
        return $retVal;
    }
}

if (!function_exists('isWeekEnd')) {
    function isWeekEnd($date){
        return in_array(date('w', strtotime($date)), array(0, 6));
    }
}



if (!function_exists('makeSlug')){
    function makeSlug($string) {
        $table = array(
            'à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a', 'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a', 'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
            'À' => 'a', 'Á' => 'a', 'Ả' => 'a', 'Ã' => 'a', 'Ạ' => 'a', 'Ă' => 'a', 'Ắ'  => 'a', 'Ằ' => 'a', 'Ẳ' => 'a', 'Ẵ'  => 'a', 'Ặ' => 'a', 'Â' => 'a', 'Ầ' => 'a', 'Ấ' => 'a', 'Ẩ' => 'a', 'Ẫ' => 'a', 'Ậ' => 'a',
            'đ' => 'd', 'Đ' => 'd' ,
            'è' => 'e', 'é' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e', 'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
            'È' => 'e', 'É' => 'e', 'Ẻ' => 'e', 'Ẽ' => 'e', 'Ẹ' => 'e', 'Ê' => 'e', 'Ề' => 'e', 'Ế' => 'e', 'Ể' => 'e', 'Ễ' => 'e', 'Ệ' => 'e',
            'ì' => 'i', 'í' => 'i' , 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
            'Ì' => 'i', 'Í' => 'i', 'Ỉ' => 'i', 'Ĩ' => 'i', 'Ị' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o', 'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o', 'ơ'  => 'o', 'ờ' => 'o', 'ớ'  => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
            'Ò' => 'o', 'Ó' => 'o', 'Ỏ' => 'o', 'Õ' => 'o', 'Ọ' => 'o', 'Ô' => 'o', 'Ồ' => 'o', 'Ố' => 'o', 'Ổ' => 'o', 'Ỗ' => 'o', 'Ộ' => 'o', 'Ơ'  => 'o', 'Ờ' => 'o', 'Ớ' => 'o', 'Ở' => 'o', 'Ỡ' => 'o', 'Ợ'  => 'o',
            'ù' => 'u', 'ú' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u', 'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
            'Ù' => 'u', 'Ú' => 'u', 'Ủ' => 'u', 'Ũ' => 'u', 'Ụ' => 'u', 'Ư' => 'u', 'Ừ' => 'u', 'Ứ' => 'u', 'Ử' => 'u', 'Ữ' => 'u', 'Ự' => 'u',
            'ỳ' => 'y', 'ý' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
            'Ỳ' => 'y', 'Ý' => 'y', 'Ỷ' => 'y', 'Ỹ' => 'y', 'Ỵ' => 'y',
            '/' => '-', ' ' => '-'
        );
        preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);
        return strtolower(strtr($string, $table));
        // "( { -- 's "" "
    }
}

//HTML
if (!function_exists('sectionTitleHtml')){
    function sectionTitleHtml($title, $toolHtml = ''){ ?>
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title; ?></h3>
            <?php if(!empty($toolHtml)){ ?>
                <div class="box-tools pull-right">
                    <?php echo $toolHtml; ?>
                </div>
            <?php } ?>
        </div>
    <?php }
}

if (!function_exists('getPaggingHtml')){
    function getPaggingHtml($page, $pageCount, $functionJsName = 'pagging'){
        if($pageCount == 1) return '';
        $retVal = '<ul class="pagination pagination-sm no-margin pull-right">';
        if($page > 1){
            $retVal.='<li><a onclick="'.$functionJsName.'(\''.($page-1).'\')" href="javascript:void(0)">«</a></li>';
            $retVal.='<li><a onclick="'.$functionJsName.'(\'1\')" href="javascript:void(0)">1</a></li>';
        }
        else $retVal.='<li class="active"><a href="javascript:void(0)">1</a></li>';
        $start = ($page > 1)? ($page-1) : 1;
        if($start != 1) $retVal.='<li><a href="javascript:void(0)">...</a></li>';
        for($i= $start + 1; $i <= $page + 3 && $i <= $pageCount; $i++){
            if($i==$page) $retVal.='<li class="active"><a href="javascript:void(0)">'.$i.'</a></li>';
            else $retVal.='<li><a onclick="'.$functionJsName.'(\''.$i.'\')" href="javascript:void(0)">'.$i.'</a></li>';
        }
        if($page + 3 < $pageCount){
            $retVal.='<li><a href="javascript:void(0)">...</a></li>';
            $retVal.='<li><a onclick="'.$functionJsName.'(\''.($pageCount).'\')" href="javascript:void(0)">'.$pageCount.'</a></li>';
        }
        if($page < $pageCount) $retVal.='<li><a onclick="'.$functionJsName.'(\''.($page+1).'\')" href="javascript:void(0)">»</a></li>';
        $retVal.='</ul>';
        return $retVal;
    }
}
/*
if (!function_exists('getPaggingHtmlFront')){
    function getPaggingHtmlFront($page, $pageCount, $baseUrl){
        if($pageCount == 1) return '';
        $retVal = '<div class="page-phantrang"><ul class="list-inline">';
        if($page > 1){
            $retVal.='<li><a href="'.str_replace('{$1}', $page - 1, $baseUrl).'">|&lt;</a></li>';
            $retVal.='<li><a href="'.str_replace('{$1}', 1, $baseUrl).'">1</a></li>';
        }
        else $retVal.='<li class="active"><a href="javascript:void(0)">1</a></li>';
        $start = ($page > 1)? ($page-1) : 1;
        if($start != 1) $retVal.='<li><a href="javascript:void(0)">...</a></li>';
        for($i= $start + 1; $i <= $page + 3 && $i <= $pageCount; $i++){
            if($i==$page) $retVal.='<li class="active"><a href="javascript:void(0)">'.$i.'</a></li>';
            else $retVal.='<li><a href="'.str_replace('{$1}', $i, $baseUrl).'">'.$i.'</a></li>';
        }
        if($page + 3 < $pageCount){
            $retVal.='<li><a href="javascript:void(0)">...</a></li>';
            $retVal.='<li><a href="'.str_replace('{$1}', $pageCount, $baseUrl).'">'.$pageCount.'</a></li>';
        }
        if($page < $pageCount) $retVal.='<li><a href="'.str_replace('{$1}', $page + 1, $baseUrl).'">&gt;|</a></li>';
        $retVal.='</ul></div>';
        return $retVal;
    }
}
*/

if (!function_exists('getPaggingHtmlFront')){
    function getPaggingHtmlFront($page, $pageCount, $baseUrl){
        if($pageCount == 1) return '';
        $retVal = '<ul class="pagination justify-content-end mb-0">';
        if($page > 1){
            $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', $page - 1, $baseUrl).'"><i class="bi bi-chevron-left"></i></a></li>';
            $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', 1, $baseUrl).'">1</a></li>';
        }
        else $retVal.='<li class="page-item" class="active"><a class="page-link" href="javascript:void(0)">1</a></li>';
        $start = ($page > 1)? ($page-1) : 1;
        if($start != 1) $retVal.='<li class="page-item"><a class="page-link" href="javascript:void(0)">...</a></li>';
        for($i= $start + 1; $i <= $page + 3 && $i <= $pageCount; $i++){
            if($i==$page) $retVal.='<li class="page-item" class="active"><a class="page-link" href="javascript:void(0)">'.$i.'</a></li>';
            else $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', $i, $baseUrl).'">'.$i.'</a></li>';
        }
        if($page + 3 < $pageCount){
            $retVal.='<li class="page-item"><a class="page-link" href="javascript:void(0)">...</a></li>';
            $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', $pageCount, $baseUrl).'">'.$pageCount.'</a></li>';
        }
        if($page < $pageCount) $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', $page + 1, $baseUrl).'"><i class="bi bi-chevron-right"></i></a></li>';
        $retVal.='</ul>';
        return $retVal;
    }
}

if (!function_exists('getPaggingHtmlFront_2')){
    function getPaggingHtmlFront_2($page, $pageCount, $baseUrl){
        if($pageCount == 1) return '';
        $retVal = '<ul class="pagination justify-content-end mb-lg-0">';
        if($page > 1){
            $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', $page - 1, $baseUrl).'"><i class="bi bi-chevron-left"></i></a></li>';
            $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', 1, $baseUrl).'">1</a></li>';
        }
        else $retVal.='<li class="page-item" class="active"><a class="page-link" href="javascript:void(0)">1</a></li>';
        $start = ($page > 1)? ($page-1) : 1;
        if($start != 1) $retVal.='<li class="page-item"><a class="page-link" href="javascript:void(0)">...</a></li>';
        for($i= $start + 1; $i <= $page + 3 && $i <= $pageCount; $i++){
            if($i==$page) $retVal.='<li class="page-item" class="active"><a class="page-link" href="javascript:void(0)">'.$i.'</a></li>';
            else $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', $i, $baseUrl).'">'.$i.'</a></li>';
        }
        if($page + 3 < $pageCount){
            $retVal.='<li class="page-item"><a class="page-link" href="javascript:void(0)">...</a></li>';
            $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', $pageCount, $baseUrl).'">'.$pageCount.'</a></li>';
        }
        if($page < $pageCount) $retVal.='<li class="page-item"><a class="page-link" href="'.str_replace('{$1}', $page + 1, $baseUrl).'"><i class="bi bi-chevron-right"></i></a></li>';
        $retVal.='</ul>';
        return $retVal;
    }
}

if (!function_exists('preData')){
    function preData($data, $isDie = true){
        echo '<pre>'.print_r($data, true).'</pre>';
        if($isDie) die();
    }
}

if ( ! function_exists('guidV4'))
{
    function guidV4($tokenName)
    {
        // Microsoft guid {xxxxxxxx-xxxx-Mxxx-Nxxx-xxxxxxxxxxxx}
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        $data = openssl_random_pseudo_bytes(16);

        // set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);

        // set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        $data = $data.getCurentDateTime();

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data.$tokenName), 4));
    }
} 

if(!function_exists('callApi')) {
    function callApi($linkApi, $data, $httpHeader = ['Content-Type: application/json']){
        $curl = curl_init($linkApi); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if(is_array($data)) {
            $jsonDataEncoded = json_encode($data, JSON_UNESCAPED_UNICODE);
        } else $jsonDataEncoded = $data;
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt ($curl, CURLOPT_REFERER, $linkApi);
        if(curl_errno($curl)){
            curl_close($curl);
            return '';
        }
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}

if(!function_exists('callApi2')) {
    function callApi2($linkApi, $method = "GET"){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $linkApi,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        ));

        $result = curl_exec($curl);

        curl_close($curl);
        return $result;
    }
}
if(!function_exists('createRandomCode')) {
    function createRandomCode($length = 7) { 
        $chars = "0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323"; 
        srand((double)microtime()*1000000); 
        $i = 0; 
        $pass = '' ; 

        while ($i <= $length) { 
            $num = rand() % 33; 
            $tmp = substr($chars, $num, 1); 
            $pass = $pass . $tmp; 
            $i++; 
        } 

        return $pass; 

    } 
}
if(!function_exists('getYoutubeIdFromUrl')) {
    function getYoutubeIdFromUrl($url) {
        $parts = parse_url($url);
        if(isset($parts['query'])){
            parse_str($parts['query'], $qs);
            if(isset($qs['v'])){
                return $qs['v'];
            }else if(isset($qs['vi'])){
                return $qs['vi'];
            }
        }
        if(isset($parts['path'])){
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path)-1];
        }
        return false;
    }
}