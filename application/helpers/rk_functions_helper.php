<?php

/*
* 	Format Number
*/
if (!function_exists('formatMobileNumber')){
    function formatMobileNumber($number,$plusPrepend = false){
        if(!empty($number)){
            $number = ltrim($number,'+');
            $number = ltrim($number,'00');
            $number = trim($number);
            //eliminate every char except 0-9
            $number = preg_replace("/[^0-9]/", '', $number);
            if($plusPrepend){
                $number = '+'.$number;
            }
        }
        return $number;
    }
}

/*
* 	debug
*/
if (!function_exists('debug')){
    function debug($data,$exit=0){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if($exit){
            exit;
        }
    }
}
/*
* 	encode string
*/
if (!function_exists('_encode')){
    function _encode($str){
        $str = base64_encode($str);
        $str = str_replace('=','gcc_ab',$str);
        $str = str_replace('Z','jazznju',$str);
        $str = gzcompress($str, 9);
        $str = strtr(base64_encode($str), '+/=', '._-');
        return urlencode($str);
    }
}
/*
* 	decode string
*/
if (!function_exists('_decode')){
    function _decode($str){
        $str = base64_decode(strtr(urldecode($str), '._-', '+/='));
        $str = gzuncompress($str);
        $str = str_replace('gcc_ab','=',$str);
        $str = str_replace('jazznju','Z',$str);

        $str = base64_decode($str);

        return $str;
    }
}
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

if (!function_exists('get_tz')){
    function get_tz($ip, $server_timezone = false, $default_timezone = 'America/New_York'){
        $ipAddress  = $ip;
        if ($server_timezone){
            $response = file_get_contents('https://www.cloudflare.com/cdn-cgi/trace');
            preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/",$response,$ip);
            $ipAddress     = isset($ip[0]) ? $ip[0]:file_get_contents("http://ipecho.net/plain");
        }

        $url    = 'http://ip-api.com/json/'.$ipAddress;
        $tz     = file_get_contents($url);
        $re     = json_decode($tz,true);
        $tz     = $default_timezone;//default timezone
        if($re['status'] != 'fail'){
            $tz = $re['timezone'];
        }
        return $tz;
    }
}