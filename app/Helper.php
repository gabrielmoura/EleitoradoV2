<?php

if (!function_exists('in_array_r')) {
    /**
     * @param $needle
     * @param $haystack
     * @param $strict
     * @return bool
     */
    function in_array_r($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('numberClear')) {
    /**
     * @param $number
     * @return string|string[]|null
     */
    function numberClear($number)
    {
        if ($number == null) return null;
        return preg_replace('/[^0-9]/', '', $number);
    }
}
if (!function_exists('resumo')) {
    /**
     * Resume uma string
     * @param string $string
     * @param int $chars
     * @return string
     */
    function resumo(string $string, int $chars): string
    {
        if (strlen($string) > $chars)
            return substr($string, 0, $chars) . '...';
        else
            return $string;
    }
}
if (!function_exists('temp_path')) {
    /**
     * @param $path
     * @return string
     */
    function temp_path($path = '')
    {
        return app()->storagePath('app/tmp/' . $path);
    }
}
