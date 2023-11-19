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

if (! function_exists('formatCurrency')) {
    function formatCurrency($value, string $currency, string $locale = 'pt-BR'): string
    {
        $cash = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        return $cash->formatCurrency($value, $currency);
    }
}

if (! function_exists('removeAccentsSpecialCharacters')) {
    function removeAccentsSpecialCharacters(string $string): string
    {
        // Remove acentos
        $string = preg_replace('/[áàãâä]/u', 'a', $string);
        $string = preg_replace('/[éèêë]/u', 'e', $string);
        $string = preg_replace('/[íìîï]/u', 'i', $string);
        $string = preg_replace('/[óòõôö]/u', 'o', $string);
        $string = preg_replace('/[úùûü]/u', 'u', $string);

        // Remove caracteres especiais e converte para minúsculas
        return strtolower(preg_replace('/[^a-z0-9:]/i', '', $string));
    }
}
