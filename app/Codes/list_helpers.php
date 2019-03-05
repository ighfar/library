<?php
if ( ! function_exists('get_list_active_inactive')) {
    function get_list_active_inactive()
    {
        return [
            0 => __('general.inactive'),
            1 => __('general.active')
        ];
    }
}
if ( ! function_exists('get_list_type_payment')) {
    function get_list_type_payment()
    {
        return [
            1 => __('general.full_payment'),
            2 => __('general.dp')
        ];
    }
}
if ( ! function_exists('get_list_type_setting')) {
    function get_list_type_setting()
    {
        return [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'textEditor' => 'Text Editor',
            'number' => 'Number',
            'email' => 'Email',
            'select' => 'Select',
            'image' => 'Image',
            'video' => 'Video',
        ];
    }
}