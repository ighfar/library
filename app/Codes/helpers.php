<?php
if ( ! function_exists('create_slugs')) {
    function create_slugs($string)
    {
        $string = trim(strtolower($string));
        $string = preg_replace("/[^a-z0-9 -]/", "", $string);
        $string = preg_replace("/\s+/", "-", $string);
        $string = preg_replace("/-+/", "-", $string);
        $string = preg_replace("/[^a-zA-Z0-9]/", "-", $string);
        return $string;
    }
}

if ( ! function_exists('base64_to_jpeg'))
{
    function base64_to_jpeg($data) {
        $data = str_replace('data:image/jpeg;base64,', '', $data);
        $data = str_replace('[removed]', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);

        return $data;
    }
}

if ( ! function_exists('clear_money_format')) {
    function clear_money_format($money) {
        return preg_replace('/,/', '', $money);
    }
}

if ( ! function_exists('set_date_format')) {
    function set_date_format($date) {
        return date('Y-m-d', strtotime($date));
    }
}

if ( ! function_exists('clear_date_format')) {
    function clear_date_format($date) {
        return date('Y-m-d', strtotime($date));
    }
}

if ( ! function_exists('add_array_merge')) {
    function add_array_merge($arr1, $arr2) {
        foreach ($arr2 as $key => $value) {
            $arr1[$key] = $value;
        }
        return $arr1;
    }
}