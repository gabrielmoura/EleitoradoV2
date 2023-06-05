<?php

if (! function_exists('in_array_r')) {
    /**
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
if (! function_exists('numberClear')) {
    /**
     * @return string|string[]|null
     */
    function numberClear($number)
    {
        if ($number == null) {
            return null;
        }

        return preg_replace('/[^0-9]/', '', $number);
    }
}
if (! function_exists('resumo')) {
    /**
     * Resume uma string
     */
    function resumo(string $string, int $chars): string
    {
        if (strlen($string) > $chars) {
            return substr($string, 0, $chars).'...';
        } else {
            return $string;
        }
    }
}
if (! function_exists('temp_path')) {
    /**
     * @return string
     */
    function temp_path($path = '')
    {
        return app()->storagePath('app/tmp/'.$path);
    }
}
