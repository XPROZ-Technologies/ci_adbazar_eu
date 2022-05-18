<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('callApiApple')) {
    function callApiApple($linkApi, $postData = array(), $method = "GET"){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $linkApi,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Accept-Encoding: gzip, deflate",
                "Content-Type: application/json",
                "cache-control: no-cache",
                "host: exp.host"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}