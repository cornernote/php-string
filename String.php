<?php
/**
 * PHP String Helper
 *
 * Copyright (c) 2012 Brett O'Donnell <brett@mrphp.com.au>
 * Source Code: https://github.com/cornernote/php-string
 * Home Page: http://mrphp.com.au/blog/php-string-helper-class
 * License: GPLv3
 */
class String
{
    /**
     * @param $contents
     * @param $start
     * @param $end
     * @param bool $removeStart
     * @return string
     */
    public function getBetweenString($contents, $start, $end, $removeStart = false)
    {
        $startPos = strpos($contents, $start);
        $endPos = strpos($contents, $end, $startPos);
        if ($removeStart) {
            $startPos += strlen($start);
        }
        $len = $endPos - $startPos;
        $subString = substr($contents, $startPos, $len);
        return $subString;
    }

    /**
     * @static
     * @param $fileName
     * @return mixed
     */
    public static function getValidFileName($fileName)
    {
        $fileName = preg_replace('/[^0-9a-z ]+/i', '', $fileName);
        return $fileName;
    }

    /**
     * @static
     * @param $string
     * @return mixed|string
     */
    public static function slug($string)
    {
        $string = strtolower($string);
        $string = preg_replace('/[^0-9a-z ]/', '', $string);
        while (strpos($string, '  ') !== false) $string = str_replace('  ', ' ', $string);
        $string = str_replace(' ', '-', $string);
        return $string;
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function unserialize($string)
    {
        if (self::isSerialized($string)) {
            return unserialize($string);
        }
        return $string;
    }

    /**
     * @param $data
     * @return bool
     * @ref - http://stackoverflow.com/questions/1369936/check-to-see-if-a-string-is-serialized
     */
    public static function isSerialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (!is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (!preg_match('/^([adObis]):/', $data, $badions))
            return false;
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match("/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data))
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match("/^{$badions[1]}:[0-9.E-]+;\$/", $data))
                    return true;
                break;
        }
        return false;
    }
}