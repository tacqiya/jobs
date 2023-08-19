<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('dd')){
    function _e($content){
        echo '<pre>';
        print_r($content);
        echo '</pre>';
    }
}

function get_userid($type){
    $ci =& get_instance();
    return $ci->session->userdata('logged_'.strtolower($type))->id;
}

function arrayToObject($d){
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return (object) array_map(__FUNCTION__, $d);
    }
    else {
        // Return object
        return $d;
    }
}

function objectToArray($d){
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}