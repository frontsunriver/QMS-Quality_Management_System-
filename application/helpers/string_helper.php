<?php

function truncate($string, $length, $suffix = '...', $encoding = null, $asHtml = false) {
    $CI = & get_instance();
    if ($asHtml) {
//        return static::truncateHtml($string, $length, $suffix, $encoding ?: $CI->config->item('charset'));
    }

    if (mb_strlen($string, $encoding ?: $CI->config->item('charset')) > $length)
        return rtrim(mb_substr($string, 0, $length, $encoding ?: $CI->config->item('charset'))) . $suffix;
    else
        return $string;
}

function truncateHtml($string, $length, $suffix = '...', $encoding = false) {

}
