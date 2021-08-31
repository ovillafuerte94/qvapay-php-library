<?php

if (!function_exists('isJson')) {
    /**
     * Check if a string is JSON
     *
     * @param string    $string
     * @return boolean
     */
    function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
